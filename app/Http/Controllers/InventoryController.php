<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Status;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with(['category', 'status', 'bale.supplier']);

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status_id', $request->status);
        }

        if ($request->has('is_sold')) {
            $query->where('is_sold', $request->boolean('is_sold'));
        }

        $items = $query->orderByDesc('created_at')->paginate(20);
        $categories = Category::all();
        $statuses = Status::all();

        $availableCount = Item::where('is_sold', false)->count();
        $soldCount = Item::where('is_sold', true)->count();
        $totalCount = Item::count();

        return view('inventory.index', compact('items', 'categories', 'statuses', 'availableCount', 'soldCount', 'totalCount'));
    }

    public function show(Item $item)
    {
        $item->load(['category', 'status', 'bale.supplier', 'transactions']);
        return view('inventory.show', compact('item'));
    }

    public function getInventoryByCategory()
    {
        $inventory = Category::withCount(['items' => function ($query) {
            $query->where('is_sold', false);
        }])->get();

        return response()->json($inventory);
    }
}