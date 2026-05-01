<?php

namespace Database\Seeders;

use App\Models\Bale;
use App\Models\Category;
use App\Models\Item;
use App\Models\Status;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::all();
        $categories = Category::all();
        $statuses = Status::all();
        $users = User::all();

        $availableStatus = $statuses->where('name', 'Available')->first();
        $damagedStatus = $statuses->where('name', 'Damaged')->first();

        $balesData = [
            [
                'bale_number' => 'BALE-2026-001',
                'supplier' => $suppliers[0]->name,
                'purchase_price' => 1500.00,
                'total_items' => 15,
                'purchase_date' => Carbon::now()->subDays(5),
                'items' => [
                    ['code' => 'TOP-001', 'category' => 'Tops', 'price' => 120.00, 'desc' => 'Blue cotton shirt'],
                    ['code' => 'TOP-002', 'category' => 'Tops', 'price' => 150.00, 'desc' => 'White polo shirt'],
                    ['code' => 'TOP-003', 'category' => 'Tops', 'price' => 100.00, 'desc' => 'Gray t-shirt'],
                    ['code' => 'TOP-004', 'category' => 'Tops', 'price' => 180.00, 'desc' => 'Navy blouse'],
                    ['code' => 'BOT-001', 'category' => 'Bottoms', 'price' => 200.00, 'desc' => 'Black jeans'],
                    ['code' => 'BOT-002', 'category' => 'Bottoms', 'price' => 150.00, 'desc' => 'Khaki shorts'],
                    ['code' => 'DRS-001', 'category' => 'Dresses', 'price' => 350.00, 'desc' => 'Floral summer dress'],
                    ['code' => 'DRS-002', 'category' => 'Dresses', 'price' => 280.00, 'desc' => 'Black wrap dress'],
                    ['code' => 'OUT-001', 'category' => 'Outerwear', 'price' => 450.00, 'desc' => 'Denim jacket'],
                    ['code' => 'ACC-001', 'category' => 'Accessories', 'price' => 80.00, 'desc' => 'Leather belt'],
                ]
            ],
            [
                'bale_number' => 'BALE-2026-002',
                'supplier' => $suppliers[1]->name,
                'purchase_price' => 2200.00,
                'total_items' => 20,
                'purchase_date' => Carbon::now()->subDays(3),
                'items' => [
                    ['code' => 'TOP-005', 'category' => 'Tops', 'price' => 130.00, 'desc' => 'Red blouse'],
                    ['code' => 'TOP-006', 'category' => 'Tops', 'price' => 90.00, 'desc' => 'Comfy t-shirt'],
                    ['code' => 'TOP-007', 'category' => 'Tops', 'price' => 200.00, 'desc' => 'Silk top'],
                    ['code' => 'BOT-003', 'category' => 'Bottoms', 'price' => 220.00, 'desc' => 'Blue denim'],
                    ['code' => 'BOT-004', 'category' => 'Bottoms', 'price' => 180.00, 'desc' => 'Pencil skirt'],
                    ['code' => 'BOT-005', 'category' => 'Bottoms', 'price' => 120.00, 'desc' => 'Cargo shorts'],
                    ['code' => 'DRS-003', 'category' => 'Dresses', 'price' => 400.00, 'desc' => 'Evening gown'],
                    ['code' => 'DRS-004', 'category' => 'Dresses', 'price' => 320.00, 'desc' => 'Casual sundress'],
                    ['code' => 'OUT-002', 'category' => 'Outerwear', 'price' => 500.00, 'desc' => 'Leather jacket'],
                    ['code' => 'OUT-003', 'category' => 'Outerwear', 'price' => 250.00, 'desc' => 'Cardigan'],
                    ['code' => 'ACC-002', 'category' => 'Accessories', 'price' => 150.00, 'desc' => 'Designer bag'],
                    ['code' => 'ACC-003', 'category' => 'Accessories', 'price' => 60.00, 'desc' => 'Scarf'],
                    ['code' => 'FOOT-001', 'category' => 'Footwear', 'price' => 350.00, 'desc' => 'Heels'],
                    ['code' => 'FOOT-002', 'category' => 'Footwear', 'price' => 280.00, 'desc' => 'Sneakers'],
                ]
            ],
            [
                'bale_number' => 'BALE-2026-003',
                'supplier' => $suppliers[2]->name,
                'purchase_price' => 1800.00,
                'total_items' => 18,
                'purchase_date' => Carbon::now()->subDays(1),
                'items' => [
                    ['code' => 'TOP-008', 'category' => 'Tops', 'price' => 110.00, 'desc' => 'Striped shirt'],
                    ['code' => 'TOP-009', 'category' => 'Tops', 'price' => 140.00, 'desc' => 'V-neck sweater'],
                    ['code' => 'TOP-010', 'category' => 'Tops', 'price' => 95.00, 'desc' => 'Basic tee'],
                    ['code' => 'BOT-006', 'category' => 'Bottoms', 'price' => 190.00, 'desc' => 'Slacks'],
                    ['code' => 'BOT-007', 'category' => 'Bottoms', 'price' => 140.00, 'desc' => 'Mini skirt'],
                    ['code' => 'BOT-008', 'category' => 'Bottoms', 'price' => 160.00, 'desc' => 'Linen pants'],
                    ['code' => 'DRS-005', 'category' => 'Dresses', 'price' => 380.00, 'desc' => 'Cocktail dress'],
                    ['code' => 'DRS-006', 'category' => 'Dresses', 'price' => 250.00, 'desc' => 'Maxi dress'],
                    ['code' => 'OUT-004', 'category' => 'Outerwear', 'price' => 350.00, 'desc' => 'Blazer'],
                    ['code' => 'OUT-005', 'category' => 'Outerwear', 'price' => 200.00, 'desc' => 'Windbreaker'],
                    ['code' => 'ACC-004', 'category' => 'Accessories', 'price' => 200.00, 'desc' => 'Watch'],
                    ['code' => 'ACC-005', 'category' => 'Accessories', 'price' => 75.00, 'desc' => 'Sun hat'],
                    ['code' => 'ACC-006', 'category' => 'Accessories', 'price' => 120.00, 'desc' => 'Wallet'],
                    ['code' => 'FOOT-003', 'category' => 'Footwear', 'price' => 320.00, 'desc' => 'Loafers'],
                    ['code' => 'FOOT-004', 'category' => 'Footwear', 'price' => 250.00, 'desc' => 'Sandals'],
                ]
            ],
        ];

        $bales = [];
        foreach ($balesData as $baleData) {
            $supplier = $suppliers->firstWhere('name', $baleData['supplier']);
            $bale = Bale::create([
                'bale_number' => $baleData['bale_number'],
                'supplier_id' => $supplier->id,
                'purchase_price' => $baleData['purchase_price'],
                'total_items' => $baleData['total_items'],
                'purchase_date' => $baleData['purchase_date'],
            ]);

            foreach ($baleData['items'] as $itemData) {
                $category = $categories->firstWhere('name', $itemData['category']);
                Item::create([
                    'bale_id' => $bale->id,
                    'category_id' => $category->id,
                    'status_id' => $availableStatus->id,
                    'item_code' => $itemData['code'],
                    'description' => $itemData['desc'],
                    'price' => $itemData['price'],
                    'quantity' => 1,
                    'is_sold' => false,
                ]);
            }
            $bales[] = $bale;
        }

        $allItems = Item::all();

        $todayTransactions = [
            [
                'items' => ['TOP-001', 'TOP-002', 'BOT-001'],
                'method_id' => 1,
                'cashier' => 1,
            ],
            [
                'items' => ['DRS-001', 'ACC-001'],
                'method_id' => 2,
                'cashier' => 2,
            ],
            [
                'items' => ['TOP-005', 'BOT-003', 'FOOT-001'],
                'method_id' => 1,
                'cashier' => 3,
            ],
        ];

        foreach ($todayTransactions as $txnData) {
            $user = $users->firstWhere('employee_id', $txnData['cashier']);
            $items = $allItems->whereIn('item_code', $txnData['items']);

            $total = 0;
            $txnItems = [];
            foreach ($items as $item) {
                $total += $item->price;
                $txnItems[] = [
                    'item_id' => $item->id,
                    'quantity' => 1,
                    'unit_price' => $item->price,
                    'subtotal' => $item->price,
                ];
                $item->update(['is_sold' => true]);
            }

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'transaction_number' => Transaction::generateTransactionNumber(),
                'subtotal' => $total,
                'total_amount' => $total,
                'method_id' => $txnData['method_id'],
            ]);

            foreach ($txnItems as $ti) {
                $transaction->items()->attach($ti['item_id'], [
                    'quantity' => $ti['quantity'],
                    'unit_price' => $ti['unit_price'],
                    'subtotal' => $ti['subtotal'],
                ]);
            }
        }

        $yesterdayTransactions = [
            [
                'items' => ['TOP-003', 'BOT-002'],
                'method_id' => 1,
                'cashier' => 1,
            ],
            [
                'items' => ['DRS-002', 'OUT-001'],
                'method_id' => 2,
                'cashier' => 3,
            ],
        ];

        foreach ($yesterdayTransactions as $txnData) {
            $user = $users->firstWhere('employee_id', $txnData['cashier']);
            $items = $allItems->whereIn('item_code', $txnData['items']);

            $total = 0;
            $txnItems = [];
            foreach ($items as $item) {
                $total += $item->price;
                $txnItems[] = [
                    'item_id' => $item->id,
                    'quantity' => 1,
                    'unit_price' => $item->price,
                    'subtotal' => $item->price,
                ];
                $item->update(['is_sold' => true]);
            }

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'transaction_number' => Transaction::generateTransactionNumber(),
                'subtotal' => $total,
                'total_amount' => $total,
                'method_id' => $txnData['method_id'],
                'created_at' => Carbon::now()->subDay(),
            ]);

            foreach ($txnItems as $ti) {
                $transaction->items()->attach($ti['item_id'], [
                    'quantity' => $ti['quantity'],
                    'unit_price' => $ti['unit_price'],
                    'subtotal' => $ti['subtotal'],
                ]);
            }
        }

        $this->command->info('sample data seeded successfully!');
    }
}