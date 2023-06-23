<?php

namespace App\Providers;

use App\Models\AgentService;
use App\Models\AvailedUser;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Notification;
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

        View::composer('components.layout', function($view)
        {
            if(Auth::check())
            {
                $hasNewChats = Message::where('receiver_id', Auth::user()->id)->where('is_unread', true)->exists();
                $agentServiceId = null;

                if(Auth::user()->user_type == 2)
                {
                    $agentService = AgentService::where('user_id', Auth::user()->id)->with('service', 'review.user')->first();
                    $agentServiceId = $agentService->id;
                }

                $view->with(['hasNewChats'=> $hasNewChats, 'agentServiceId' => $agentServiceId]);
            }
        });

        View::composer('partials.navbar', function($view){
            $admins = UserPhoto::where('user_type', 1)->get();
            $agentService = AgentService::where('user_id', Auth::user()->id)
                                        ->where('title', 'NA')
                                        ->exists();
            $user = User::where('id', Auth::user()->id)->with('agentService')->first();

            foreach($admins as $admin){
                $view->with([
                    'admin' => $admin,
                    'agentservice' => $agentService,
                    'user' => $user
                ]);
            }
        });

        View::composer('partials.notification', function($view){
            $notifications = Notification::where('user_id', Auth::user()->id)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
            $notificationCount = Notification::where('user_id', Auth::user()->id)
                                            ->where('is_unread', 1)
                                            ->count();
            $view->with([
                'notifications' => $notifications,
                'notificationCount' => $notificationCount,
            ]);
        });

        View::composer('partials.chat', function($view){

            if(Auth::check())
            {
                $authUser = Auth::user();
                $allAdmin = User::where('user_type', 1)->with('chat')->get();
                $adminIds = [];

                foreach($allAdmin as $admin)
                {
                    $adminIds[] = $admin->id;
                }

                if($authUser->user_type != 1)
                {
                    $adminChats = Chat::where('receiver_id', $authUser->id)->whereIn('sender_id', $adminIds)->with('sender.userPhoto')->get();

                    if($authUser->user_type == 3)
                    {
                        $agents = AvailedUser::where('availed_by', $authUser->id)->with('user.chat', 'user.userPhoto')->get();
                        $view->with(['agents' => $agents, 'admins' => $adminChats]);
                    }
                    if($authUser->user_type == 2)
                    {
                        $agents = AvailedUser::where('availed_to', $authUser->id)
                                            ->with('user.chat', 'user.userPhoto', 'availedBy')
                                            ->get();
                        $view->with(['agents' => $agents, 'admins' => $adminChats]);
                    }
                }
                if($authUser->user_type == 1)
                {
                    $agents = Chat::where('sender_id', $authUser->id)->with('receiver.userPhoto')->get();
                    $view->with(['agents' => $agents]);
                }
            }

            else{
                $agents = User::where('user_type', 3)->get();
                $view->with('agents', $agents);
            }
        });
    }
}
