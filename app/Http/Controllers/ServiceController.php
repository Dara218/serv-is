<?php

namespace App\Http\Controllers;

use App\Models\AgentService;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function getServices(){
        $services = Service::all();
        return response()->json($services);
    }

    public function getAgentService(){
        $agentServices = AgentService::where('is_pending', 0)
                                    ->with('user.userPhoto', 'review', 'service')
                                    ->inRandomOrder()
                                    ->take(6)
                                    ->get();

        return response()->json($agentServices);
    }

    public function getAllAgentService(){
        $allAgentServices = AgentService::where('is_pending', 0)
                                    ->with('user.userPhoto', 'review', 'service')
                                    ->inRandomOrder()
                                    ->get();

        return response()->json($allAgentServices);
    }

    public function updateService($id, Request $request)
    {
        $service = Service::where('id', $id)->first();
        Category::where('type', $service->type)->update(['type' => $request->title]);
        $service->update(['type' => $request->title]);

        return response()->json($request);
    }

    public function storeService(Request $request){
        Service::create([
            'type' => $request->title
        ]);

        Category::create([
            'type' => $request->title
        ]);

        return response()->json($request);
    }
}
