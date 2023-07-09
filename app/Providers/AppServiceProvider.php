<?php

namespace App\Providers;

use App\Models\Size;
use App\Models\Color;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;
use App\Models\Purchage;
use App\Models\Permission;
use Facade\FlareClient\View;
use App\Models\CompanyProfile;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // view()->share('permissions', Permission::all())->get();
        // $permissions = Permission::where('user_id', Auth::id())->get();
        // view()->share('permissions', $permissions);


        Paginator::useBootstrap();
        $content = CompanyProfile::first();
        view()->share('content', $content);
        view()->share('colors', Color::all());
        
        view()->share('sizes', Size::all());
        view()->share('categorylist', Category::with('subcategory', 'subSubCategory', 'anotherCategory')->get());
        view()->share('categoryMenu', Category::with('subcategory')->where('is_menu', 1)->get());
        view()->share('randCategory', Category::inRandomOrder()->limit(4)->get());
        view()->share('max',  Product::whereNull('deleted_at')->max('price'));
        view()->share('min',  Product::min('price'));
      
        view()->share('offer',Offer::first());
        $is_free_shipping = false;

        if($content->happy_hour_date ){
            $today = now();
            if($content->happy_hour_date == $today->format('Y-m-d')){
                $time_from = \Carbon\Carbon::parse($content->happy_hour_date . ' '. $content->happy_hour_time_from);
                $time_to = \Carbon\Carbon::parse($content->happy_hour_date . ' '. $content->happy_hour_time_to);
                if($today->gte($time_from) && $today->lt($time_to)){
                    $is_free_shipping = true;
                }
            }
        }

        view()->share('is_free_shipping', $is_free_shipping);
     }
}
