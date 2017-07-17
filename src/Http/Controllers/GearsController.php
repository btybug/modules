<?php

namespace App\Modules\Modules\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\ContentLayouts\ContentLayouts;
use App\Models\Templates\Units;
use App\Modules\Modules\Models\AdminPages;
use Illuminate\Http\Request;

/**
 * Class ModulesController
 * @package App\Modules\Modules\Http\Controllers
 */
class GearsController extends Controller
{


    /**
     * ConfigController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getDefoult()
    {
        return view('modules::gears.defoult');
    } public function getIndex()
    {
        $type='frontend';
        return view('modules::gears.index',compact('type'));
    }

    public function getBackend()
    {
        $type='backend';
        return view('modules::gears.index',compact('type'));
    }
    public function getPageLayout(Request $request)
    {
        $id=$request->get('id');
        $page= AdminPages::find($id);
        $layout= ContentLayouts::findVariation($page->layout_id);
        if($layout){
            return \Response::json(
                ['error'=>false,
                    'value'=>$layout->id,
                    'page_name'=>$page->title,
                     'page_id'=> $page->id,
                     'page_date'=> BBgetDateFormat($page->created_at),
                     'page_url'=>url($page->url)
                ]
            );
        }
        return \Response::json(['error'=>false,'value'=>0, 'page_name'=>$page->title,'page_date'=> BBgetDateFormat($page->created_at),'page_id'=> $page->id, 'page_url'=>url($page->url)]);
    }
    public function getGearsLists(Request $request)
    {
        $classes=[
            'units'=>new Units(),
            'layouts'=>new ContentLayouts(),
            'main_body'=>new ContentLayouts()
        ];
        $data=$request->all();
        $url=$data['url'];
        if($data['main_type']=='units'){
            $ui_elemements=$classes[$data['main_type']]->getAll()->run();
        }else{
            $ui_elemements=$classes[$data['main_type']]->all();
        }

        $html = \View::make('modules::gears._partials.list_cube',compact(['ui_elemements', 'url']))->render();
        return \Response::json(['html' => $html, 'error' => false]);
    }
}
