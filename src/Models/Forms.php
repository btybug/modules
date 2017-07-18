<?php
/**
 * Created by PhpStorm.
 * User: shojan
 * Date: 11/27/2016
 * Time: 6:03 AM
 */

namespace Sahakavatar\Modules\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Forms
 * @package App\Modules\Modules\Models
 */
class Forms extends Model
{
    /**
     * @var string
     */
    public static $form_path = 'resources' . DS . 'views' . DS . 'forms' . DS;
    /**
     * @var string
     */
    public static $form_file_ext = '.blade.php';
    /**
     * @var string
     */
    protected $table = 'forms';
    /**
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * The attributes which using Carbon.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    public static function generateBlade($id, $blade)
    {
        $form = self::find($id);

        if ($form) {
            \File::put(self::$form_path . $form->slug . self::$form_file_ext, $blade);

            return true;
        }
        return false;
    }

    public function render()
    {
        if (\File::exists(self::$form_path . $this->slug . self::$form_file_ext)) {
            $content = \File::get(self::$form_path . $this->slug . self::$form_file_ext);

            return $this->searcer($content);
        }

        return null;
    }

    public function renderBlade()
    {
        if (\File::exists(self::$form_path . $this->slug . self::$form_file_ext)) {
            return \File::get(self::$form_path . $this->slug . self::$form_file_ext);
        }

        return null;
    }

    protected function searcer($content)
    {
        $this->conf = \config::get('shortcode.extra');
        foreach ($this->conf as $val) {
            $key = array_keys($val)[0];
            $fn = $val[$key];
            $content = $this->sortCoder($key, $fn, $content);
            $posCode = "[$key";
//            dd(strpos($content, $posCode));
            if (strpos($content, $posCode)) {
                $content = $this->searcer($content);
            }
        }
        return $content;
    }

    /**
     * @param $fn
     * @param $content
     * @return mixed
     */
    protected function sortCoder($key, $fn, $content)
    {
        $posCode = "[$key";
        $endLen = '';
        $pos = strpos($content, $posCode);
        if (!$pos) {
            return $content;
        }
        $pos = $pos + 1;
        for ($pos; $pos < strlen($content); $pos++) {
            if ($content[$pos] != ']') {
                $endLen .= $content[$pos];
            } else {
                break;
            }
        }
        $result = explode(' ', $endLen);

        //removing function name
        unset($result[0]);
        $final_arg = [];
        foreach (array_filter($result) as $key => $value) {
            $arg = explode('=', $value);
            if (isset($arg[0]) && isset($arg[1]))
                $final_arg[$arg[0]] = $arg[1];
        }
        $code = $fn($final_arg);
        $newContent = str_replace('[' . $endLen . ']', $code, $content);
        return $newContent;
    }

    public static function checkFields($json)
    {
        $fields = json_decode($json, true);
        $error = false;
        if (count($fields)) {
            foreach ($fields as $field) {
                if (!isset($field['table']) or !isset($field['columns']) or !$field['table'] or !$field['columns']) {
                    $error = true;
                } else {
                    if (!\Schema::hasTable($field['table']) or !\Schema::hasColumn($field['table'], $field['columns'])) {
                        $error = true;
                    }
                }
            }
        }

        return $error;
    }

    /**
     * @param $form_id
     * @param $table_name
     * @param $html
     */
    public static function synchronizeBlade($form, $html)
    {
        $fields = $form->fields->pluck('id', 'id')->toArray();
        $form_name = $form->id . "_" . $form->table_name . self::$form_file_ext;
        $form_path = base_path(self::$form_path) . $form_name;

        if (!\File::exists($form_path)) \File::put($form_path, "");

        if (count($fields)) {
            foreach ($fields as $value) {
                $start = strpos($html, "<!--$value-->");
                $end = strpos($html, "<!--end$value-->");
                $html = str_replace(substr($html, $start, ($end - $start)), "<!--$value-->" . '{!! BBRenderField(' . $value . ',$form) !!}', $html);
            }
        }

        \File::put($form_path, $html);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fields()
    {
        return $this->belongsToMany(Fields::class, 'form_fields', 'form_id', 'field_id');
    }

    /**
     * @return string
     */
//    public function render ()
//    {
//        $form = $this;
//
//        return \View::make('modules::developers.forms.render', compact(['form']))->render();
//    }

    /**
     * @param $form
     * @return null|string
     * @throws \Exception
     * @throws \Throwable
     */
//    public function renderBlade ($form)
//    {
//        $form_name = $form->id . "_" . $form->table_name;
//        if (\File::exists(base_path(static::$form_path) . $form_name . static::$form_file_ext)) {
//            return view('forms.' . $form_name, compact(['form']))->render();
//        }
//
//        return null;
//    }
}