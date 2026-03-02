<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 1. استدعاء مكتبة الترقيم - ضروري جداً
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 2. تفعيل Bootstrap لترقيم الصفحات ليعمل بشكل صحيح مع تصميمك
        Paginator::useBootstrapFive();
    }
}