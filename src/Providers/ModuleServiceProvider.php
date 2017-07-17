<?php

namespace App\Modules\Modules\Providers;

use Caffeinated\Modules\Support\ServiceProvider;
use Illuminate\Foundation\Auth\User;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'modules');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'modules');

        //put in array your shortcode function name
        $short_codes = [];
        \Eventy::action('my.shortcode', $short_codes);

        //tabs
        $tabs = [
            'modules_config' => [
                [
                    'title' => 'Assets',
                    'url' => '/admin/modules/config/{slug}/{something}',
                    'icon' => 'fa fa-square-o'
                ], [
                    'title' => 'Info',
                    'url' => '/admin/modules/config/{slug}/info',
                    'icon' => 'fa fa-info-circle'
                ], [
                    'title' => 'Table & Forms',
                    'url' => '/admin/modules/config/{slug}/tables',
                    'icon' => 'fa fa-table'
                ],  [
                    'title' => 'Permission',
                    'url' => '/admin/modules/config/{slug}/permission',
                    'icon' => 'fa fa-key'
                ], [
                    'title' => 'Codes',
                    'url' => '/admin/modules/config/{slug}/codes',
                    'icon' => 'fa fa-code'
                ],[
                    'title' => 'Front Gears',
                    'url' => '/admin/modules/config/{slug}/gears',
                    'icon' => 'fa fa-cog'
                ],[
                    'title' => 'Back Gears',
                    'url' => '/admin/modules/config/{slug}/gearsb',
                    'icon' => 'fa fa-cog'
                ],[
                    'title' => 'Back Build',
                    'url' => '/admin/modules/config/{slug}/buildb',
                    'icon' => 'fa fa-cog'
                ],[
                    'title' => 'Front Build',
                    'url' => '/admin/modules/config/{slug}/build',
                    'icon' => 'fa fa-cog'
                ]
            ],'m_gears'=>[
                [
                'title' => 'Frontend Gears',
                'url' => '/admin/modules/gears/frontend-end',
                'icon' => 'fa fa-cog'
            ],  [
                'title' => 'Backend Gears',
                'url' => '/admin/modules/gears/back-end',
                'icon' => 'fa fa-cog'
            ]
            ]
        ];

        \Eventy::action('my.tab', $tabs);
        $tabs = [
            'developers_structure' => [
                [
                    'title' => 'Tables',
                    'url' => '/admin/modules/tables',
                    'icon'=>'fa fa-user'
                ],[
                    'title' => 'Forms',
                    'url' => '/admin/modules/forms',
                    'icon'=>'fa fa-user'
                ],[
                    'title' => 'Pages',
                    'url' => '/admin/modules/pages/list',
                    'icon'=>'fa fa-user'
                ],[
                    'title' => 'Menus',
                    'url' => '/admin/modules/menus',
                    'icon'=>'fa fa-user'
                ],[
                    'title' => 'Backend Theme',
                    'url' => '/admin/modules/backend-theme',
                    'icon'=>'fa fa-user'
                ]
            ],
        ];

        $toggleTabs=['developers_create_module'=>[
            [
                'title'=>'All',
                'view'=>'modules::developers.module._partials.all',
                'id'=>'developers_all',
                'icon'=>'fa fa-square-o'
            ],[
                'title'=>'Info',
                'view'=>'modules::developers.module._partials.info',
                'id'=>'developers_info',
                'icon'=>'fa fa-info-circle'
            ],[
                'title'=>'SQl',
                'view'=>'modules::developers.module._partials.sql',
                'id'=>'developers_sql',
                'icon'=>'fa fa-database'
            ],[
                'title'=>'Table',
                'view'=>'modules::developers.module._partials.table',
                'id'=>'developers_table',
                'icon'=>'fa fa-table'
            ],[
                'title'=>'Form',
                'view'=>'modules::developers.module._partials.form',
                'id'=>'developers_form',
                'icon'=>'fa fa-indent'
            ],[
                'title'=>'Master Details',
                'view'=>'modules::developers.module._partials.master_details',
                'id'=>'developers_master_details',
                'icon'=>'fa fa-strikethrough'
            ],[
                'title'=>'Permissions',
                'view'=>'modules::developers.module._partials.permissions',
                'id'=>'developers_permissions',
                'icon'=>'fa fa-key'
            ],[
                'title'=>'Codes',
                'view'=>'modules::developers.module._partials.codes',
                'id'=>'developers_codes',
                'icon'=>'fa fa-code'
            ],[
                'title'=>'Rebuild',
                'view'=>'modules::developers.module._partials.rebuild',
                'id'=>'developers_rebuild',
                'icon'=>'fa fa-spinner'
            ],[
                'title'=>'Views',
                'view'=>'modules::developers.module._partials.views',
                'id'=>'developers_views',
                'icon'=>'fa fa-file-code-o'
            ],
        ]
        ];

        \Eventy::action('toggle.tabs',$toggleTabs);
        \Eventy::action('my.tab', $tabs);
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
