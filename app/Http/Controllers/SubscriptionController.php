<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function index(Request $request)
    {
        return view('subscription', [
            'intent' => $request->user()->createSetupIntent()
        ]);
    }


    public function subscribe(Request $request)
    {
        $user = $request->user();

        try {
            $user->newSubscription('default', 'price_1TN76CAcRo8nDFi75NOtOU6q')->create($request->payment_method_id);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }




        return response()->json(['message' => 'Subscription successful!']);
    }
}
