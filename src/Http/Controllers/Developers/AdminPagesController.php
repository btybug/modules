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

namespace Sahakavatar\Modules\Http\Controllers\Developers;

use Sahakavatar\Cms\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Modules\Create\Models\AdminPages;
use Illuminate\Http\Request;
use view,File;

/**
 * Class AdminPagesController
 * @package App\Modules\Backend\Http\Controllers
 */
class AdminPagesController extends Controller
{

    public $modules;
    public $md_ar = [];
    /**
     * AdminPagesController constructor.
     */
    public function __construct()
    {
        $this->modules = json_decode(File::get(storage_path('app/modules.json')));
        if(count($this->modules)){
            foreach($this->modules as $module){
                $this->md_ar[$module->basename] = $module->name;
            }

        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $pageGrouped = AdminPages::groupBy('module_id')->get();
        $pages = AdminPages::pluck('title','id')->all();
        $modulesList = $this->md_ar;

        return view('modules::developers.admin_pages.list',compact(['pageGrouped','pages','modulesList']));
    }

    public function postCreate (Request $request)
    {
        $page = AdminPages::create($request->except('_token'));

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postModuleData(Request $request){
        $id = $request->get('id');
        $modules = json_decode(File::get(storage_path('app/modules.json')));
        if(count($modules)){
            $module =  $modules->$id;
        }

        if(! $module) return  \Response::json(['error' => true]);

        $info = helpers::Info($module);
        $html = view::make('modules::developers.admin_pages._partials.module_info',compact(['module','info']))->render();

        return \Response::json(['error' => false,'html' => $html]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPagesData(Request $request){

        $id = $request->get('id');
        $page = AdminPages::find($id);
        if(! $page) return \Response::json(['error' => true]);

        $html = view::make('modules::developers.admin_pages._partials.pages_info',compact(['page']))->render();

        return \Response::json(['error' => false,'html' => $html]);
    }

}
