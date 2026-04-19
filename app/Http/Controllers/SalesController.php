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
        $items = Item::where('is_sold', false)
            ->with(['category', 'status', 'bale'])
            ->get()
            ->groupBy('category.name');
        return view('sales.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,gcash,card,mixed',
            'notes' => 'nullable|string',
        ]);

        $transaction = DB::transaction(function () use ($request, $validated) {
            $subtotal = 0;
            $transactionItems = [];

            foreach ($validated['items'] as $itemData) {
                $item = Item::findOrFail($itemData['item_id']);
                $quantity = $itemData['quantity'];
                $unitPrice = $item->price;
                $itemSubtotal = $unitPrice * $quantity;

                $subtotal += $itemSubtotal;

                $transactionItems[] = [
                    'item_id' => $item->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $itemSubtotal,
                ];

                $item->update([
                    'is_sold' => true,
                ]);
            }

            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'transaction_number' => Transaction::generateTransactionNumber(),
                'subtotal' => $subtotal,
                'total_amount' => $subtotal,
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($transactionItems as $ti) {
                $transaction->items()->attach($ti['item_id'], [
                    'quantity' => $ti['quantity'],
                    'unit_price' => $ti['unit_price'],
                    'subtotal' => $ti['subtotal'],
                ]);
            }

            return $transaction;
        });

        return redirect()->route('sales.show', $transaction->id)
            ->with('success', 'Transaction completed successfully.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'items.category', 'items.status']);
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