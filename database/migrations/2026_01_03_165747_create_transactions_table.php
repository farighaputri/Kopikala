<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->string('customer_name');
            $table->string('email');
            $table->string('phone');
            $table->integer('quantity');
            $table->enum('status', [
                'Waiting Confirmation',
                'Order Confirmed',
                'Order Ready',
                'Order Finished'
            ])->default('Waiting Confirmation');
            $table->string('location')->nullable();
            $table->integer('total');
            $table->json('items');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
