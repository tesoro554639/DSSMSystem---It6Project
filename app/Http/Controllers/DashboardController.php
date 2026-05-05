<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Bale; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $dailySales = Transaction::whereDate('created_at', $today)->sum('total_amount');
        $dailyTransactions = Transaction::whereDate('created_at', $today)->count();
        
        $itemsSoldToday = TransactionItem::whereHas('transaction', function ($query) use ($today) {
            $query->whereDate('created_at', $today);
        })->count(); 

        $totalInventory = Item::count();
        $availableItems = Item::where('is_sold', false)->count();
        $soldItems = Item::where('is_sold', true)->count();

        $categoryInventory = DB::table('items')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->select('categories.name as category')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN items.is_sold = 0 THEN 1 ELSE 0 END) as available')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        $recentTransactions = Transaction::with('user')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $recentBales = Bale::with('supplier')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'dailySales', 'dailyTransactions', 'itemsSoldToday',
            'totalInventory', 'availableItems', 'soldItems',
            'categoryInventory', 'recentTransactions', 'recentBales'
        ));
    }
}