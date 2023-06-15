<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Http\Requests\AgentRequest;
use App\Models\AdminRequest;
use App\Models\AgentService;
use App\Models\AgentServicePending;
use App\Models\Notification;
use App\Models\Service;
use App\Models\User;
use App\Models\UserPhoto;
use App\Models\ValidDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AgentServiceController extends Controller
{
    public function updateAgentService(Request $request)
    {
        $service = AgentService::where('id', $request->id)->update(['title' => $request->title]);
        return response()->json($request->id);
    }

    public function createServiceDetails(){
        return view('components.home-agent.update-service-details', [
            'services' => Service::all(),
            'agentservices' => AgentService::where('user_id', Auth::user()->id)->first()
        ]);
    }

    public function updateServiceDetails(AgentService $agentService, AgentRequest $request){
        $agentServiceDetails = $request->validated();

        // AgentService::where('id', $agentService->id)->update([
        //     'title' => $agentServiceDetails['service_title'],
        //     'service' => $agentServiceDetails['service']
        // ]);

        AgentService::create([
            'user_id' => Auth::user()->id,
            'title' => $agentServiceDetails['service_title'],
            'service' => $agentServiceDetails['service'],
            'is_pending_changes' => true
        ]);

        AdminRequest::create([
            'request_by' => Auth::user()->id,
            'type' => 2,
        ]);

        Alert::success('Success', 'Admin will verify your changes. You will be notified once done.');
        return back();
    }

    public function storeAgentUpdatedDetails(Request $request){
        AdminRequest::where('request_by', $request->fromUserId)->first()->update([
            'is_accepted' => true,
        ]);

        AgentService::where('user_id', $request->fromUserId)->first()->update([
            'is_pending' => false
        ]);

        $notificationMessage = "System admin has verified your account. Your service can now be seen online.";

        if(! $request->is_Accepted){
            $notificationMessage = "System admin has rejected your account.";
        }

        $notificationType = 2;

        $notification = Notification::create([
            'user_id' => $request->fromUserId, // to
            'from_user_id' => $request->toUserId, // from
            'username' => $request->username,
            'message' => $notificationMessage,
            'is_unread' => true,
            'status' => 3,
            'type' => $notificationType
        ]);

        event(new NotificationEvent(
            $request->username,
            $request->fromUserId,
            $notificationMessage,
            $notificationType,
            $notification->id,
            $request->fromUserId
        ));

        return response()->json($request);
    }

    public function showConfirmAgent($username)
    {
        $notifications = Notification::where('user_id', Auth::user()->id)
                                    ->where('status', 0)
                                    ->where('type', 4)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        $user = User::where('username', $username)->first();
        $otherUserDocuments = AdminRequest::where('is_accepted', false)
                                            ->with('validDocument.notification')
                                            ->orderByRaw('CASE WHEN request_by = ' .$user->id .' THEN 0 ELSE 1 END')
                                            ->orderBy('created_at', 'DESC')
                                            ->paginate(3);

        /*
            TODO:
            - Add pagination on services
         */

        return view('components.home_admin.confirm-agent', [
            'notifications' => $notifications,
            'otherDocuments' => $otherUserDocuments
        ]);
    }

    public function showConfirmAgentOnNav()
    {
        $notifications = Notification::where('user_id', Auth::user()->id)
                                ->where('status', 0)
                                ->where('type', 4)
                                ->orderBy('created_at', 'desc')
                                ->get();

        $otherUserDocuments = AdminRequest::where('is_accepted', false)
        ->with('validDocument.notification')
        ->orderBy('created_at', 'DESC')
        ->paginate(3);

        return view('components.home_admin.confirm-agent', [
            'notifications' => $notifications,
            'otherDocuments' => $otherUserDocuments
        ]);
    }
}
