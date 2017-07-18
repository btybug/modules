<?php

namespace Sahakavatar\Modules\Http\Controllers;

use App\helpers\dbhelper;
use App\helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\ContentLayouts\ContentLayouts as AdminTemplates;
use App\Models\ContentLayouts\ContentLayouts;
use App\Models\Setting;
use App\Models\Templates\Units;
use App\Modules\Modules\Models\AdminPages;
use App\Modules\Create\Models\Corepage;
use App\Modules\Modules\Models\Fields;
use App\Modules\Modules\Models\Forms;
use App\Modules\Modules\Models\Routes;
use App\Modules\Users\Models\Roles;
use Illuminate\Http\Request;
use File;

/**
 * Class ModulesController
 * @package App\Modules\Modules\Http\Controllers
 */
class ConfigController extends Controller
{

    /**
     * @var
     */
    public $modules;
    /**
     * @var dbhelper
     */
    private $dbhelper;
    private $helpers;

    private $up;
    private $types;

    /**
     * ConfigController constructor.
     */
    public function __construct()
    {
        $this->helpers = new helpers();
        $this->dbhelper = new dbhelper();
        $this->up = config('paths.modules_path');
        $this->types = @json_decode(File::get(config('paths.unit_path') . 'configTypes.json'), 1)['types'];
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getAssets($slug)
    {
        $modules = json_decode(\File::get(storage_path('app/modules.json')));
        if (!$modules->$slug) return redirect()->back();
        $module = $modules->$slug;
        $page_menu="configMenu";
        return view('modules::config.assets', compact(['slug', 'module','page_menu']));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getInfo($slug)
    {
        //$this->MakeConfigPages($slug);

        $modules = json_decode(\File::get(storage_path('app/modules.json')));
        if (!$modules->$slug) return redirect()->back();
        $module = $modules->$slug;
        $page_menu="configMenu";
        return view('modules::config.info', compact(['slug', 'module','page_menu']));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getTables($slug, $active = 0)
    {
        $modules = json_decode(\File::get(storage_path('app/modules.json')));
        if (!$modules->{$slug}) return redirect()->back();
        $module = $modules->{$slug};
        $createForm = null;
        if (isset($module->tables) and isset($module->tables[$active]))
            $createForm = Forms::where('table_name', $module->tables[$active])->first();
        $page_menu="configMenu";
        return view('modules::config.table', compact(['slug', 'module', 'active', 'createForm','page_menu']));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getForm($slug)
    {
        $modules = json_decode(\File::get(storage_path('app/modules.json')));
        if (!$modules->$slug) return redirect()->back();

        $module = $modules->$slug;
        $page_menu="configMenu";

        return view('modules::config.form', compact(['slug', 'module','page_menu']));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getPermission($slug)
    {
        $modules = json_decode(\File::get(storage_path('app/modules.json')));
        if (!$modules->$slug) return redirect()->back();
        $module = $modules->$slug;
        $menu = BBgetAdminMenu($slug);
        $roles = Roles::pluck('id', 'name');

        $files = helpers::rglob('app/Modules/'.$slug.'/Resources/Views');
        $page_menu="permission";
        return view('modules::config.permissions', compact(['slug', 'module', 'menu', 'roles','files','page_menu']));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getCodes($slug)
    {
        $modules = json_decode(\File::get(storage_path('app/modules.json')));
        if (!$modules->$slug) return redirect()->back();
        $module = $modules->$slug;

        $files = \File::allFiles($this->up . $module->name);
        $file_indexes = [];
        foreach ($files as $file) {
            $f = [];
            $f['full_path'] = $file;
            $file = substr($file, strpos($file, "/" . $module->name) + 1);
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $f['path'] = $file;
            $f['ext'] = $ext;
            if (!strpos($file, 'module.json')) {
                $file_indexes[] = $f;
            }
        }

        return view('modules::config.codes', compact(['slug', 'module', 'file_indexes']));
    }

    public function postCodes(Request $request)
    {
        $path = $request->get('path');
        $editor = $request->get('editor');

        if (\File::exists($path) && \File::isFile($path)) {
            file_put_contents($path, $request->get('editor'));
            $this->helpers->updatesession('File Updated');
        } else {
            $this->helpers->updatesession('File not Found', 'alert-danger');
        }

        return redirect()->back();
    }

    public function getFileContent(Request $request)
    {
        $file = $request->get('file');
        if (!\File::exists($file) && !\File::isFile($file)) {
            $this->helpers->updatesession('File not Found', 'alert-danger');

            return \Response::json(['data' => '', 'error' => true]);
        }
        $file = \File::get($file);

        return \Response::json(['data' => $file, 'error' => false]);
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getViews($slug)
    {
        $modules = json_decode(\File::get(storage_path('app/modules.json')));
        if (!$modules->$slug) return redirect()->back();
        $module = $modules->$slug;

        $layouts = AdminTemplates::findByType('admin_template');

        return view('modules::config.views', compact(['slug', 'module', 'layouts']));
    }

    public function getMenus($slug)
    {
        $menu = BBgetAdminMenu($slug);
        $modules = json_decode(\File::get(storage_path('app/modules.json')));
        if (!$modules->$slug) return redirect()->back();
        $module = $modules->$slug;
        $layouts = AdminTemplates::findByType('admin_template');

        return view('modules::config.menus', compact(['slug', 'module', 'layouts', 'menu']));
    }

    public function editDefaultMenu($slug, $menu)
    {
        $menu = BBgetAdminMenu($slug);
        $roles = Roles::pluck('id', 'name');
        return view('modules::config.menu_permission', compact(['slug', 'menu', 'roles']));
    }

    public function getTestView()
    {

        return view('modules::forms.mytest');
    }

    public function getGears($slug)
    {
        $types = $this->types;
        $type = 'frontend';
        $ui_units = Units::getAllUnits()->where('section', $type)->run();

        return view('modules::config.gears', compact(['slug', 'ui_units', 'type', 'types']));
    }

    public function getGearsB($slug)
    {
        $types = $this->types;
        $type = 'backend';
        $ui_units = Units::getAllUnits()->where('section', $type)->run();

        return view('modules::config.gears_b', compact(['slug', 'ui_units', 'type', 'types']));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getBuild($slug)
    {
        $page = new Corepage();
        $type = 'core';
        $pages = $page->getPages();
        return view('modules::config.build', compact(['pages', 'type', 'slug']));
    }

    public function getBuildB($slug, Request $request)
    {
        $pageID = $request->get('page');

        $modules = json_decode(\File::get(storage_path('app/modules.json')));
        if (!$modules->$slug) return redirect()->back();
        $module = $modules->$slug;

        $pageGrouped = AdminPages::groupBy('module_id')->get();
        $pages = AdminPages::pluck('title', 'id')->all();
        $modulesList = array($module);
        $type = 'pages';
        $layouts = ContentLayouts::pluck('slug', 'name');

        if ($pageID) {
            $page = AdminPages::find($pageID);
        } else {
            $page = AdminPages::where('module_id', $slug)->first();
        }
        if (!$page->layout_id) $page->layout_id = 0;
        return view('modules::config.build_b', compact(['pageGrouped', 'pages', 'modulesList', 'layouts', 'module', 'slug', 'type', 'layouts', 'page']));
    }

    public function getBuildBMenus($slug)
    {
        $modules = json_decode(\File::get(storage_path('app/modules.json')));
        if (!$modules->$slug) return redirect()->back();
        $module = $modules->$slug;
        $type = 'menus';
        $pages = AdminPages::where('module_id', $slug)->where('parent_id', 0)->get();

        return view('modules::config.menus', compact(['module', 'slug', 'type', 'pages']));
    }

    public function postMenus(Request $request)
    {
        $url = $request->get('data_url');
        $page = AdminPages::where('url', $url)->first();
        $menus = $page->childs;
        $html = \View::make('modules::_partials.menus', compact('menus'))->render();
        return \Response::json(['error' => false, 'html' => $html]);


    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getFields($slug)
    {
        $modules = json_decode(\File::get(storage_path('app/modules.json')));
        if (!$modules->$slug) return redirect()->back();
        $module = $modules->$slug;
        $fields = Fields::whereIn('table_name', $module->tables)->get();

        return view('modules::config.fields', compact(['slug', 'fields']));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateField()
    {
        return view('modules::fields.create');
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getCreateForm($slug, $table, $main = null)
    {

        $modules = json_decode(\File::get(storage_path('app/modules.json')));
        if (!$modules->$slug) return redirect()->back();
        $module = $modules->$slug;

        $table_names = $module->tables;
        $index = array_search($table, $table_names);
        if ($index === false) return redirect()->back();

        $hiddenFields = Fields::where('table_name', $module->tables[$index])->where('field', 'hidden')->get();
        $data = [$index => $table];
        $units = Units::where('type', 'general')->run();

        if ($main == 'main') {
            $form = Forms::where('table_name', $table)->where('main', 1)->first();
            $existingIDs = $form->fields->pluck('id', 'id')->toArray();
            $unconfigured = Fields::getUnconfiguredFields($table);
            $fields = Fields::where('table_name', $module->tables[$index]);
            if (count($existingIDs)) {
                $fields = $fields->whereNotIn('id', $existingIDs);
            }
            $fields = $fields->get();

            return view('modules::forms.create', compact(['data', 'slug', 'table', 'form', 'hiddenFields', 'units', 'fields', 'unconfigured']));
        }
        $fields = Fields::where('table_name', $module->tables[$index])->where('field', 'yes')->get();

        return view('modules::forms.create', compact(['data', 'slug', 'fields', 'hiddenFields', 'general_units']));
    }


    public function getCreatetestForm($slug)
    {
        $modules = json_decode(\File::get(storage_path('app/modules.json')));
        if (!$modules->$slug) return back();
        $module = $modules->$slug;
        $table_names = $module->tables;

        return view('modules::forms.create-test', compact(['table_names', 'slug']));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */

    //test
    /**
     * @param Request $request
     */
    public function postCreateForm(Request $request)
    {
        dd($request->all());
    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postTableFields(Request $request, $slug)
    {
        $tableKey = $request->get('table_name');
        if ($tableKey == 'general') {
            $units = Units::where('type', 'general')->run();
            $general_html = \View::make('modules::forms._partials.general_list')->with('units', $units)->render();

            return \Response::json(['data' => $general_html, 'error' => false]);

        } else {
            $modules = json_decode(\File::get(storage_path('app/modules.json')));
            if (!isset($modules->$slug)) return \Response::json(['error' => true, 'message' => 'not found!!!']);
            $module = $modules->$slug;
            if (isset($module->tables[$tableKey])) {
                $fields = Fields::where('table_name', $module->tables[$tableKey]);
                if (count($request->get('idies'))) {
                    $fields = $fields->whereNotIn('id', $request->get('idies'));
                }
                $fields = $fields->get();
                $html = \View::make('modules::fields._partials.field_list')->with('fields', $fields)->render();

                return \Response::json(['data' => $html, 'error' => false]);
            }

            return \Response::json(['error' => true, 'message' => 'not found!!!']);
        }
    }

    public function postSelectFields(Request $request)
    {

        $Id = $request->get('id');
        $form_id = $request->get('formid');
        $tabel = $request->get('table_name');
        if (isset($tabel) AND $tabel == 'general') {
            return \Response::json(['error' => false, 'html' => BBRenderUnits($Id)]);
        }
        $form = Forms::find($form_id);
        if ($form) {
            $form->widget = $request->get('fieldstyle', $form->widget);

            return \Response::json(['error' => false, 'html' => BBRenderField($Id, $form)]);
        }

        return \Response::json(['error' => true]);

    }

    public function getFieldsHtml(Request $request)
    {
        $form = Forms::find($request->get('formid'));
        if ($form) {
            $form->widget = $request->get('fieldstyle');
            $html = \View::make('modules::forms._partials.fields', compact('form'))->render();

            return \Response::json(['error' => false, 'html' => $html]);
        }
    }

    /**
     * @param $slug
     * @return bool|mixed
     */
    private function getModule($slug)
    {
        $coreModule = Moduledb::where('slug', $slug)->first();
        if ($coreModule) {
            return $coreModule;
        } else {
            $module = BBGetExtraModule($slug);

            if ($module) {
                return $module;
            }
        }

        return false;
    }

    private function MakeConfigPages($moduleName)
    {
        $menu = base_path('app/Modules/Modules/menuPages.json');
        $menu = json_decode(\File::get($menu), true);

        foreach ($menu['items'] as $item) {
            $url = str_replace('here', $moduleName, $item['url']);
            $parent = BBRegisterAdminPages($moduleName, $item['title'], $url);
            if (isset($item['childs']) && count($item['childs'])) {
                foreach ($item['childs'] as $ch) {
                    echo $ch . "--" . $item['title'] . "</br>";
                    BBRegisterAdminPages($moduleName, $item['title'] . "-" . $ch, $url . "/" . $ch, null, $parent->id);
                }
            }
        }

        dd('done!!!');
    }

    public function getBuildBUrls($module)
    {
       $html=(Routes::getModuleRoutes('GET','admin'));
        $settings = Setting::where('section', 'admin_urls')->where('settingkey', $module)->first();
        $roles = Roles::where('slug', '!=', 'superadmin')->pluck('slug');
        $allow = '';
        foreach ($roles as $slug) {
            $allow .= $slug . ',';
        }
        return view('modules::config.urls', compact(['html', 'allow', 'module', 'settings']));
    }

    public function getPagePreview($page_id, Request $request)
    {
        $layout = $request->get('pl');

        $page = AdminPages::find($page_id);
        $url = null;
        if (! $page) return redirect()->back();

        if (!str_contains($page->url, '{param}')) $url = $page->url;

        $layouts = ContentLayouts::pluck('slug', 'name');
        // $html = \View::make("ContentLayouts.$layout.$layout")->with(['settings'=>$this->options])->render();

        $lay = AdminTemplates::find($layout);

        if(! $lay){
            return view('modules::config.page-preview',['data' => compact(['page_id', 'layout', 'page', 'url','layouts'])]);
        }

        $view['view'] = "modules::config.page-preview";
        return AdminTemplates::find($layout)->renderSettings($view, compact(['page_id', 'layout', 'page', 'url','layouts']));
    }

    public function postSavePageSettings($page_id, Request $request)
    {
        $data = $request->except('pl');
        $page = AdminPages::find($page_id);

        $data['allLayouts'] = ContentLayouts::pluck('slug','slug');
        $data['page_id'] = $page_id;
        $v = \Validator::make($data,[
            'layout_id' => "in_array:allLayouts",
            'page_id' => "exists:admin_pages,id"
        ],
        [
            'in_array' => 'Layout does not exists!!!'
        ]);

        if ($v->fails()) return \Response::json(['error' => true, 'message' => $v->messages()]);

        if ($page) {
            $page->settings = (!empty($data)) ? json_encode($data, true) : null;
            $page->layout_id = (isset($data['layout_id']))?$data['layout_id'] : null;
            $page->save();

            return \Response::json(['error' => false, 'message' => 'Page Layout settings Successfully assigned']);
        }

        return \Response::json(['error' => true, 'message' => 'Page not found  !!!']);
    }

    public function postUrlsSettings(Request $request)
    {
        $data = $request->all();
        $v = \Validator::make($data,AdminPages::$rules );
        if ($v->fails()) return \Response::json(['error' => true, 'message' => $v->messages()]);
        $permurl = BBmakeUrlPermission($data['url'], '/');
        $ispage = AdminPages::where('url',$permurl)->orWhere('url','/'.$permurl)->first();
        if (!$ispage) {
            $routes = AdminPages::getModuleRoutes($data['slug']);
            $exploade = explode('/', $data['url']);
            $end = '/' . end($exploade);
            $parent = str_replace($end, '', $data['url']);
            $parent = BBmakeUrlPermission($parent, '/');
            $parent = AdminPages::where('url', $parent)->orWhere('url','/'.$parent)->first();
            if (!$parent and isset($routes[$data['url']])) {
                if(!BBRegisterAdminPages($data['slug'], $data['pagename'], $permurl,null))return \Response::json(['error' => true, 'message' => ['wrong data!!!']]);

            } else {
                if ($parent) {
                    if (!BBRegisterAdminPages($data['slug'], $data['pagename'],$permurl,null, $parent->id)) {
                        return \Response::json(['error' => true, 'message' => ['wrong data!!!']]);
                    }

                }else{
                    return \Response::json(['error' => true, 'message' => ['Warning!!!'=>'page should have parent ']]);
                }
            }
        }else{
            $ispage->title=$data['pagename'];
            $ispage->save();
        }
        $settings = Setting::where('section', 'admin_urls')->where('settingkey', $data['slug'])->first();
        if (!$settings) $settings = new Setting(['section' => 'admin_urls', 'settingkey' => $data['slug']]);
        if ($data['redirect'] == 'custom') {
            $settings->val = $data['redirectto'];
        } else {
            $settings->val = $data['redirect'];
        }
        $settings->save();
        return \Response::json(['error' => false]);
    }
}