<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserPhoto;
use App\Models\ValidDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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
            $admins = UserPhoto::where('user_type', 1)->get();

            foreach($admins as $admin){
                $view->with('admin', $admin);
            }

        });

        View::composer('partials.chat', function($view){

            if(Auth::check()){
                if(Auth::user()->user_type == 3){
                    $agents = User::where('user_type', 2)->get();
                    $view->with('agents', $agents);
                }

                if(Auth::user()->user_type == 2){
                    $agents = User::where('user_type', 3)->get();
                    $view->with('agents', $agents);
                }
            }

            else{
                $agents = User::where('user_type', 3)->get();
                $view->with('agents', $agents);
            }
        });
    }
}
