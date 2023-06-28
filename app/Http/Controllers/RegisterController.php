<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Http\Requests\RegisterClientRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\AdminRequest;
use App\Models\Agent;
use App\Models\AgentService;
use App\Models\Notification;
use App\Models\Service;
use App\Models\ServiceAddress;
use App\Models\User;
use App\Models\UserPhoto;
use App\Models\ValidDocument;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    public function create(){

        return view('components.register.register', ['services' => Service::all()]);
    }

    public function store(RegisterRequest $request)
    {
        $userDetails = $request->validated();

        $userDetails['password'] = bcrypt($userDetails['password']);

        $user = User::create([
            'fullname' => $userDetails['fullname'],
            'username' => $userDetails['username'],
            'email_address' => $userDetails['email_address'],
            'contact_no' => $userDetails['contact_no'],
            'password' => $userDetails['password'],
            'region' => $userDetails['region'],
            'user_type' => 3,
        ]);

        ServiceAddress::create([
            'user_id' => $user->id,
            'address' => $userDetails['address'],
            'is_active' => true,
            'is_primary' => true
        ]);

        Alert::success('Success', 'Registration completed.');
        return redirect('/');
    }

    public function storeAgent(RegisterClientRequest $request)
    {
        $userDetails = $request->validated();

        $userDetails['password'] = bcrypt($userDetails['password']);

        $user = User::create([
            'fullname' => $userDetails['fullname'],
            'username' => $userDetails['username'],
            'email_address' => $userDetails['email_address'],
            'contact_no' => $userDetails['contact_no'],
            'password' => $userDetails['password'],
            'service' => $userDetails['service'],
            'region' => $userDetails['region'],
            'user_type' => 2,
        ]);

        ServiceAddress::create([
            'user_id' => $user->id,
            'address' => $userDetails['address'],
            'is_active' => true,
            'is_primary' => true
        ]);

        if ($request->user_type === 'Client') {
            $validDocuments = [];
            $fileFields = [
                // 'photo_id',
                'nbi_clearance',
                'police_clearance',
                'birth_certificate',
                'cert_of_employment',
                'other_valid_id',
            ];

            $photoId = 'photo_id';

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/uploads', $fileName);
                    $validDocuments[$field] = '/storage/uploads/' . $fileName;
                }
            }

            if ($request->hasFile($photoId)) {
                $file = $request->file($photoId);
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $fileName);
                $photoId = '/storage/uploads/' . $fileName;
            }

            $validDocuments['user_id'] = $user->id;
            $validDocuments['user_type'] = 2;

            UserPhoto::create([
                'user_id' => $user->id,
                'profile_picture' => $photoId,
                'user_type' => 2
            ]);

            ValidDocument::create($validDocuments);
        }

        $service = Service::where('type', $userDetails['service'])->first();
        AgentService::create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'title' => 'NA',
            'is_pending' => true
        ]);

        AdminRequest::create([
            'request_by' => $user->id,
            'type' => 1 // 1 = new agent
        ]);

        $admin = User::where('user_type', 1)->first();
        $notificationMessage = $userDetails['username'] . "has joined Serv-is! Accept verification status?";
        $notificationType = 4;

        $notification = Notification::create([
            'user_id' => $admin->id, // to
            'from_user_id' => $user->id, // from
            'username' => $user->username,
            'message' => $notificationMessage,
            'is_unread' => true,
            'status' => 0,
            'type' => $notificationType
        ]);

        event(new NotificationEvent(
            $user->username,
            $admin->id,
            $notificationMessage,
            $notificationType,
            $notification->id,
            $user->id
        ));

        Alert::success('Success', 'Registration completed.');
        return redirect('/');
    }

}
