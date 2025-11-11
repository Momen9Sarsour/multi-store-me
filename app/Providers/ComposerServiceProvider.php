<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        View::composer(['front.homes', 'front.categories.show'], function ($view) {
            $categories = Category::with('store')->get();
            $groupedCategories = $categories->groupBy('name');
            $view->with('groupedCategories', $groupedCategories);
        });
    }
}
