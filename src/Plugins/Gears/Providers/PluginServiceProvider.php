<?php

namespace Sahakavatar\Modules\Plugins\Gears\Providers;

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
//                    "title" => "Frontend Gears",
//                    "custom-link" => "/admin/modules/front-gears/layouts",
//                    "icon" => "fa fa-angle-right",
//                    "is_core" => "yes"
//                ]
//            ]
//        ]);
//        $tubs = [
//            'Gears' => [
//                [
//                    'title' => 'Layout ',
//                    'url' => '/admin/modules/front-gears/layouts',
//                ],[
//                    'title' => 'Units',
//                    'url' => '/admin/modules/front-gears/units',
//                ],[
//                    'title' => 'H&F',
//                    'url' => '/admin/modules/front-gears/h-f',
//                ],[
//                    'title' => 'Main body',
//                    'url' => '/admin/modules/front-gears/main-body',
//                ],
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
