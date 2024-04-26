<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $parentHeaderMenuIds = Menu::query()->where('parent', '!=', null)->where('menuType', 'header')->pluck('parent')->unique();
        $parentHeaderMenus = Menu::query()->whereIn('menuId', $parentHeaderMenuIds)->where('fkPageId', null)->where('status', 'active')->orderBy('menuOrder')->get();
        $menus = Menu::with('page')->where('status', 'active')->get();
        $headerMenus = Menu::with('page')->where('parent', null)->where('menuType', 'header')->where('fkPageId', '!=', null)->where('status', 'active')->orderBy('menuOrder')->get();
        $footerMenus = Menu::with('page')->where('parent', null)->where('menuType', 'footer')->where('fkPageId', '!=', null)->where('status', 'active')->orderBy('menuOrder')->get();
        $resourceMenus = Menu::with('page')->where('parent', null)->where('menuType', 'resource')->where('fkPageId', '!=', null)->where('status', 'active')->orderBy('menuOrder')->get();
        $contactMenus = Menu::with('page')->where('parent', null)->where('menuType', 'contact')->where('fkPageId', '!=', null)->where('status', 'active')->orderBy('menuOrder')->get();
        $setting = Setting::query()->first();
        View::share([
            'setting' => $setting,
            'parentHeaderMenus' => $parentHeaderMenus,
            'menus' => $menus,
            'headerMenus' => $headerMenus,
            'footerMenus' => $footerMenus,
            'resourceMenus' => $resourceMenus,
            'contactMenus' => $contactMenus,
        ]);
        Paginator::useBootstrap();
    }
}
