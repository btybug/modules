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

use App\Models\ExtraModules\Modules;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Caster\ExceptionCaster;
use App\Repositories\ModuleRepository as Module;
use App\helpers\helpers;
use App\Models\MenuData;
use Zipper,
    File;


class UploadTheme
{

    const ZIP = ".zip";
    public $uf;
    public $fileNmae;
    public $helper;
    public $generatedName;
    public $coreModule;

    public function __construct()
    {
        $modules = json_decode(File::get(storage_path('app/modules.json')));
        $this->helpers = new helpers;
        $this->uf = config('paths.modules_upl');
        $this->coreModule = $modules;
    }

    public function ResponseSuccess($data, $code, $links = null, $id = null)
    {
        return \Response::json(['data' => $data, 'invalid' => false, 'id' => $id, 'links' => $links, 'code' => $code, 'error' => false], $code);
    }

    public function ResponseInvalid($data, $code, $messages)
    {
        return \Response::json(['data' => $data, 'invalid' => true, 'messages' => $messages, 'code' => $code, 'error' => false], $code);
    }

    public function ResponseError($message, $code)
    {
        return \Response::json(['message' => $message, 'code' => $code, 'error' => true], $code);
    }

    public function upload(Request $request)
    {

        if ($request->hasFile('file')) {

            $extension = $request->file('file')->getClientOriginalExtension(); // getting image extension
            $zip_file = $request->file('file')->getClientOriginalName();
            $this->fileNmae = str_replace(self::ZIP, "", $zip_file);
            $request->file('file')->move($this->uf, $zip_file); // uploading file to given path

            try {
                $this->extract();
            } catch (Exception $e) {
                return ['message' => $e->getMessage(), 'code' => $e->getCode(), 'error' => true];
            }

            return ['folder' => $this->generatedName, 'data' => $this->fileNmae, 'code' => 200, 'error' => false];
        }
    }

    public function extract()
    {
        $fileName = $this->fileNmae;
        $this->generatedName = md5($fileName . microtime());
        File::makeDirectory($this->uf . $this->generatedName);
        Zipper::make($this->uf . "/" . $fileName . self::ZIP)->extractTo($this->uf . $this->generatedName . '/');
    }

    public function validatConfAndMoveToMain($folder, $name)
    {
        if (File::exists($this->uf . $folder . '/' . 'config.json')) {
            $file = $this->uf . $folder . '/' . 'config.json';
            $response =  $this->validateModule($file, $folder);
            if($response['error'])
                return $response;

            File::copyDirectory($this->uf . $folder, config('paths.themes').'/'. $response['data']['namespace']);
            return $response;
        } else {
            if (File::exists($this->uf . $folder . '/' . $name . '/' . 'config.json')) {
                $file = $this->uf . $folder . '/' . $name . '/' . 'config.json';
                $response =  $this->validateModule($file, $folder);
                if($response['error'])
                    return $response;

                File::copyDirectory($this->uf . $folder . '/' . $name , config('paths.themes').'/'. $response['data']['namespace']);
                return $response;
            }
        }

        return $this->uf . $folder . '/' . 'module.json';
    }

    private function validateModule($file, $key)
    {
        $conf = File::get($file);
        if ($conf) {
            $conf = json_decode($conf, true);
            if (!isset($conf['namespace']) && !isset($conf['type']))
                return ['message' => 'Namespace and type are required', 'code' => '404', 'error' => true];

            if (!isset($conf['settings_url']))
                return ['message' => 'Settings URL is required', 'code' => '404', 'error' => true];

            $conf['slug'] = $key;
            $conf['created_at'] = time();
            $json = json_encode($conf, true);
            File::put($file, $json);
            return ['data' => $conf,'code' => '200', 'error' => false];
        }

        return ['message' => 'Json file is empty !!!', 'code' => '404', 'error' => true];
    }

    public function validateForms($path){
        $forms = File::files($path . '\forms');
        $form_error = ['error' => false];
        if(count($forms) > 0){
            foreach($forms as $form){
                $form_result = PluginForms::checkDB($form);
                if($form_result['error']){
                    $form_error = $form_result;
                    break;
                }
            }
        }

        return $form_error;
    }

    public function deleteFolderZip($fileName)
    {
        File::deleteDirectory($this->uf . $fileName);
        File::delete($this->uf . $fileName . self::ZIP);
    }

    public function removeLinks($id)
    {
        $menu = MenuData::where('plugin_id', $id)->first();
        if ($menu) {
            $menu->delete();
        }
    }

    public function removeAddonLinks($admin_links, $plugin_id, $module_id)
    {
        $menu = MenuData::where('id', $module_id)->first();
        if ($menu->sub_items) {
            $links = json_decode($menu->sub_items, true);
            foreach ($links as $k => $v) {
                if (isset($v['data_id'])) {
                    if ($v['data_id'] == $plugin_id) {
                        unset($links[$k]);
                    }
                }
            }

            $menu->sub_items = json_encode($links, true);
            $menu->save();
        }
    }

    public function returnLinks($conf)
    {
        if (isset($conf['admin_link']['children'])) {
            $children = array();
            $links = array();
            $children = $conf['admin_link']['children'];
            foreach ($children as $child) {
                $links[] = $child['link'];
            }

            return $links;
        }
    }

    public function returnAddonLinks($conf)
    {
        if (isset($conf['admin_link'])) {
            $children = array();
            $links = array();
            $children = $conf['admin_link'];
            foreach ($children as $child) {
                $links[] = $child['link'];
            }

            return $links;
        }
    }
}
