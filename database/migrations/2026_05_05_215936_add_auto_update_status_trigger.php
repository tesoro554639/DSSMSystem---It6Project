<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Logic for NEW Items
        // Ensures every unique item starts as 'Available' (is_sold = 0)
        DB::unprepared('DROP TRIGGER IF EXISTS before_items_insert_default_state');
        DB::unprepared("
            CREATE TRIGGER before_items_insert_default_state
            BEFORE INSERT ON items
            FOR EACH ROW
            BEGIN
                SET NEW.is_sold = 0;
                SET NEW.quantity = 1; -- Force quantity to 1 for unique items
            END
        ");

        // 2. Logic for UPDATED Items
        // Keeps the is_sold boolean and quantity in sync
        DB::unprepared('DROP TRIGGER IF EXISTS auto_update_inventory_state');
        DB::unprepared("
            CREATE TRIGGER auto_update_inventory_state
            BEFORE UPDATE ON items
            FOR EACH ROW
            BEGIN
                -- If item is marked as sold, force quantity to 0
                IF NEW.is_sold = 1 THEN
                    SET NEW.quantity = 0;
                
                -- If quantity is manually set to 0, ensure is_sold is true
                ELSEIF NEW.quantity <= 0 THEN
                    SET NEW.is_sold = 1;
                    SET NEW.quantity = 0;
                
                -- If an item is 'returned' or quantity becomes 1 again
                ELSEIF NEW.quantity > 0 THEN
                    SET NEW.is_sold = 0;
                END IF;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS before_items_insert_default_state');
        DB::unprepared('DROP TRIGGER IF EXISTS auto_update_inventory_state');
    }
};