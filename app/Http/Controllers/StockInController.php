<?php

namespace App\Http\Controllers;

use App\Models\Bale;
use App\Models\Category;
use App\Models\Item;
use App\Models\Status;
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
            // 'bale_number'    => 'required|string|unique:bales,bale_number', -> the code generator trigger handles this
            'supplier_id'    => 'required|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'purchase_date'  => 'required|date',
            'notes'          => 'nullable|string',
        ]);

        $validated['total_items'] = 0;

        $bale = Bale::create($validated);

        return redirect()->route('stock-in.show', $bale->id)
            ->with('success', 'Bale created. Add items to automatically update the total count.');
    }

    public function show($id)
    {
        $bale = Bale::findOrFail($id);

        $bale->load(['supplier', 'items.category', 'items.status']);
        $categories = Category::all();
        $statuses = Status::all();
        return view('stock-in.show', compact('bale', 'categories', 'statuses'));
    }

    public function addItems(Request $request, $id)
    {
        $bale = Bale::findOrFail($id);
        
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.category_id' => 'required|exists:categories,id',
            'items.*.description' => 'nullable|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1', // This now determines the number of records
        ]);

        DB::transaction(function () use ($bale, $validated) {
            foreach ($validated['items'] as $itemData) {
                $count = $itemData['quantity'];
                
                // Create a unique row for every single item
                for ($i = 0; $i < $count; $i++) {
                    Item::create([
                        'bale_id' => $bale->id,
                        'category_id' => $itemData['category_id'],
                        'description' => $itemData['description'] ?? null,
                        'price' => $itemData['price'],
                        'quantity' => 1, // Every unique item always has a quantity of 1
                        'is_sold' => 0,
                        'status_id' => 1, // 'Available'
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
            'total_items' => 'required|integer|min:1',
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