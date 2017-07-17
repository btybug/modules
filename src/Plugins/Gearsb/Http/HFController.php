<?php
/**
 * Created by PhpStorm.
 * User: shojan
 * Date: 12/28/2016
 * Time: 11:53 AM
 */

namespace App\Modules\Modules\Plugins\Gearsb\Http;
use App\Http\Controllers\Controller;

class HFController extends Controller
{
    public function getIndex()
    {
        return view('Gearsb::hf.index');

    }
}