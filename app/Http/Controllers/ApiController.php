<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceOrder;
use App\Models\User;

class ApiController extends Controller
{
    public function createServiceOrder(Request $request)
    {
        try {

            # Validate request
            $request->validate([
                'vehiclePlate' => 'required|string|min:7|max:7',
                'entryDateTime' => 'required|date',
                'exitDateTime' => 'required|date',
                'priceType' => 'required|string',
                'price' => 'required|numeric',
                'user_id' => 'required|int',
            ]); 

            # Verify if user exists
            $user = User::where('id', $request->user_id)->first();
            if (!$user) {
                return response()->json(['message' => 'User not found!'], 404);
            }

            # Create service order
            $serviceOrder = ServiceOrder::create([
                'vehiclePlate' => $request->vehiclePlate,
                'entryDateTime' => $request->entryDateTime,
                'exitDateTime' => $request->exitDateTime,
                'priceType' => $request->priceType,
                'price' => $request->price,
                'userId' => $user->id,
            ]);

            return response()->json(['message' => 'Service order created successfully!'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => "Error creating service order: {$e->getMessage()}"], 500);
        }
    }
}
