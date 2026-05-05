<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop existing to avoid conflicts
        DB::unprepared('DROP TRIGGER IF EXISTS after_sale_deduct_inventory');

        DB::unprepared("
            CREATE TRIGGER after_sale_deduct_inventory
            AFTER INSERT ON transaction_items
            FOR EACH ROW
            BEGIN
                -- 1. Subtract the quantity sold from the items table
                UPDATE items 
                SET quantity = quantity - NEW.quantity
                WHERE id = NEW.item_id;

                -- 2. If quantity reaches 0, mark as sold
                -- This ensures the InventoryController filters it out correctly
                UPDATE items
                SET is_sold = 1
                WHERE id = NEW.item_id AND quantity <= 0;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_sale_deduct_inventory');
    }
};