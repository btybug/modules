<?php
/**
 * Created by PhpStorm.
 * User: shojan
 * Date: 12/28/2016
 * Time: 11:52 AM
 */

namespace Sahakavatar\Modules\Plugins\Gearsb\Http;

use App\Http\Controllers\Controller;


class FreeStylesController extends Controller
{
    public function getIndex()
    {
        return view('Gearsb::free_styles.index');

    }
}