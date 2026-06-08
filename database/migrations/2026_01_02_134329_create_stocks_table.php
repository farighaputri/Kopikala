<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            
            // stock_id otomatis generate, tidak boleh null
            $table->string('stock_id')->unique();
            
            $table->string('item_name');
            
            // relasi category, nullable
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            
            $table->integer('qty_purchased');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->integer('in_stock');
            
            // enum status
            $table->enum('status', ['IN STOCK','LOW STOCK','OUT OF STOCK']);
            
            // relasi branch, wajib
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            
            // gambar optional
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
