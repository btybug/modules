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

namespace Sahakavatar\Modules\Http\Controllers;

use Sahakavatar\Cms\Helpers\helpers;
use Sahakavatar\Cms\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Templates\Templates as Tpl;
use App\Models\Templates\Templates;
use App\Models\Themes\Themes;
use App\Modules\Resources\Models\Validation as validateUpl;
use App\Modules\Create\Models\Corepage;
use App\Modules\Modules\Models\UploadTheme;
use App\Modules\Settings\Models\Template;
use Assets;
use Datatables;
use File;
use Illuminate\Http\Request;
use Session;
use View;


/**
 * Class ThemeController
 * @package App\Modules\Modules\Http\Controllers
 */
class ThemeController extends Controller
{

    /**
     * @var
     */
    public $upplugin;
    /**
     * @var helpers|null
     */
    private $helpers = null;
    /**
     * @var null|string
     */
    private $rootpath = null;
    /**
     * @var null|string
     */
    private $index_path = null;
    /**
     * @var Templates|null
     */
    private $templates = null;
    /**
     * @var packegehelper|null
     */
    private $phelper = null;
    /**
     * @var mixed|string
     */
    private $tmp_upload = '';
    /**
     * @var dbhelper|string
     */
    private $dhelper = "";
    /**
     * @var
     */
    private $upload;
    /**
     * @var
     */
    private $validateUpl;
    /**
     * @var mixed
     */
    private $up;
    /**
     * @var mixed
     */
    private $tp;
    /**
     * @var
     */
    private $types;

    /**
     * ThemeController constructor.
     * @param UploadTheme $tplUpload
     * @param validateUpl $validateUpl
     */
    public function __construct (UploadTheme $tplUpload, validateUpl $validateUpl)
    {
        $this->helpers = new helpers;
        $this->rootpath = templatesPath();
        $this->index_path = "/admin/modules/theme";
        $this->tmp_upload = config('paths.modules_upl');
        $this->dhelper = new dbhelper;
        $this->upload = $tplUpload;
        $this->validateUpl = $validateUpl;
        $this->up = config('paths.modules_upl');
        $this->tp = config('paths.themesPath');
    }

    /**
     * @return View
     */
    public function getIndex ()
    {
        $active = Themes::getActive();
        $themes = Themes::all();
        return view('modules::theme.index', compact(['themes', 'active']));
    }

    /**
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activateFrontTheme ($slug)
    {
        Themes::setActive($slug);

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postNewType (Request $request)
    {
        $title = $request->get('title');
        $foldername = str_replace(' ', '', strtolower($title));
        $type = "body";
        $general = array_where($this->types, function ($value, $key) use ($type) {
            return ($value['foldername'] == $type);
        });
        $key = key($general);
        if (isset($general[$key]['subs'])) {
            $result = array_search($foldername, array_column($general[$key]['subs'], 'foldername'));
            if ($result === false) {
                $this->types[$key]['subs'][] = [
                    'title'      => $title,
                    'foldername' => $foldername,
                    'type'       => 'custom',
                ];
            } else {
                return redirect()->back()->with('message', 'Please enter new Type Title, "' . $title . '" type aleardy exist type!!!');
            }
        } else {
            $this->types[$key]['subs'][] = [
                'title'      => $title,
                'foldername' => $foldername,
                'type'       => 'custom',
            ];
        }

        $this->types[$key]['subs'] = array_values($this->types[$key]['subs']);
        File::put(config('paths.template_path') . 'configTypes.json', json_encode(['types' => $this->types], 1));
        File::makeDirectory($this->tp . $type . '/' . $foldername);
        File::put($this->tp . $type . '/' . $foldername . '/.gitignor', '');

        return redirect()->back()->with('message', 'New Type successfully created');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeleteType (Request $request)
    {
        $foldername = $request->get('folder');
        $type = "body";
        $general = array_where($this->types, function ($value, $key) use ($type) {
            return ($value['foldername'] == $type);
        });
        $key = key($general);

        if (isset($general[$key]['subs'])) {
            $result = array_search($foldername, array_column($general[$key]['subs'], 'foldername'));
            if ($result !== false) {
                $types = $general[$key]['subs'];
                unset($types[$result]);
                $general[$key]['subs'] = array_values($types);
                $this->types[$key] = $general[$key];
                File::put(config('paths.template_path') . 'configTypes.json', json_encode(['types' => $this->types], 1));
                if (File::isDirectory($this->tp . $type . '/' . $foldername)) {
                    File::deleteDirectory($this->tp . $type . '/' . $foldername);
                }

                return \Response::json(['error' => false]);
            }
        }


        return \Response::json(['message' => 'Please try again', 'error' => true]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postTemplatesWithType (Request $request)
    {
        $main_type = $request->get('main_type');
        $general_type = $request->get('type', null);

        if ($general_type) {
            $templates = Tpl::where('general_type', $general_type)->where('type', $main_type)->run();
        } else {
            $templates = Tpl::where('general_type', $main_type)->run();
        }

        $front_layout = true;

        if ($general_type or $main_type == 'body') {
            $html = View::make('modules::theme._partials.tpl_list_cube', compact(['templates', 'front_layout']))->render();
        } else {
            $html = View::make('modules::theme._partials.tpl_list', compact(['templates', 'front_layout']))->render();
        }


        return \Response::json(['html' => $html, 'error' => false]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postTemplatesInModal (Request $request)
    {
        $main_type = $request->get('main_type');
        $general_type = $request->get('type', null);

        if ($general_type) {
            $templates = Tpl::where('general_type', $general_type)->where('type', $main_type)->run();
        } else {
            $templates = Tpl::where('general_type', $main_type)->run();
        }
        $html = View::make('settings::frontend.templates._partrials.tpl_modal_list', compact(['templates']))->render();


        return \Response::json(['html' => $html, 'error' => false]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postTemplatesListByType (Request $request)
    {
        $main_type = $request->get('main_type');
        $general_type = $request->get('type', null);

        if ($general_type) {
            $templates = Tpl::where('general_type', $general_type)->where('type', $main_type)->run();
        } else {
            $templates = Tpl::where('general_type', $main_type)->run();
        }

        return \Response::json(['list' => $templates, 'error' => false]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postTemplatesVariations (Request $request)
    {
        $slug = $request->get('slug');
        $template = Tpl::find($slug);
        if (! $template) return \Response::json(['error' => true]);
        $variations = $template->variations();
        $html = View::make('settings::frontend.templates._partrials.variation_select')->with(['variations' => $variations])->render();

        return \Response::json(['list' => $html, 'selector' => $slug, 'error' => false]);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getTemplateRender ($slug)
    {
        return Tpl::find($slug)->render();
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getTemplateVRender ($slug)
    {
        return Tpl::findVariation($slug)->renderVariation();
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
     * @return mixed
     */
    public function postUpload (Request $request)
    {
        $isValid = $this->validateUpl->isCompress($request->file('file'));

        if (! $isValid) return $this->upload->ResponseError('Uploaded data is InValid!!!', 500);

        $response = $this->upload->upload($request);

        if (! $response['error']) {
            $result = $this->upload->validatConfAndMoveToMain($response['folder'], $response['data']);
            File::deleteDirectory($this->up, true);
            $this->upplugin = base_path() . '/app/Themes/' . $result['data']['namespace'];

            if (isset($result['data']['autoload'])) {
                $autoloadClass = 'App\Themes\\' . $result['data']['namespace'] . '\\' . $result['data']['autoload'];

                if (! class_exists($autoloadClass)) {
                    File::deleteDirectory(base_path() . '\app\Themes\\' . $result['data']['namespace']);

                    return ['message' => 'Autoload Class does not exists', 'code' => '500', 'error' => true];
                }

                $autoload = new $autoloadClass();
                try {
                    $autoload->up();
                } catch (\Exception $e) {
                    File::deleteDirectory(base_path() . '\app\Themes\\' . $result['data']['namespace']);

                    return ['message' => $e->getMessage(), 'code' => $e->getCode(), 'error' => true];
                }

            };

            if (File::exists(base_path() . '\app\Themes\\' . $result['data']['namespace'] . '\\' . $result['data']['route'])) {
                $response = $this->checkSyntax($this->upplugin . '\\' . $result['data']['route']);
                if ($response) {
                    if (isset($result['data']['autoload'])) {
                        $autoload->down();
                    }

                    File::deleteDirectory($this->upplugin);

                    return $response;
                }

                set_error_handler([$this, 'customError']);
                register_shutdown_function([$this, 'errorShutdownHandler']);

                try {
                    include base_path() . '\app\Themes\\' . $result['data']['namespace'] . '\\' . $result['data']['route'];
                } catch (\Exception $e) {
                    if ($e->getCode() != '-1') {
                        if (isset($result['data']['autoload'])) {
                            $autoload->down();
                        }
                        File::deleteDirectory(base_path() . '\app\Themes\\' . $result['data']['namespace']);

                        return ['message' => $e->getMessage(), 'code' => $e->getCode(), 'error' => true];
                    }
                }

                if (\Session::has('error')) {
                    $error = \Session::pull('error');
                    if (isset($result['data']['autoload'])) {
                        $autoload->down();
                    }

                    return ['message' => $error, 'code' => 500, 'error' => true];
                }

            }

            return $result;
        } else {
            File::deleteDirectory($this->up, true);

            return $response;
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
        $slug = $request->get('slug');
        $tpl = Themes::find($slug)->delete();

        return \Response::json(['message' => 'Please try again', 'error' => ! $tpl]);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|View
     */
    public function layoutPreview ($id)
    {
        $slug = explode('.', $id);
        $ui = Tpl::find($slug[0]);
        $variation = Tpl::findVariation($id);
        if (! $variation) return redirect()->back();
        $ifrem = [];
        $htmlSettings = "No Settings!!!";
        $settings = (isset($variation->settings) && $variation->settings) ? $variation->settings : [];
        $htmlBody = $ui->render(['settings' => $settings]);
        if ($ui->have_setting) {
            $htmlSettings = $ui->renderSettings(compact(['settings']));
        }
        $layout = $id;

        return view('modules::theme.edit_page_layout', compact(['htmlBody', 'htmlSettings', 'layout']));
    }

    /**
     * @param $id
     */
    public function iframeLayout ($id)
    {
        $slug = explode('.', $id);
        $ui = Tpl::find($slug[0]);
        $variation = Tpl::findVariation($id);
        if (! $variation) echo "warning";
        $settings = (isset($variation->settings) && $variation->settings) ? $variation->settings : [];
        $htmlBody = $ui->render(['settings' => $settings]);
        echo $htmlBody;
        die;
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function frontLayoutSettings ($id, Request $request)
    {

        $data = $this->getDataTpl($id);
        if (! $data) return "warning";
        $variation = $data['tpl'];
        $variation->render(['settings' => $request->all()]);

        return \Response::json(['error' => false]);
    }

    /**
     * @param $id
     * @param null $page_id
     * @param bool $edit
     * @return \Illuminate\Http\RedirectResponse|View
     */
    public function TemplatePerviewIframe ($id, $page_id = null, $edit = false)
    {
        $slug = explode('.', $id);
        $ui = Tpl::find($slug[0]);
        $variation = Tpl::findVariation($id);
        if (! $variation) return redirect()->back();
        $settings = (isset($variation->settings) && $variation->settings) ? $variation->settings : [];
        $page = Corepage::find($page_id);
        if ($page) {
            $page_data = @json_decode($page->data_option, true);
            $htmlBody = $ui->render(['settings' => $page_data]);
        } else {
            $htmlBody = $ui->render(['settings' => $settings]);
        }
        $htmlSettings = "No Settings!!!";
        if ($ui->has_setting) {
            $htmlSettings = $ui->renderSettings(compact(['settings']));
        }
        $settings_json = json_encode($settings, true);

        return view('settings::frontend.templates.ifpreview', compact(['htmlBody', 'htmlSettings', 'settings', 'settings_json', 'id', 'ui', 'edit']));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|View
     */
    public function TemplatePerviewEditIframe ($id)
    {
        $slug = explode('.', $id);
        $ui = Tpl::find($slug[0]);
        $variation = Tpl::findVariation($id);
        if (! $variation) return redirect()->back();
        $settings = (isset($variation->settings) && $variation->settings) ? $variation->settings : [];
        $settings_json = json_encode($settings, true);
        $htmlSettings = "No Settings!!!";

        if ($ui->have_setting) {
            $htmlSettings = $ui->renderSettings(compact(['settings']));
        }
        $htmlBody = $ui->render(['settings' => $settings]);
        $settings_json = json_encode($settings, true);

        return view('settings::frontend.templates.if_edit_preview', compact(['htmlBody', 'htmlSettings', 'settings_json', 'id', 'settings']));
    }


}
