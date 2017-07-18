<?php
/**
 * Created by PhpStorm.
 * User: Comp1
 * Date: 1/9/2017
 * Time: 4:01 PM
 */

namespace Sahakavatar\Modules\Plugins\Gearsb\Http;
use App\Http\Controllers\Controller;

class LayoutController extends Controller
{
    public function getIndex()
    {
        return view('Gearsb::layouts.index');
}
}