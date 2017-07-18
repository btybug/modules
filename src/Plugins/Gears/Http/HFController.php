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

class HFController extends Controller
{
    public function getIndex()
    {
        $type='header';
        $ui_elemements = Tpl::where('general_type', $type)->run();
        return view('Gears::hf.index',compact(['ui_elemements','type',]));

    }
    public function postTemplatesWithType(Request $request)
    {
        $main_type = $request->get('main_type');
            $ui_elemements = Tpl::where('general_type', $main_type)->run();
            $html = \View::make('Gears::hf.list_cube', compact(['ui_elemements']))->render();
        return \Response::json(['html' => $html, 'error' => false]);
    }
}