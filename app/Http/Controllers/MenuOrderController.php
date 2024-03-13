<?php

namespace App\Http\Controllers;

use App\Models\MenuOrder;
use Illuminate\Http\Request;

class MenuOrderController extends Controller {

    public function index()
    {
        if (MenuOrder::all()->isEmpty())
            return response()->json(['error' => 'There are no menu orders'], 404);

        try
        {
            return MenuOrder::all();
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => 'An error occurred while fetching the menu orders'], 500);
        }
    }

    public function store(Request $request)
    {
        if (!is_numeric($request->menu_id))
            return response()->json(['error' => 'The menu_id must be a number'], 400);

        if (!is_numeric($request->order_id))
            return response()->json(['error' => 'The order_id must be a number'], 400);

        if (!is_numeric($request->quantity))
            return response()->json(['error' => 'The quantity must be a number'], 400);

        if ($request->quantity < 1)
            return response()->json(['error' => 'The quantity must be at least 1'], 400);

        $request->validate([
            'menu_id'  => 'required',
            'order_id' => 'required',
            'quantity' => 'required',
        ]);

        try
        {
            $menuOrder = MenuOrder::create($request->all());
        } catch (\Exception $e)
        {
            return response()->json(['error' => 'The menu order could not be created'], 500);
        }

        return response()->json($menuOrder, 201);
    }

    public function show($menu_id, $order_id)
    {
        if (!is_numeric($order_id))
            return response()->json(['error' => 'The order_id must be a number'], 400);

        if (!is_numeric($menu_id))
            return response()->json(['error' => 'The menu_id must be a number'], 400);

        if (MenuOrder::where('order_id', $order_id)->where(
            'menu_id',
            $menu_id
        )->doesntExist())
            return response()->json(['error' => 'The menu order does not exist'], 404);

        try
        {
            return MenuOrder::where('order_id', $order_id)->where(
                'menu_id',
                $menu_id
            )->first();
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => 'An error occurred while fetching the menu order'], 500);
        }
    }

    public function update(Request $request, $menu_id, $order_id)
    {
        if (!is_numeric($order_id))
            return response()->json(['error' => 'The order_id must be a number'], 400);

        if (!is_numeric($menu_id))
            return response()->json(['error' => 'The menu_id must be a number'], 400);

        if (MenuOrder::where('order_id', $order_id)->where(
            'menu_id',
            $menu_id
        )->doesntExist())
            return response()->json(['error' => 'The menu order does not exist'], 404);

        $menuOrder = MenuOrder::where('order_id', $order_id)->where(
            'menu_id',
            $menu_id
        )->first();

        $request->validate([
            'menu_id'  => 'required',
            'order_id' => 'required',
            'quantity' => 'required',
        ]);

        try
        {
            $menuOrder->update($request->all());
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => 'The menu order could not be updated'], 500);
        }

        return response()->json($menuOrder, 200);
    }

    public function destroy($menu_id, $order_id)
    {
        if (!is_numeric($order_id))
            return response()->json(['error' => 'The order_id must be a number'], 400);

        if (!is_numeric($menu_id))
            return response()->json(['error' => 'The menu_id must be a number'], 400);

        if (MenuOrder::where('order_id', $order_id)->where(
            'menu_id',
            $menu_id
        )->doesntExist())
            return response()->json(['error' => 'The menu order does not exist'], 404);

        $menuOrder = MenuOrder::where('order_id', $order_id)->where(
            'menu_id',
            $menu_id
        )->first();

        try
        {
            $menuOrder->delete();
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => 'The menu order could not be deleted'], 500);
        }

        return response()->json(NULL, 204);
    }

    public function showMenuOrdersByOrder($order_id)
    {
        if (!is_numeric($order_id))
            return response()->json(['error' => 'The order_id must be a number'], 400);

        if (MenuOrder::where('order_id', $order_id)->doesntExist())
            return response()->json(['error' => 'The order does not exist'], 404);

        try
        {
            return MenuOrder::where('order_id', $order_id)->get();
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => 'An error occurred while fetching the menu orders'], 500);
        }
    }

}
