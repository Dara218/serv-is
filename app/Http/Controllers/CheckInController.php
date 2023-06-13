<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;

class CheckInController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $event = $request->all();

        if($event['type'] === 'checkout.session.completed')
        {
            $amount = $event['data']['object']['amount_total'];
            $lastEventAmount = $amount / 100;

            $userId = $event['data']['object']['client_reference_id'];
            $stripeCredentials = [
                'amount' => $lastEventAmount,
                'user_id' => $userId,
            ];

            $this->updateUserBalance($lastEventAmount, $userId);
            WalletHistory::create($stripeCredentials);
        }
    }

    public function updateUserBalance($lastEventAmount, $userId){
        $user = User::where('id', $userId)->first();
        $user->update(['current_balance' => $user->current_balance + $lastEventAmount]);
    }

    public function storeCheckIn(Request $request)
    {
        Stripe::setApiKey(config('stripe.sk'));
        $session = CheckoutSession::create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'PHP',
                            'product_data' => [
                                'name' => "$request->price load"
                            ],
                            'unit_amount' => $request->price * 100
                        ],
                        'quantity' => 1
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('index'),
                'cancel_url' => route('showWallet'),
                'client_reference_id' => Auth::user()->id
        ]);

        return redirect()->away($session->url);
    }
}
