<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_photos', function (Blueprint $table) {
            $table->id();

            // Relasi ke transaksi
            $table->foreignId('transaction_id')
                  ->constrained('transactions')
                  ->onDelete('cascade'); // kalau transaksi dihapus, foto ikut hilang

            // Path foto di storage/app/public
            $table->string('photo_path');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_photos');
    }
};
