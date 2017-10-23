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

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sahakavatar\Modules\Models\Models\Plugin;

/**
 * Class ModulesController
 * @package Sahakavatar\Modules\Models\Http\Controllers
 */
class GenerateController extends Controller
{

    public function getIndex()
    {
        return view("modules::generate.create");
    }

    public function postGenerateModule(Request $request)
    {

        $plugin = Plugin::makeModule($request);
        if ($plugin) return redirect()->back();
    }
}
