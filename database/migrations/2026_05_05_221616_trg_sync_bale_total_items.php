<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // TRIGGER : update bale's total_item when adding items
        DB::unprepared('DROP TRIGGER IF EXISTS after_item_insert_sync_bale');
        DB::unprepared("
            CREATE TRIGGER after_item_insert_sync_bale
            AFTER INSERT ON items
            FOR EACH ROW
            BEGIN
                -- increment the total_items in the bales table
                UPDATE bales 
                SET total_items = (SELECT COALESCE(SUM(quantity), 0) FROM items WHERE bale_id = NEW.bale_id)
                WHERE id = NEW.bale_id;
            END
        ");
        
        // TODO: TRIGGER : update bale's total_item when removing items
        DB::unprepared('DROP TRIGGER IF EXISTS after_item_remove_sync_bale');
        DB::unprepared("
            CREATE TRIGGER after_item_remove_sync_bale
            AFTER DELETE ON items
            FOR EACH ROW
            BEGIN
                -- decrement bale total items
                UPDATE bales
                SET total_items = (SELECT COALESCE(SUM(quantity), 0) FROM items WHERE bale_id = OLD.bale_id)
                WHERE id = OLD.bale_id;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_item_insert_sync_bale');
        DB::unprepared('DROP TRIGGER IF EXISTS after_item_remove_sync_bale');
    }
};
