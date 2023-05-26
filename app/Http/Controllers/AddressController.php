<?php

namespace App\Http\Controllers;

use App\Models\ServiceAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AddressController extends Controller
{
    public function storeAddress(Request $request){
        // return $request;
        ServiceAddress::create([
            'user_id' => Auth::user()->id,
            'address' => $request->address,
            'is_primary' => 0,
            'is_active' => 0
        ]);

        Alert::success('Success', 'Address successfully added.');
        return back();
    }

    public function updatePrimaryAddress(Request $request){

        $primaryAddress = ServiceAddress::where('user_id', Auth::user()->id)
                                            ->where('is_primary', 1)
                                            ->first();

        $secondaryAddress = ServiceAddress::where('user_id', Auth::user()->id)
                                            ->where('is_primary', 0)
                                            ->first();

        if($request->data == true)
        {
            $primaryAddress->update([
                'is_primary' => 0,
                'is_active' => 0
            ]);

            $secondaryAddress->update([
                'is_primary' => 1,
                'is_active' => 1
            ]);
        }

        return response()->json($request);
    }
}
