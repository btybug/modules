<?php
/**
 * Created by PhpStorm.
 * User: Comp1
 * Date: 1/9/2017
 * Time: 4:01 PM
 */

namespace Sahakavatar\Modules\Plugins\Gears\Http;
use App\Http\Controllers\Controller;
use App\Models\Themes\Themes;

class LayoutController extends Controller
{
    public function getIndex ()
    {
        $active = Themes::active();
        return view('Gears::layouts.index',compact(['active']));
    }

    public function getDeleteLayout ($key)
    {
        $active = Themes::active()->remove($key);
        return redirect()->back();
    }
}