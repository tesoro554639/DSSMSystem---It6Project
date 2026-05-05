<?php

namespace App\Http\Controllers;

use App\Models\Bale;
use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StockInController extends Controller
{
    public function index()
    {
        $bales = Bale::with(['supplier', 'items'])->orderByDesc('created_at')->paginate(10);
        return view('stock-in.index', compact('bales'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('stock-in.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id'    => 'required|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'purchase_date'  => 'required|date',
            'notes'          => 'nullable|string',
        ]);

        // total_items and bale_number are handled by database triggers
        $validated['total_items'] = 0;

        $bale = Bale::create($validated);

        return redirect()->route('stock-in.show', $bale->id)
            ->with('success', 'Bale created successfully.');
    }

    public function show($id)
    {
        $bale = Bale::findOrFail($id);

        // Removed 'status' from eager loading
        $bale->load(['supplier', 'items.category']);
        $categories = Category::all();
        
        // Removed Status::all() as the model and table are gone
        return view('stock-in.show', compact('bale', 'categories'));
    }

    public function addItems(Request $request, $id)
    {
        $bale = Bale::findOrFail($id);
        
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.category_id' => 'required|exists:categories,id',
            'items.*.description' => 'nullable|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1', 
        ]);

        DB::transaction(function () use ($bale, $validated) {
            foreach ($validated['items'] as $itemData) {
                $count = $itemData['quantity'];
                
                // One Row = One Item: Loop creates individual unique records
                for ($i = 0; $i < $count; $i++) {
                    Item::create([
                        'bale_id' => $bale->id,
                        'category_id' => $itemData['category_id'],
                        'description' => $itemData['description'] ?? null,
                        'price' => $itemData['price'],
                        'quantity' => 1, 
                        'is_sold' => 0,
                    ]);
                }
            }
        });

        return redirect()->route('stock-in.show', $id)
            ->with('success', "Items successfully generated and added to the bale.");
    }

    public function edit($id)
    {
        $bale = Bale::findOrFail($id);
        $suppliers = Supplier::all();

        return view('stock-in.edit', compact('bale', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $bale = Bale::findOrFail($id);

        $validated = $request->validate([
            'bale_number' => [
                'required', 
                'string', 
                Rule::unique('bales', 'bale_number')->ignore($id)
            ],
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $bale->update($validated);

        return redirect()->route('stock-in.index')
            ->with('success', 'Bale updated successfully.');
    }

    public function destroy($id)
    {
        $bale = Bale::findOrFail($id);
        $bale->delete();
        
        return redirect()->route('stock-in.index')
            ->with('success', 'Bale deleted successfully.');
    }
}