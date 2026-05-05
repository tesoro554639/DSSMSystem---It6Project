<?php

namespace Database\Seeders;

use App\Models\Bale;
use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::all();
        $categories = Category::all();
        $users = User::all();


        $balesData = [
            [
                'supplier' => $suppliers[0]->name,
                'purchase_price' => 1500.00,
                'purchase_date' => Carbon::now()->subDays(5),
                'items' => [
                    ['category' => 'Tops', 'price' => 120.00, 'desc' => 'Blue cotton shirt'],
                    ['category' => 'Tops', 'price' => 150.00, 'desc' => 'White polo shirt'],
                    ['category' => 'Tops', 'price' => 100.00, 'desc' => 'Gray t-shirt'],
                    ['category' => 'Bottoms', 'price' => 200.00, 'desc' => 'Black jeans'],
                    ['category' => 'Dresses', 'price' => 350.00, 'desc' => 'Floral summer dress'],
                ]
            ],
            [
                'supplier' => $suppliers[1]->name,
                'purchase_price' => 2200.00,
                'purchase_date' => Carbon::now()->subDays(3),
                'items' => [
                    ['category' => 'Tops', 'price' => 130.00, 'desc' => 'Red blouse'],
                    ['category' => 'Bottoms', 'price' => 220.00, 'desc' => 'Blue denim'],
                    ['category' => 'Outerwear', 'price' => 500.00, 'desc' => 'Leather jacket'],
                    ['category' => 'Footwear', 'price' => 350.00, 'desc' => 'Heels'],
                ]
            ],
        ];

        foreach ($balesData as $baleData) {
            $supplier = $suppliers->firstWhere('name', $baleData['supplier']);
            
            // bale_number and total_items are now handled by triggers
            $bale = Bale::create([
                'supplier_id' => $supplier->id,
                'purchase_price' => $baleData['purchase_price'],
                'purchase_date' => $baleData['purchase_date'],
                'total_items' => 0, 
            ]);

            foreach ($baleData['items'] as $itemData) {
                $category = $categories->firstWhere('name', $itemData['category']);
                
                // item_code is now handled by the trigger
                Item::create([
                    'bale_id' => $bale->id,
                    'category_id' => $category->id,
                    'description' => $itemData['desc'],
                    'price' => $itemData['price'],
                    'quantity' => 1,
                    'is_sold' => false,
                ]);
            }
        }

        $allItems = Item::all();

        $todayTransactions = [
            [
                'items_count' => 2,
                'method_id' => 1,
                'cashier_id' => $users->first()->id,
            ],
        ];

        foreach ($todayTransactions as $txnData) {
            $items = Item::where('is_sold', false)->take($txnData['items_count'])->get();

            if ($items->isEmpty()) continue;

            $total = $items->sum('price');

            $transaction = Transaction::create([
                'user_id' => $txnData['cashier_id'],
                'transaction_number' => Transaction::generateTransactionNumber(),
                'subtotal' => $total,
                'total_amount' => $total,
                'method_id' => $txnData['method_id'],
            ]);

            foreach ($items as $item) {
                $transaction->items()->attach($item->id, [
                    'quantity' => 1,
                    'unit_price' => $item->price,
                    'subtotal' => $item->price,
                ]);
                
                // The after_sale_deduct_inventory trigger will now 
                // handle setting is_sold to true automatically!
            }
        }

        $this->command->info('Sample data seeded successfully! Triggers handled the codes and statuses.');
    }
}