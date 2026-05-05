<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        // Removed 'status' from eager loading as the relationship no longer exists
        $query = Item::with(['category', 'bale.supplier']);

        // Filter by Category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Simplified Status Filtering
        // Since status_id is gone, we only filter by the is_sold boolean
        if ($request->filled('status')) {
            if ($request->status === 'sold') {
                $query->where('is_sold', true);
            } elseif ($request->status === 'available') {
                $query->where('is_sold', false);
            }
        }

        $items = $query->orderByDesc('created_at')->paginate(15);
        $categories = Category::all();

        // Stats for the top cards
        $availableCount = Item::where('is_sold', false)->count();
        $soldCount = Item::where('is_sold', true)->count();
        $totalCount = Item::count();

        return view('inventory.index', compact(
            'items', 'categories', 
            'availableCount', 'soldCount', 'totalCount'
        ));
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        // Removed 'status' from eager loading
        $item->load(['category', 'bale.supplier', 'transactions']);
        
        return view('inventory.show', compact('item'));
    }

    public function getInventoryByCategory()
    {
        // This is useful for dashboard charts
        $inventory = Category::withCount(['items' => function ($query) {
            $query->where('is_sold', false);
        }])->get();

        return response()->json($inventory);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        
        return redirect()->route('inventory.index')
            ->with('success', 'Item removed successfully.');
    }
}