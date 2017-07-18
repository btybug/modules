<?php

namespace App\Modules\Tools\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'tools');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'tools');

        $tabs = [
            'edit_page' => [
                [
                    'id' => 'layout',
                    'title' => 'Select Layout',
                    'view' => 'tools::pages.layout',
                    'icon'=>'fa fa-user'
                ],
                [
                    'id' => 'settings',
                    'title' => 'Settings',
                    'view' => 'tools::pages.settings',
                    'icon'=>'fa fa-commenting'
                ]
            ]
        ];
        \Eventy::action('toggle.tabs',$tabs);
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
