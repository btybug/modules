<?php
/**
 * Created by PhpStorm.
 * User: Comp1
 * Date: 12/28/2016
 * Time: 1:40 PM
 */

namespace Btybug\Modules\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ExtraModules\Structures;

class PluginsController extends Controller
{
    public function getSettings($slug)
    {
        $plugin = Structures::find($slug);
        return view($plugin->namespace . '::' . $plugin->settings);

    }
}