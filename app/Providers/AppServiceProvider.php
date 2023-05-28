<?php

namespace App\Providers;

use App\Models\AvailedUser;
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
                    // $agents = User::where('user_type', 2)->get();
                    // $view->with('agents', $agents);

                    // make new table availed_users that contains user id, client id DONE
                    // check if true above, select all user_availed where auth user is present

                    $agents = AvailedUser::where('availed_by', Auth::user()->id)->with('user')->get();
                    $view->with('agents', $agents);
                }

                if(Auth::user()->user_type == 2){
                    $agents = AvailedUser::where('availed_to', Auth::user()->id)->with('user')->get();
                    $view->with('agents', $agents);

                    // $agents = User::where('user_type', 3)->get();
                    // $view->with('agents', $agents);
                }
                if(Auth::user()->user_type == 1){
                    $agents = User::where('user_type', 2)
                                    ->orWhere('user_type', 3)->get();
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
