<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function dailySales(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        // Removed 'items.status' from eager loading
        $transactions = Transaction::with(['user', 'items.category', 'paymentMethod'])
            ->whereDate('created_at', $date)
            ->orderByDesc('created_at')
            ->get();

        $totalSales = $transactions->sum('total_amount');
        $totalTransactions = $transactions->count();

        // Refactored: In One Row = One Item, total items sold is the count of pivot records
        $totalItemsSold = TransactionItem::whereHas('transaction', function ($query) use ($date) {
            $query->whereDate('created_at', $date);
        })->count();

        $paymentBreakdown = $transactions->groupBy(function ($txn) {
            return $txn->paymentMethod->method_name ?? 'Unknown';
        })->map(fn ($group) => $group->sum('total_amount'));

        return view('reports.daily-sales', compact(
            'transactions',
            'date',
            'totalSales',
            'totalTransactions',
            'totalItemsSold',
            'paymentBreakdown'
        ));
    }

    public function inventoryStatus(Request $request)
    {
        $categoryId = $request->input('category');

        // Removed 'status' relationship
        $inventoryQuery = Item::with(['category', 'bale.supplier']);

        if ($categoryId) {
            $inventoryQuery->where('category_id', $categoryId);
        }

        $items = $inventoryQuery->orderByDesc('created_at')->paginate(15);

        $categorySummary = DB::table('items')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->select('categories.name as category_name')
            ->selectRaw('COUNT(*) as total_items')
            ->selectRaw('SUM(CASE WHEN items.is_sold = 0 THEN 1 ELSE 0 END) as available')
            ->selectRaw('SUM(CASE WHEN items.is_sold = 1 THEN 1 ELSE 0 END) as sold')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        $overallStats = [
            'total' => Item::count(),
            'available' => Item::where('is_sold', false)->count(),
            'sold' => Item::where('is_sold', true)->count(),
            // Simplified: quantity is always 1 for available items in this model
            'total_value' => Item::where('is_sold', false)->sum('price'),
        ];

        return view('reports.inventory-status', compact('items', 'categorySummary', 'overallStats'));
    }

    public function transactionReceipt(Transaction $transaction)
    {
        // Removed 'items.status' from eager loading
        $transaction->load(['user', 'items.category', 'paymentMethod']);
        return view('reports.receipt', compact('transaction'));
    }
}