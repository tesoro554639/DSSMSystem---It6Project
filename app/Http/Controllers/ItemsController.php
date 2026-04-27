<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Status;
use App\Models\Bale;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemsController extends Controller
{
    public function index()
    {
        $items = Item::with(['category', 'status', 'bale'])->orderByDesc('created_at')->paginate(15);
        return view('items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        $statuses = Status::all();
        $bales = Bale::orderByDesc('created_at')->get();
        
        return view('items.create', compact('categories', 'statuses', 'bales'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bale_id' => 'required|exists:bales,id',
            'category_id' => 'required|exists:categories,id',
            'status_id' => 'required|exists:statuses,id',
            'item_code' => 'required|string|unique:items,item_code',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $item = Item::create($validated);

        return redirect()->route('stock-in.show', $item->bale_id)
            ->with('success', 'Item recorded successfully.');
    }

    public function show($id)
    {
        $item = Item::with(['category', 'status', 'bale', 'transactions'])->findOrFail($id);
        return view('items.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        $statuses = Status::all();

        return view('items.edit', compact('item', 'categories', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'item_code' => [
                'required', 
                'string', 
                Rule::unique('items', 'item_code')->ignore($id)
            ],
            'category_id' => 'required|exists:categories,id',
            'status_id' => 'required|exists:statuses,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

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
            ->with('success', 'Item removed from the bale successfully.');
    }
}