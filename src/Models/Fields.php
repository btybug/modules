<?php
/**
 * Copyright (c) 2016.
 * *
 *  * Created by PhpStorm.
 *  * User: Edo
 *  * Date: 10/3/2016
 *  * Time: 10:44 PM
 *
 */

namespace Sahakavatar\Modules\Models;

use Sahakavatar\Cms\Models\Templates\Units;
use App\Modules\Users\User;
use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    const ACTIVE = 1;
    const INACTIVE = 1;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fields';

    protected $casts = [
        'json_data' => 'json'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * The attributes which using Carbon.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    public static function updateRecurcive($table, $column, $data)
    {
        if (isset($data['some-unit'])) {
            if (isset($data['field_id'])) {
                unset($data['field_id']);
            }
            $unitID = explode('.', $data['some-unit']);
            $unit = Units::find($unitID[0]);
        } else {
            return false;
        }
        $config_path = base_path('app/Modules/Modules/table_config.json');
        $config = (json_decode(\File::get($config_path), true));
        $field = self::where('table_name', $table)->where('column_name', $column)->first();
        if ($field) {
            if ($unit) {
                $data['unit_input_type'] = $unit->input_type;
            }
            return self::where('table_name', $table)->where('column_name', $column)->update(['json_data' => json_encode($data, true), 'type' => $unit->input_type]);
        }
        if (isset($config[$table])) {
            if (isset($config[$table][$column])
                and isset($config[$table][$column]['field'])
                and $config[$table][$column]['field'] != 'never'
            ) {

                if (isset($data['some-unit'])) {
                    $slug = explode('.', $data['some-unit']);
                    $unit = Units::find($slug[0]);

                    if ($unit) {
                        $data['unit_input_type'] = $unit->input_type;
                    }
                }

                $field = self::create([
                    'title' => "$column Field",
                    'table_name' => $table,
                    'column_name' => $column,
                    'type' => $unit->input_type,
                    'field' => $config[$table][$column]['field'],
                    'json_data' => json_encode($data, true),
                    'data_source' => isset($data['input_area']) ? $data['input_area'] : 'data_source',
                    'unit' => isset($data['some-unit']) ? $data['some-unit'] : null,
                ]);
                $form = Forms::where('table', $table)->first();
                return $form->fields()->attach($field);
            }
            if (!isset($config[$table][$column])) {
                if (isset($data['some-unit'])) {
                    $slug = explode('.', $data['some-unit']);
                    $unit = Units::find($slug[0]);

                    if ($unit) {
                        $data['unit_input_type'] = $unit->input_type;
                    }
                }

                $field = self::create([
                    'title' => "$column Field",
                    'table_name' => $table,
                    'column_name' => $column,
                    'type' => $unit->input_type,
                    'field' => "no",
                    'json_data' => json_encode($data, true),
                    'data_source' => isset($data['input_area']) ? $data['input_area'] : 'data_source',
                    'unit' => isset($data['some-unit']) ? $data['some-unit'] : null,
                ]);
                $form = Forms::where('table', $table)->first();
                return $form->fields()->attach($field);
            }
        };
    }

    public static function getUnconfiguredFields($table_name)
    {
        $data = [];
        $columns = self::realizeColumns($table_name);
        $existingCols = Fields::where('table_name', $table_name)->pluck('column_name', 'column_name')->toArray();
        if (count($columns)) {
            foreach ($columns as $column) {
                if ($column->field == 'no') {
                    if (!in_array($column->Field, $existingCols))
                        $data[] = $column;
                }
            }
        }

        return $data;
    }

    public static function realizeColumns($table_name)
    {
        $colums = \DB::select('SHOW COLUMNS FROM ' . $table_name);
        $config_path = base_path('app/Modules/Modules/table_config.json');
        $config = (json_decode(\File::get($config_path), true));
        $core = [];
        if (isset($config[$table_name]) && count($colums)) {
            foreach ($colums as $k => $colum) {
                if ($colum->Null == "NO") {
                    $colums[$k]->Null = 'required';
                } else {
                    $colums[$k]->Null = 'not required';
                };
                if (isset($config[$table_name][$colum->Field])) {
                    $core[$colum->Field] = 1;
                    $colums[$k]->field = $config[$table_name][$colum->Field]['field'];
                } else {
                    $colums[$k]->field = 'no';
                }
            }

            return $colums;
        }

        return [];
    }

    public function render($data = null)
    {
        $array2 = json_decode($this->json_data, true);
        if (!$array2) $array2 = [];
        $data = array_merge($array2, $data);
        return \View::make('modules::developers.forms.field')->with(['field' => $data])->render();
    }

    public function makeField($form = null)
    {
        if (is_null($this->unit)) {
            return "<a class='btn btn-warning' href='" . url('/admin/modules/tables/edit-column', [$this->table_name, $this->column_name]) . "'>Unconfigured Field, click on me to configure this field</a>";
        }
        $data = @json_decode($this->json_data, true);
        $data['unit'] = $this->unit;
        $data['field'] = $this;

        return \View::make('modules::developers.forms.makeField')->with([
            'form' => $form,
            'data' => $data])->render();
    }

    public function forms()
    {
        return $this->belongsToMany(Forms::class, 'form_fields', 'field_id', 'form_id');
    }

    public function allowed()
    {
        $data = $this->json_data;
        if (\Auth::check()) {
            $user = \Auth::user();
            if ($user->role) {
                if ($user->role_id == User::ROLE_SUPERADMIN || isset($data['allowed_roles']) && count($data['allowed_roles']) && in_array($user->role->slug, $data['allowed_roles'])) {
                    return true;
                }
            } elseif ($user->membership && isset($data['allow_membership']) && $data['allow_membership']) {
                if (isset($data['allowed_memberships']) && count($data['allowed_memberships']) && in_array($user->membership->slug, $data['allowed_memberships'])) {
                    return true;
                }
            }
        } else {
            if (isset($data['allow_guest']) && $data['allow_guest']) {
                return true;
            }
        }

        return false;
    }

    public function getFieldSelectedUnitName() {
        if($this->unit) {
            $unit = Units::findByVariation($this->unit);
            return $unit ? $unit->title : 'no';
        }
        return 'no';
    }

    public function getFieldSelectedHTMLUnitName() {
        if($this->custom_html) {
            $unit = Units::findByVariation($this->custom_html);
            return $unit ? $unit->title : 'no';
        }
        return 'no';
    }
}
