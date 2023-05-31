<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgendaRequest;
use App\Models\Agenda;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AgendaController extends Controller
{
    public function storeAgenda(AgendaRequest $request){
        $agendaDetails = $request->validated();

        Agenda::create([
            'user_id' => Auth::user()->id,
            'message' => $agendaDetails['message'],
            'service' => $agendaDetails['service'],
            'budget' => $agendaDetails['budget'],
            'deadline' => $agendaDetails['deadline']
        ]);

        Alert::success('Success', 'Agenda successfully posted');
        return back();

    }

    public function updateAgenda(Agenda $agenda, AgendaRequest $request){

        $agendaDetails = $request->validated();

        Agenda::where('id', $agenda->id)->update([
            'message' => $agendaDetails['message'],
            'service' => $agendaDetails['service'],
            'budget' => $agendaDetails['budget'],
            'deadline' => $agendaDetails['deadline']
        ]);

        Alert::success('Success', 'Agenda successfully updated.');
        return back();
    }

    public function destroyAgenda(Agenda $agenda){
        Agenda::destroy($agenda->id);
        return response()->json($agenda);
    }

}
