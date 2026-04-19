<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bales', function (Blueprint $table) {
            $table->id();
            $table->string('bale_number')->unique();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->decimal('purchase_price', 12, 2);
            $table->integer('total_items');
            $table->date('purchase_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bales');
    }
};