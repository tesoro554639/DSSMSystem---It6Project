<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'items'])
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('sales.index', compact('transactions'));
    }

    public function create()
    {
        // Removed 'status' relationship from eager loading
        $items = Item::where('is_sold', false)
            ->with(['category', 'bale'])
            ->get()
            ->groupBy('category.name');
        
        $paymentMethods = DB::table('payment_methods')->get();
        
        return view('sales.create', compact('items', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'method_id' => 'required|exists:payment_methods,id', 
            'notes' => 'nullable|string',
        ]);

        try {
            $transaction = DB::transaction(function () use ($validated) {
                $totalTransactionAmount = 0;
                $transactionItems = [];

                foreach ($validated['items'] as $itemData) {
                    $item = Item::lockForUpdate()->findOrFail($itemData['item_id']);
                    
                    if ($item->is_sold) {
                        throw new \Exception("Item {$item->item_code} is already sold.");
                    }

                    // In One Row = One Item, quantity is always 1
                    $totalTransactionAmount += $item->price;

                    $transactionItems[$item->id] = [
                        'quantity' => 1,
                        'unit_price' => $item->price,
                        'subtotal' => $item->price, 
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Trigger 'after_sale_sync' handles setting is_sold = 1 and quantity = 0
                }

                $transaction = Transaction::create([
                    'user_id' => auth()->id(),
                    'transaction_number' => Transaction::generateTransactionNumber(),
                    'subtotal' => $totalTransactionAmount,
                    'total_amount' => $totalTransactionAmount,
                    'method_id' => $validated['method_id'],
                    'notes' => $validated['notes'] ?? null,
                ]);

                // This attach() fires the database triggers
                $transaction->items()->attach($transactionItems);

                return $transaction;
            });

            return redirect()->route('sales.show', $transaction->id)
                ->with('success', 'Transaction completed successfully.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        // Removed 'status' relationship from eager loading
        $transaction = Transaction::with(['user', 'items.category', 'paymentMethod'])
            ->findOrFail($id); 

        return view('sales.show', compact('transaction'));
    }

    public function getAvailableItems()
    {
        // Removed 'status' relationship
        $items = Item::where('is_sold', false)
            ->with(['category', 'bale'])
            ->get();
        return response()->json($items);
    }
}