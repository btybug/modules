<?php

namespace App\Modules\Modules\Http\Controllers;

use App\helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\ExtraModules\Modules;
use App\Models\ExtraModules\Structures;
use App\Modules\Modules\Models\Upload;
use App\Modules\Modules\Models\Validation as validateUpl;
use File;
use Illuminate\Http\Request;

/**
 * Class ModulesController
 * @package App\Modules\Modules\Http\Controllers
 */
class ModulesController extends Controller
{

    /**
     * @var Upload
     */
    public $upload;
    /**
     * @var validateUpl
     */
    public $validateUpl;
    /**
     * @var mixed
     */
    public $up;
    /**
     * @var mixed
     */
    public $mp;
    /**
     * @var
     */
    public $upplugin;
    /**
     * @var helpers
     */
    public $helper;
    /**
     * @var Module
     */
    protected $modules;

    /**
     * ModulesController constructor.
     * @param Module $module
     * @param Upload $upload
     * @param validateUpl $v
     */
    public function __construct (Upload $upload, validateUpl $v)
    {
        $this->upload = $upload;
        $this->validateUpl = $v;
        $this->up = config('paths.modules_upl');
        $this->mp = config('paths.extra_modules');
        $this->helper = new helpers();

//        BBRegisterAdminPages("Modules","Config","/admin/modules/config");
//        $this->MakeConfigPages("Users",581);
//        dd(5555555);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex ()
    {
        $modules = json_decode(File::get(storage_path('app/modules.json')));
        $extras = Structures::getExtraModules();
        if (count($modules)) {
            $module = $modules->Users;
        }
        if (! $module) return redirect()->back();
        $addons = BBGetModuleAddons($module->slug);

        return view('modules::list', compact(['modules', 'module', 'addons', 'extras']));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getView ($basename = null)
    {
        $extra = Structures::find($basename);
        $extras = Structures::getExtraModules();

        $modules = json_decode(File::get(storage_path('app/modules.json')));

        if (isset($modules->$basename)) {
            $module = $modules->$basename;
        } else {
            $module = null;
            if (count($modules) and ! $extra) {
                $module = $modules->Users;
            }
        }
        if ($extra) $module = $extra;
        if (! $module) return redirect()->back();
        $addons = BBGetModulePlugins($module->slug);

        return view('modules::list', compact(['modules', 'module', 'addons', 'extras']));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getExtra ($slug = null)
    {

        $modules = BBGetExtraModules();
        $addons = [];

        if ($slug) {
            $module = BBGetExtraModule($slug);
        } else {
            $module = null;
            if (count($modules)) {
                $module = $modules[0];
            }
        }

        if ($module) {
            $addons = BBGetModuleAddons($module->slug);
        }

        return view('modules::extra.extra', compact(['modules', 'module', 'addons']));

    }

    /**
     *
     */
    public function errorShutdownHandler ()
    {
        $last_error = error_get_last();
        if ($last_error['type'] === E_ERROR) {
            // fatal error
            $this->customError(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
        }

        if ($last_error['type'] === E_NOTICE) {
            return $this->customError(E_NOTICE, $last_error['message'], $last_error['file'], $last_error['line']);
        }
    }

    /**
     * @param $errno
     * @param $errstr
     * @param $file
     * @param $line
     */
    public function customError ($errno, $errstr, $file, $line)
    {
        File::deleteDirectory($this->upplugin);

        \Session::set('error', "<b>Error:</b> [$errno] $errstr<br> on line $line in $file file ");
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse|string
     */
    public function postUpload (Request $request)
    {

        $isValid = $this->validateUpl->isCompress($request->file('file'));

        if (! $isValid) return $this->upload->ResponseError('Uploaded data is InValid!!!', 500);

        $response = $this->upload->upload($request);

        if (! $response['error']) {
            $result = $this->upload->validatConfAndMoveToMain($response['folder'], $response['data']);
            File::deleteDirectory($this->up, true);
            if ($result['error']) return $result;

            switch ($result['data']['type']) {
                case 'plugin':
                    $structure = Structures::getStructure($result['data']['module']);
                    if ($structure) {
                        if ($structure->type == 'core') {
                            $this->upplugin = base_path() . '/app/Modules/' . ucfirst($result['data']['module']) . '/Plugins/' . $result['data']['namespace'];
                            $path = base_path() . '\app\Modules\\' . ucfirst($result['data']['module']) . '\Plugins\\' . $result['data']['namespace'];
                        } else {
                            $this->upplugin = base_path() . '/app/ExtraModules/' . ucfirst($result['data']['module']) . '/Plugins/' . $result['data']['namespace'];
                            $path = base_path() . '\app\ExtraModules\\' . ucfirst($result['data']['module']) . '\Plugins\\' . $result['data']['namespace'];
                        }
                    }
                    break;
                case 'addon':

                    break;
                case 'extra':
                    $this->upplugin = base_path() . '/app/ExtraModules/' . $result['data']['namespace'];
                    $path = base_path() . '\app\ExtraModules\\' . $result['data']['namespace'];
                    break;
            }

//            $form_result = $this->upload->validateForms($this->upplugin);

//            if ($form_result['error']) {
//                File::deleteDirectory($path);
//                return $form_result;
//            }
            if (isset($result['data']['autoload'])) {
                switch ($result['data']['type']) {
                    case 'plugin':
                        $structure = Structures::getStructure($result['data']['module']);
                        if ($structure) {
                            if ($structure->type == 'core') {
                                $autoloadClass = 'App\Modules\\' . ucfirst($result['data']['module']) . '\Plugins\\' . $result['data']['namespace'] . '\\' . $result['data']['autoload'];
                            } else {
                                $autoloadClass = 'App\ExtraModules\\' . ucfirst($result['data']['module']) . '\Plugins\\' . $result['data']['namespace'] . '\\' . $result['data']['autoload'];
                            }
                        }
                        break;
                    case 'addon':
                        break;
                    case 'extra':
                        $autoloadClass = 'App\ExtraModules\\' . $result['data']['namespace'] . '\\' . $result['data']['autoload'];
                        break;
                }


                if (! class_exists($autoloadClass)) {
                    File::deleteDirectory($path);

                    return ['message' => 'Autoload Class does not exists', 'code' => '500', 'error' => true];
                }

                $autoload = new $autoloadClass();
                try {
                    $autoload->up($result['data']);
                } catch (\Exception $e) {
                    File::deleteDirectory($path);

                    return ['message' => $e->getMessage(), 'code' => $e->getCode(), 'error' => true];
                }

            };

            if (File::exists($path . '\\' . $result['data']['route'])) {
                $response = $this->checkSyntax($this->upplugin . '\\' . $result['data']['route']);
                if ($response) {
                    if (isset($result['data']['autoload'])) {
                        $autoload->down($result['data']);
                    }

                    File::deleteDirectory($this->upplugin);

                    return $response;
                }

                set_error_handler([$this, 'customError']);
                register_shutdown_function([$this, 'errorShutdownHandler']);

                try {
                    include $path . '\\' . $result['data']['route'];
                } catch (\Exception $e) {
                    if ($e->getCode() != '-1') {
                        if (isset($result['data']['autoload'])) {
                            $autoload->down($result['data']);
                        }
                        File::deleteDirectory($path);

                        return ['message' => $e->getMessage(), 'code' => $e->getCode(), 'error' => true];
                    }
                }

                if (\Session::has('error')) {
                    $error = \Session::pull('error');
                    if (isset($result['data']['autoload'])) {
                        $autoload->down($result['data']);
                    }

                    return ['message' => $error, 'code' => 500, 'error' => true];
                }

            }

//            PluginForms::registration($this->upplugin,$result['data']['slug']);
            Structures::create($result['data']);
            \Artisan::call('plugin:optimaze');
            if($result['data']['type'] == 'extra'){
                $this->MakeConfigPages($result['data']['namespace']);
            }

            return $result;
        } else {
            File::deleteDirectory($this->up, true);


            return $response;
        }
    }

    private function MakeConfigPages ($moduleName,$id = null)
    {
        $menu= base_path('app/Modules/Modules/menuPages.json');
        $menu = json_decode(\File::get($menu),true);
        $row = BBRegisterAdminPages("Modules",$moduleName,"/admin/modules/config/".$moduleName,null,$id);
        foreach($menu['items'] as $item){
            $url = str_replace('here',$moduleName,$item['url']);
            $parent = BBRegisterAdminPages("Modules",$moduleName." ".$item['title'],$url,null,$row->id);
            if(isset($item['childs']) && count($item['childs'])){
                foreach($item['childs'] as $ch){
                    echo $ch ."--".$item['title']."</br>";
                    BBRegisterAdminPages("Modules",$moduleName." ".$item['title']."-".$ch,$url."/".$ch,null,$parent->id);
                }
            }
        }
    }

    /**
     * @param $fileName
     * @return array|bool
     */
    public function checkSyntax ($fileName)
    {
        // Sort out the formatting of the filename
        $fileName = realpath($fileName);

        // Get the shell output from the syntax check command
        $output = shell_exec('php -l "' . $fileName . '"');

        // Try to find the parse error text and chop it off
        $syntaxError = preg_replace("/Errors parsing.*$/", "", $output, -1, $count);

        // If the error text above was matched, return the message containing the syntax error
        if ($count > 0) {
            return ['message' => trim($syntaxError), 'code' => 500, 'error' => true];
        }

        return false;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete (Request $request)
    {
        $namespace = $request->get('namespace');
        if (Modules::findByNamespace($namespace)->deleteWithAddons()) {
            \Artisan::call('plugin:optimaze');

            return \Response::json(['error' => false], 200);
        }

        return \Response::json(['message' => 'Please try again', 'error' => true]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCoreEnable (Request $request)
    {
        $namespace = $request->get('namespace');
        $module = Structures::find($namespace);

        if ($module) {
            $module->enable();
            \Artisan::call('plugin:optimaze');

            return \Response::json(['error' => false], 200);
        }

        return \Response::json(['message' => 'Please try again', 'error' => true]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEnable (Request $request)
    {
        $namespace = $request->get('namespace');
        $module = Modules::findByNamespace($namespace);
        if ($module->type == 'addon') {
            $parent = $module->parent();
            if (! $parent->enabled) {
                return \Response::json(['message' => 'Please activate ' . $parent->name . ' plugin first', 'error' => true]);
            }
        }
        if (Modules::findByNamespace($namespace)->enable()) {
            \Artisan::call('plugin:optimaze');

            return \Response::json(['error' => false], 200);
        }

        return \Response::json(['message' => 'Please try again', 'error' => true]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDisable (Request $request)
    {
        $namespace = $request->get('namespace');
        $module = Structures::find($namespace);
        if ($module) {
            $module->disable();
            \Artisan::call('plugin:optimaze');

            return \Response::json(['error' => false], 200);
        }

        return \Response::json(['message' => 'Please try again', 'error' => true]);
    }
}
