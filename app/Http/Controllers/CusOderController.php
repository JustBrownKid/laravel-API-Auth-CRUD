<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CusOderController extends Controller
{   
    public function order(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $updatedItems = [];

        // Process each item in the request
        foreach ($request->items as $itemData) {
            $item = Item::find($itemData['id']);

            if ($item->quantity < $itemData['quantity']) {
                return response()->json([
                    'message' => "Item ID {$item->id} does not have enough quantity.",
                    'available_quantity' => $item->quantity
                ], 400);
            }

            $item->quantity -= $itemData['quantity'];
            $item->save();
        }
        $orderId = 'ORDID-' . now()->format('mdHis') . '-' . rand(100000000, 999999999);
        return response()->json([
            'message' => 'Items ordered successfully.',
            'orderId' => $orderId,
        ], 200);
    }

}