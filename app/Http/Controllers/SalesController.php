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
        
        $paymentMethods = DB::table('payment_methods')->get();
        
        return view('sales.create', compact('items', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
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

                    // PHP calculation is only needed for the main Transaction total
                    $itemSubtotal = $item->price * $itemData['quantity'];
                    $totalTransactionAmount += $itemSubtotal;

                    $transactionItems[$item->id] = [
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $item->price,

                        
                        'subtotal' => 0,  // the calc_subtotal trigger will overwrite this
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // $item->update(['is_sold' => true]); -> trigger handles this
                }

                $transaction = Transaction::create([
                    'user_id' => auth()->id(),
                    'transaction_number' => Transaction::generateTransactionNumber(),
                    'subtotal' => $totalTransactionAmount,
                    'total_amount' => $totalTransactionAmount,
                    'method_id' => $validated['method_id'],
                    'notes' => $validated['notes'] ?? null,
                ]);

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