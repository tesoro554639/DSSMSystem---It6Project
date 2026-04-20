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
            'bale_number' => 'required|string|unique:bales,bale_number',
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'total_items' => 'required|integer|min:1',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $bale = Bale::create($validated);

        return redirect()->route('stock-in.show', $bale->id)
            ->with('success', 'Bale recorded successfully. Now add items to the bale.');
    }

    public function show($id)
    {
        $bale = Bale::findOrFail($id);

        $bale->load(['supplier', 'items.category', 'items.status']);
        $categories = Category::all();
        $statuses = Status::all();
        return view('stock-in.show', compact('bale', 'categories', 'statuses'));
    }

    public function addItems(Request $request, Bale $bale)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.category_id' => 'required|exists:categories,id',
            'items.*.status_id' => 'required|exists:statuses,id',
            'items.*.item_code' => 'required|string|unique:items,item_code',
            'items.*.description' => 'nullable|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($bale, $validated) {
            foreach ($validated['items'] as $itemData) {
                Item::create([
                    'bale_id' => $bale->id,
                    'category_id' => $itemData['category_id'],
                    'status_id' => $itemData['status_id'],
                    'item_code' => $itemData['item_code'],
                    'description' => $itemData['description'] ?? null,
                    'price' => $itemData['price'],
                    'quantity' => $itemData['quantity'],
                ]);
            }
        });

        return redirect()->route('stock-in.index')
            ->with('success', 'Items added to bale successfully.');
    }

    public function destroy($id)
    {
        $bale = Bale::findOrFail($id);
        $bale->delete();
        return redirect()->route('stock-in.index')
            ->with('success', 'Bale deleted successfully.');
    }
}