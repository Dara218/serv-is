<?php

namespace App\Providers;

use App\Models\ValidDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Model::unguard();

        View::composer('partials.navbar', function($view){
            $admins = ValidDocument::where('user_type', 1)->get();

            foreach($admins as $admin){
                $view->with('admin', $admin);
            }

        });
    }
}
