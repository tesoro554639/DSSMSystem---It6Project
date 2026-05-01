<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use App\Models\PaymentMethod;
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
        $items = Item::where('is_sold', false)
            ->with(['category', 'status', 'bale'])
            ->get()
            ->groupBy('category.name');
        
        // Added payment methods for the selection in your view
        $paymentMethods = DB::table('payment_methods')->get();
        
        return view('sales.create', compact('items', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'method_id' => 'required|exists:payment_methods,id', // Fixed validation to match migration
            'notes' => 'nullable|string',
        ]);

        try {
            $transaction = DB::transaction(function () use ($validated) {
                $subtotal = 0;
                $transactionItems = [];

                foreach ($validated['items'] as $itemData) {
                    $item = Item::lockForUpdate()->findOrFail($itemData['item_id']);
                    
                    // Safety check to ensure item wasn't sold while user was at checkout
                    if ($item->is_sold) {
                        throw new \Exception("Item {$item->item_code} is already sold.");
                    }

                    $quantity = $itemData['quantity'];
                    $unitPrice = $item->price;
                    $itemSubtotal = $unitPrice * $quantity;

                    $subtotal += $itemSubtotal;

                    // Prepare data for the attach() method
                    $transactionItems[$item->id] = [
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'subtotal' => $itemSubtotal,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $item->update(['is_sold' => true]);
                }

                $transaction = Transaction::create([
                    'user_id' => auth()->id(),
                    'transaction_number' => Transaction::generateTransactionNumber(),
                    'subtotal' => $subtotal,
                    'total_amount' => $subtotal,
                    'method_id' => $validated['method_id'], // Fixed field name
                    'notes' => $validated['notes'] ?? null,
                ]);

                // Efficiently attach all items at once
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
        // Added load for payment method to show on the receipt
        $transaction = Transaction::with(['user', 'items.category', 'items.status', 'paymentMethod'])
            ->findOrFail($id); 

        return view('sales.show', compact('transaction'));
    }

    public function getAvailableItems()
    {
        $items = Item::where('is_sold', false)
            ->with(['category', 'status', 'bale'])
            ->get();
        return response()->json($items);
    }
}