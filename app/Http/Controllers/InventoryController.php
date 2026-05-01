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

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            if ($request->status === 'sold') {
                $query->where('is_sold', true);
            } else {
                $query->where('status_id', $request->status)
                    ->where('is_sold', false);
            }
        }

        $items = $query->orderByDesc('created_at')->paginate(10);
        $categories = Category::all();
        $statuses = Status::all();

        $availableCount = Item::where('is_sold', false)->count();
        $soldCount = Item::where('is_sold', true)->count();
        $totalCount = Item::count();

        return view('inventory.index', compact(
            'items', 'categories', 'statuses', 
            'availableCount', 'soldCount', 'totalCount'
        ));
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
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

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        
        $baleId = $item->bale_id; 
        
        $item->delete();
        
        return redirect()->route('inventory.index', $baleId)
            ->with('success', 'Item removed successfully.');
    }
}