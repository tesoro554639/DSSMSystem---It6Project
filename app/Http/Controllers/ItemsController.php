<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Bale;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index()
    {
        $items = Item::with(['category', 'bale'])->orderByDesc('created_at')->paginate(15);
        return view('items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        $bales = Bale::orderByDesc('created_at')->get();
        return view('items.create', compact('categories', 'bales'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bale_id' => 'required|exists:bales,id',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Triggers handle item_code, is_sold (default 0), and quantity (default 1)
        $item = Item::create($validated);

        return redirect()->route('stock-in.show', $item->bale_id)
            ->with('success', 'Item recorded successfully.');
    }

    public function show($id)
    {
        $item = Item::with(['category', 'bale', 'transactions'])->findOrFail($id);
        return view('items.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // is_sold is NOT updated here to preserve transaction integrity
        $item->update($validated);

        return redirect()->route('stock-in.show', $item->bale_id)
            ->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $baleId = $item->bale_id; 
        $item->delete();
        
        return redirect()->route('stock-in.show', $baleId)
            ->with('success', 'Item removed successfully.');
    }
}