<?php

namespace Sahakavatar\Modules\Plugins\Gearsb\Providers;

use App\Models\Templates\Widgets;
use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
//        \Eventy::action('admin.menus', [
//            "title" => "Modules",
//            "custom-link" => "#",
//            "icon" => "fa fa-folder-open",
//            "is_core" => "yes",
//            "main"=>true,
//            "children" => [
//                [
//                    "title" => "Backend Gears",
//                    "custom-link" => "/admin/modules/back-gears/layouts",
//                    "icon" => "fa fa-angle-right",
//                    "is_core" => "yes"
//                ]
//            ]
//        ]);
//        $tubs = [
//            'Gears_b' => [
//                [
//                    'title' => 'Layout ',
//                    'url' => '/admin/modules/back-gears/layouts',
//                ],[
//                    'title' => 'Units',
//                    'url' => '/admin/modules/back-gears/units',
//                ],[
//                    'title' => 'Main body',
//                    'url' => '/admin/modules/back-gears/main-body',
//                ]
//
//            ],
//        ];
//        \Eventy::action('my.tab', $tubs);
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {

    }
}
