<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        if (Order::all()->isEmpty())
            return response()->json(['error' => 'There are no orders'], 404);

        try
        {
            return Order::all();
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => 'An error occurred while fetching the orders'], 500);
        }
    }

    public function store(Request $request)
    {
        if (isset($request->client_id) && !is_numeric($request->client_id))
            return response()->json(['error' => 'The client_id must be a number'], 400);

        if (!isset($request->client_id))
            return response()->json(['error' => 'The client_id field is required'], 400);

        $request->validate([
            'client_id' => 'required',
        ]);

        try
        {
            $order = Order::create([
                'client_id' => $request->client_id,
                'created_at' => now()
            ]);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => 'An error occurred while creating the order'], 500);
        }
        return response()->json($order, 201);
    }

    public function show(Order $order)
    {
        if (!is_numeric($order->id))
            return response()->json(['error' => 'The order_id must be a number'], 400);

        if (Order::where('id', $order->id)->doesntExist())
            return response()->json(['error' => 'The order does not exist'], 404);

        return $order;
    }

    public function update(Request $request, Order $order)
    {
        if (isset($request->status) && !in_array($request->status, ['pending', 'completed', 'cancelled']))
            return response()->json(['error' => 'The status must be pending, completed or cancelled'], 400);

        if (!isset($request->status))
            return response()->json(['error' => 'The status field is required'], 400);

        if (!is_numeric($order->id))
            return response()->json(['error' => 'The order_id must be a number'], 400);

        if (Order::where('id', $order->id)->doesntExist())
            return response()->json(['error' => 'The order does not exist'], 404);

        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        try
        {
            $history = new History();
            $history->action = "Order status updated to " . $request->status;
            $history->order_id = $order->id;
            $history->save();
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => 'An error occurred while creating the history'], 500);
        }

        try
        {
            $order->update([
                'status' => $request->status
            ]);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => 'An error occurred while updating the order'], 500);
        }

        return response()->json($order, 200);
    }

    public function destroy(Order $order)
    {
        if (!is_numeric($order->id))
            return response()->json(['error' => 'The order_id must be a number'], 400);

        if (Order::where('id', $order->id)->doesntExist())
            return response()->json(['error' => 'The order does not exist'], 404);

        try
        {
            $order->delete();
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => 'An error occurred while deleting the order'], 500);
        }

        return response()->json(null, 204);
    }


}
