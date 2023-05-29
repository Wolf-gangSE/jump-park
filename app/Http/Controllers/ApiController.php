<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceOrder;
use App\Models\User;

class ApiController extends Controller
{
    public function createUser(Request $request)
    {
        try {

            # Validate request
            $request->validate([
                'name' => 'required|string',
            ]);

            # Create user
            $user = User::create([
                'name' => $request->name,
            ]);

            return response()->json(['message' => 'User created successfully!'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => "Error creating user: {$e->getMessage()}"], 500);
        }
    }
    
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
                'userId' => 'required|int',
            ]); 

            # Verify if user exists
            $user = User::where('id', $request->userId)->first();
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
                'userId' => $request->userId,
            ]);

            # Associate user to service order
            $serviceOrder->user()->associate($user);

            # Save service order
            $serviceOrder->save();

            return response()->json(['message' => 'Service order created successfully!'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => "Error creating service order: {$e->getMessage()}"], 500);
        }
    }

    public function getServiceOrders(Request $request)
    {
        try {

            # Validate request
            $request->validate([
                'vehiclePlate' => 'nullable|string|max:7',
            ]);

            # Get service orders paginated
            $results = ServiceOrder::where('vehiclePlate', 'like', "%{$request->vehiclePlate}%")
                ->paginate(5);

            $serviceOrders = $results->items();

            # Add user name to service orders and remove user_id
            foreach ($serviceOrders as $serviceOrder) {
                $serviceOrder->userName = $serviceOrder->user->name;
                unset($serviceOrder->userId);
                unset($serviceOrder->user);
            }

            # Return service orders
            return response()->json([
                'message' => 'Service orders retrieved successfully!', 
                'serviceOrders' => $serviceOrders
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => "Error getting service orders: {$e->getMessage()}"], 500);
        }
    }
}
