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

use Chumper\Zipper\Zipper;
use File;

class Plugin
{

    private static $up = 'app/ExtraModules';
    /**
     * @var array
     */
    protected static $src = [
        'Database' => [
            'Migrations' => [],
            'Factories' => [],
            'Seeds' => []
        ],
        'Http' => [
            'Controllers' => [
                'modulecontroller.stub' => '{{controller}}Controller.php'
            ],
            'Middleware' => [],
        ],
        'Providers' => [
            'moduleserviceprovider.stub' => 'ModuleServiceProvider.php',
            'routeserviceprovider.stub' => 'RouteServiceProvider.php'
        ],
        'Routes' => [
            'web.stub' => 'web.php'
        ],
        'Resources' => [
            'Lang' => [],
            'Views' => [
                'index.stub' => 'index.blade.php'
            ]
        ],
        'manifest.stub' => 'module.json'
    ];
    /**
     * @var array
     */
    public static $settungs = [
        'settingsclass.stub' => '{{namespace}}Settings.php',
        'settings.stub' => '{{slug}}settings.blade.php'
    ];
    /**
     * @var array
     */
    protected static $paths = [
        'Database' => 'Database',
        'Migrations' => 'Database/Migrations',
        'Seeds' => 'Database/Seeds',
        'Factories' => 'Database/Factories',
        'Http' => 'Http',
        'Controllers' => 'Http/Controllers',
        'Middleware' => 'Http/Middleware',
        'Requests' => 'Http/Requests',
        'Routes' => 'Routes',
        'web.stub' => 'Routes/',
        'Providers' => 'Providers',
        'moduleserviceprovider.stub' => 'Providers/',
        'routeserviceprovider.stub' => 'Providers/',
        'Resources' => 'Resources',
        'Lang' => 'Resources/Lang',
        'Views' => 'Resources/Views',
        'manifest.stub' => '',
        'index.stub' => 'Resources/Views/',
        'modulecontroller.stub' => 'Http/Controllers/',
        'settingsclass.stub' => '',
        'settings.stub' => 'Resources/Views/'
    ];

    /**
     * @param $request
     * @return mixed
     */
    public static function makeModule($request)
    {
        File::makeDirectory(base_path() . '/app/Modules/Modules/Stub/Plugin/' . ucfirst($request['name']), 0775, true);
        $result = self::maker(self::$src, $request);
        if (isset($request['have_settings'])) {
            self::settings(self::$settungs, $request);
        }
        if ($result) {
            self::MakeZip(base_path('app/Modules/Modules/Stub/Plugin/' . ucfirst($request['name'])), ucfirst($request['name']));
            self::extract(ucfirst($request['name']));
            return true;
        }
    }


    /**
     * @param $schema
     * @param $request
     * @return bool
     */
    protected static function maker($schema, $request)
    {

        foreach ($schema as $key => $value) {

            if (is_array($value)) {
                File::makeDirectory(base_path() . '/app/Modules/Modules/Stub/Plugin/' . ucfirst($request['name']) . '/' . self::$paths[$key], 0775, true);
                self::maker($value, $request);
            } else {
                if(empty($request['class_controller'])) $request['class_controller'] = $request['name'];

                $value = str_replace('{{name}}', ucfirst($request['name']), $value);
                $value = str_replace('{{controller}}', ucfirst($request['class_controller']), $value);

                $file = base_path() . '/app/Modules/Modules/Stub/Plugin/' . $key;
                $dest = base_path() . '/app/Modules/Modules/Stub/Plugin/' . ucfirst($request['name']) . '/' . self::$paths[$key] . $value;
                if (File::copy($file, $dest)) {
                    $content = File::get($dest);
                    $content = str_replace('{{namespace}}', ucfirst($request['name']), $content);
                    $content = str_replace('{{controller}}', ucfirst($request['class_controller']), $content);
                    $content = str_replace('{{path}}', 'App\ExtraModules', $content);
                    $content = str_replace('{{sm_slug}}', strtolower($request['name']), $content);
                    $content = str_replace('{{name}}', $request['name'], $content);
                    $content = str_replace('{{version}}', $request['version'], $content);
                    $content = str_replace('{{description}}', $request['description'], $content);
                    $content = str_replace('{{author}}', $request['author'], $content);
                    $content = str_replace('{{author_site}}', $request['site'], $content);
                    $content = str_replace('{{slug}}', uniqid(), $content);
                    $content = str_replace('{{created_at}}', date('Y-m-d h:i:s'), $content);
                    if (isset($request['have_settings'])) {
                        $content = str_replace('{{setting}}', $request['have_settings'], $content);
                    }
                    $bytes_written = File::put($dest, $content);
                }
            }
        }

        return true;
    }

    /**
     * @param $schema
     * @param $data
     * @return bool
     */
    protected static function settings($schema, $data)
    {

        foreach ($schema as $key => $value) {
            $value = str_replace('{{namespace}}', ucfirst($data['name']), $value);
            $value = str_replace('{{slug}}', strtolower($data['name']), $value);
            $file = base_path() . '/app/Modules/Modules/Stub/Plugin/' . $key;
            $dest = base_path() . '/app/Modules/Modules/Stub/Plugin/' . ucfirst($data['name']) . '/' . self::$paths[$key] . $value;
            if (File::copy($file, $dest)) {
                $content = File::get($dest);
                $content = str_replace('{{namespace}}', ucfirst($data['name']), $content);
                $content = str_replace('{{path}}', 'App\ExtraModules', $content);
                $content = str_replace('{{sm_slug}}', strtolower($data['name']), $content);
                $bytes_written = File::put($dest, $content);
            }
        }
        return true;
    }

    /**
     * @param $schema
     * @param $data
     * @return bool
     */
    protected static function aSettings($schema, $data)
    {

        foreach ($schema as $key => $value) {
            $value = str_replace('{{namespace}}', $data['module'], $value);
            $value = str_replace('{{slug}}', $data['name'], $value);
            $file = base_path() . '/app/Modules/Packeges/src/' . $key;
            $dest = base_path() . '/app/Modules/Packeges/src/' . $data['name'] . '/' . self::$a_paths[$key] . $value;
            if (File::copy($file, $dest)) {
                $content = File::get($dest);
                $content = str_replace('{{namespace}}', $data['name'], $content);
                $content = str_replace('{{path}}', 'App\Modules', $content);
                $content = str_replace('{{slug}}', strtolower($data['name']), $content);
                $bytes_written = File::put($dest, $content);
            }
        }
        return true;
    }

    /**
     * @param $zipPath
     * @param $folder
     * @return mixed
     */
    private static function MakeZip($zipPath, $folder)
    {
        $zipper = new \Chumper\Zipper\Zipper;
        $files = glob($zipPath);
        $zipper->make($zipPath . '.zip')->folder($folder)->add($files);
        $zipper->close();

        File::copy($zipPath . '.zip', base_path(self::$up. '/' . $folder.'.zip'));
//
        if (is_dir($zipPath)) {
            File::deleteDirectory($zipPath);
        }

        if (is_file($zipPath . '.zip')) {
            File::delete($zipPath . '.zip');
        }

        return $zipPath;
    }

    private static function extract($folder){
        \Chumper\Zipper\Facades\Zipper::make(base_path(self::$up. '/' . $folder.'.zip'))->extractTo(base_path(self::$up. '/'));
        if (is_file(base_path(self::$up. '/' . $folder.'.zip'))) {
            File::delete(base_path(self::$up. '/' . $folder.'.zip'));
        }

    }

}
