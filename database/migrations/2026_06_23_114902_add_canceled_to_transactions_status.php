<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Menulis ulang ENUM lama dengan menambahkan opsi 'Canceled' di akhir
            $table->enum('status', ['Waiting Confirmation', 'Order Confirmed', 'Order Ready', 'Order Finished', 'Canceled'])
                  ->default('Waiting Confirmation')
                  ->change();
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('status', ['Waiting Confirmation', 'Order Confirmed', 'Order Ready', 'Order Finished'])
                  ->default('Waiting Confirmation')
                  ->change();
        });
    }
};