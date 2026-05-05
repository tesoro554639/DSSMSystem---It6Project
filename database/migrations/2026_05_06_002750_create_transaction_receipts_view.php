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
        DB::statement("DROP VIEW IF EXISTS transaction_receipts_view");
        DB::statement("
            CREATE VIEW transaction_receipts_view AS
            SELECT 
                t.id AS transaction_id,
                t.transaction_number,
                t.created_at AS date_time,
                i.item_code,
                i.description AS item_description,
                ti.quantity AS qty_sold,
                ti.unit_price,
                ti.subtotal
            FROM transactions t
            JOIN transaction_items ti ON t.id = ti.transaction_id
            JOIN items i ON ti.item_id = i.id
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS transaction_receipts_view");
    }
};
