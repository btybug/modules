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
use App\Modules\Settings\Models\Template;
use Assets;
use Datatables;
use App\Modules\Modules\Models\Forms;
use Illuminate\Http\Request;
use Session;
use View;


/**
 * Class ThemeController
 * @package App\Modules\Modules\Http\Controllers
 */
class TestController extends Controller
{

    public function getFormTest()
    {
        $form=Forms::first();
        return view('modules::tests.form',compact(['form']));
    }

}
