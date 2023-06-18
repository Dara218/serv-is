<?php

namespace App\Http\Controllers;

use App\Models\AgentService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SearchController extends Controller
{
    public function getSearchAgentService(Request $request)
    {
        $serviceType = Service::where('type', $request->dropdownText)->first();

        if($request->dropdownText === 'All categories')
        {
             $searchAgentServiceResults = AgentService::where('title', 'LIKE', '%'. $request->searchValue .'%')
                                                    ->with('service', 'user.userPhoto', 'review')
                                                    ->get();
        }
        else
        {
            $searchAgentServiceResults = AgentService::where('title', 'LIKE', '%'. $request->searchValue .'%')
                                                    ->where('service_id', $serviceType->id)
                                                    ->with('service', 'user.userPhoto', 'review')
                                                    ->get();
        }

        $searchResults = ['agentService' => $searchAgentServiceResults];
        return response()->json($searchResults);
    }

    public function getSearchService(Request $request)
    {
        if($request->category === 'All categories')
        {
            $searchServiceResults = AgentService::with('service', 'user.userPhoto', 'review')->get();
        }
        else
        {
            $serviceType = Service::where('type', $request->category)->first();
            $searchServiceResults = AgentService::where('service_id', $serviceType->id)
                                                ->with('service', 'user.userPhoto', 'review')
                                                ->get();
        }

        $searchResults = ['agentService' => $searchServiceResults];
        return response()->json($searchResults);
    }

    public function getUsers(Request $request)
    {
        $userType = $request->userType;
        $searchValue = $request->searchValue;

        if($userType === "Customer" || $userType === "Agent"){
            if($userType === "Customer"){
                $role = 3;
            }
            if($userType === "Agent"){
                $role = 2;
            }
            $users = User::where(function ($query) use ($searchValue) {
                $query->where('fullname', 'LIKE', '%' . $searchValue . '%')
                    ->orWhere('username', 'LIKE', '%' . $searchValue . '%');
            })->where('user_type', $role)->get();
        }

        if($userType === "All Users"){
            $role = [2, 3];
            $users = User::where(function ($query) use ($searchValue) {
                $query->where('fullname', 'LIKE', '%' . $searchValue . '%')
                    ->orWhere('username', 'LIKE', '%' . $searchValue . '%');
            })->whereIn('user_type', $role)->get();
        }

        if($searchValue == null){
            $users = User::where('user_type', '!=', 1)->get();
        }

        return response()->json(['users' => $users]);
    }

    public function getUsersFromDropdown(Request $request)
    {
        $userType = $request->userType;

        if($userType === "Customer" || $userType === "Agent"){
            if($userType === "Customer"){
                $role = 3;
            }
            if($userType === "Agent"){
                $role = 2;
            }
            $users = User::where('user_type', $role)->get();
        }

        if($userType === "All Users"){
            $role = [2, 3];
            $users = User::whereIn('user_type', $role)->get();
        }

        return response()->json(['users' => $users]);
    }
}
