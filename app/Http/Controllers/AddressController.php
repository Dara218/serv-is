<?php

namespace App\Http\Controllers;

use App\Models\ServiceAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AddressController extends Controller
{
    public function storeAddress(Request $request){
        // add delete function on secondary address
        // add what to see when no address is present
        ServiceAddress::create([
            'user_id' => Auth::user()->id,
            'address' => $request->address,
            'is_primary' => 0,
            'is_active' => 0
        ]);

        Alert::success('Success', 'Address successfully added.');
        return back();
    }

    public function updateChangeAddress(Request $request){

        $primaryAddress = ServiceAddress::where('user_id', Auth::user()->id)
                                            ->where('is_primary', 1)
                                            ->first();

        $secondaryAddress = ServiceAddress::where('user_id', Auth::user()->id)
                                            ->where('is_primary', 0)
                                            ->first();

        if ($request->address == false){
            $primaryAddress->update([
                'is_primary' => 0,
                'is_active' => 0
            ]);

            $secondaryAddress->update([
                'is_primary' => 1,
                'is_active' => 1
            ]);
        }

        return response()->json($request->address);
    }

    public function updateChangeSecondaryAddress(Request $request){

        $primaryAddress = ServiceAddress::where('user_id', Auth::user()->id)
                                            ->where('is_primary', 1)
                                            ;

        $secondaryAddress = ServiceAddress::where('id', $request->secondaryAddressId)
                                            ->where('user_id', Auth::user()->id)
                                            ->where('is_primary', 0)
                                            ->first();


        if ($request->address == true){
            $primaryAddress->update([
                'is_primary' => 0,
                'is_active' => 0
            ]);

            $secondaryAddress->update([
                'is_primary' => 1,
                'is_active' => 1
            ]);
        }

        return response()->json($secondaryAddress);
    }

    public function updatePrimaryAddress(Request $request){
        ServiceAddress::where('id', $request->primaryAddressId)->first()->update([
            'address' => $request->primaryAddress
        ]);

        return response()->json($request);
    }

    public function updateSecondaryAddress(Request $request){
        ServiceAddress::where('id', $request->secondaryAddressId)->first()->update([
            'address' => $request->secondaryAddress
        ]);

        return response()->json($request);
    }

    public function updateToPrimaryAddress(Request $request){
        ServiceAddress::where('is_primary', 0)->first()->update([
            'is_primary' => 1,
            'is_active' => 1
        ]);

        return response()->json($request->secondaryAddressId);
    }

    public function destroyAddress(Request $request){
        ServiceAddress::destroy($request->id);

        return response()->json($request->id);
    }

    public function updateToSecondaryAddress(Request $request){

        $checkPrimaryAddress = ServiceAddress::where('user_id', Auth::user()->id)
                        ->where('is_primary', 1)
                        ->exists();

        if(! $checkPrimaryAddress)
        {
            ServiceAddress::where('is_primary', 0)->first()->update([
                'is_primary' => 1,
                'is_active' => 1
            ]);
        }

        return response()->json($request->secondaryAddressId);
    }
}
