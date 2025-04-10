<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function itemsOrder(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = Item::find($request->id);

        if ($item->quantity < $request->quantity) {
            return response()->json([
                'message' => 'Not enough quantity available.',
                'available_quality' => $item->quantity
            ], 400);
        }

        $item->quantity -= $request->quantity;
        $item->save();

        return response()->json([
            'message' => 'Item used successfully.',
            'item' => $item
        ], 200);
    }

    public function index()
    {
       $items = Item::all();
       return response()->json([
        'message' => 'Items retrieved successfully',
        'status' => 200,
        'success' => true,
        'data' => $items,
       ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'sku' => 'required|string',
            'image' => 'nullable|url', 
        ]);
        
        $item = Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sku' => $request->sku,
            'image' => $request->image ?? 'https://example.com/default-image.jpg',
        ]);
        return response()->json([
            'message' => 'Item created successfully',
            'status' => 201,
            'success' => true,
            'data' => $item,
        ]);
    }

  
    public function show(string $id)
    {
        $item = Item::findOrFail($id);
        return response()->json([
            'data' => $item,
            'status' => 201,
            'success' => true,
            'data' => $item,
        ]);
    }
        public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'quantity' => 'sometimes|required|integer',
            'sku' => 'sometimes|required|string',
            'image' => 'nullable|string', 
        ]);

        $item->update($request->only([
            'name', 'description', 'price', 'quantity', 'sku', 'image'
        ]));

        return response()->json([
            'message' => 'Item updated successfully',
            'item' => $item,
        ]);

        }

    // Delete Selection
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return response()->json([
            'message' => 'Item deleted successfully.'
        ], 200);
    }
}
