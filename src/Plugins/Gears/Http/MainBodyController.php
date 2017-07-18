<?php
/**
 * Created by PhpStorm.
 * User: shojan
 * Date: 12/28/2016
 * Time: 11:53 AM
 */

namespace Sahakavatar\Modules\Plugins\Gears\Http;
use App\Http\Controllers\Controller;
use App\Models\Templates\Templates as Tpl;
use Illuminate\Http\Request;


class MainBodyController extends Controller
{
    public function getIndex()
    {
        $type='body';
        $templates = Tpl::where('general_type', $type)->run();
        return view('Gears::main_body.index',compact(['templates','type',]));

    }
    public function getVariations(Request $request)
    {
        $type='body';
        $templates = Tpl::find($request->get('slug'));
        if($templates){
            $variations=$templates->variations();
        $html = \View::make('Gears::main_body.variations', compact(['variations']))->render();
        return \Response::json(['html' => $html, 'error' => false]);
    }
        return \Response::json(['error' => true]);
    }
}