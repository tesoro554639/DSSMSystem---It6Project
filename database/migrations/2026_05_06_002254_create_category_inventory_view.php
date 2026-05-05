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
        DB::statement("DROP VIEW IF EXISTS category_inventory_view");
        DB::statement("
            CREATE VIEW category_inventory_view AS
            SELECT 
                c.id as category_id,
                c.name as category_name,
                COUNT(i.id) as total_items,
                SUM(CASE WHEN i.is_sold = 0 THEN 1 ELSE 0 END) as available,
                SUM(CASE WHEN i.is_sold = 1 THEN 1 ELSE 0 END) as sold,
                SUM(CASE WHEN i.is_sold = 0 THEN i.price ELSE 0 END) as potential_revenue
            FROM categories c
            LEFT JOIN items i ON c.id = i.category_id
            GROUP BY c.id, c.name
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS category_inventory_view");
    }
};
