<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgentRequest;
use App\Models\AdminRequest;
use App\Models\AgentService;
use App\Models\Service;
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
        return view('components.home_agent.update-service-details', [
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

        /* TODO: Make new table named agent_service_pendings
            columns: same lang sa agent service but may new column name, is_pending
        */

        AdminRequest::create([
            'request_by' => Auth::user()->id,
            'type' => 2,
        ]);

        Alert::success('Success', 'Admin will verify your changes. You will be notified once done.');
        return back();
    }
}
