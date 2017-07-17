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

namespace App\Modules\Modules\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Modules\Models\Plugin;
use Illuminate\Http\Request;
use view;

/**
 * Class ModulesController
 * @package App\Modules\Modules\Http\Controllers
 */
class GenerateController extends Controller {

    public function getIndex(){
        return view("modules::generate.create");
    }

    public function postGenerateModule(Request $request){

        $plugin = Plugin::makeModule($request);
        if($plugin) return redirect()->back();
    }
}
