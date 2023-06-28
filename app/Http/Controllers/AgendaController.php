<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgendaRequest;
use App\Models\Agenda;
use DateTime;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AgendaController extends Controller
{
    public function storeAgenda(AgendaRequest $request)
    {
        $agendaDetails = $request->validated();
        $dateTime = new DateTime($agendaDetails['deadline']);

        Agenda::create([
            'user_id' => Auth::user()->id,
            'message' => $agendaDetails['message'],
            'service' => $agendaDetails['service'],
            'budget' => $agendaDetails['budget'],
            'deadline' => $dateTime->format('Y-m-d H:i:s')
        ]);

        Alert::success('Success', 'Agenda successfully posted');
        return back();
    }

    public function updateAgenda(Agenda $agenda, AgendaRequest $request)
    {
        $agendaDetails = $request->validated();
        $dateTime = new DateTime($agendaDetails['deadline']);

        Agenda::where('id', $agenda->id)->update([
            'message' => $agendaDetails['message'],
            'service' => $agendaDetails['service'],
            'budget' => $agendaDetails['budget'],
            'deadline' => $dateTime->format('Y-m-d H:i:s')
        ]);

        Alert::success('Success', 'Agenda successfully updated.');
        return back();
    }

    public function destroyAgenda(Agenda $agenda)
    {
        Agenda::destroy($agenda->id);
        return response()->json($agenda);
    }
}
