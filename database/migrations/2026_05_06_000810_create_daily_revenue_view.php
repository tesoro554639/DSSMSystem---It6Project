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
        DB::statement("DROP VIEW IF EXISTS daily_revenue_report");
        DB::statement("
            CREATE VIEW daily_revenue_report AS
            SELECT 
                CAST(created_at AS DATE) AS sales_date,
                COUNT(id) AS total_transactions,
                SUM(total_amount) AS daily_revenue
            FROM transactions
            GROUP BY CAST(created_at AS DATE)
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS daily_revenue_report");
    }
};
