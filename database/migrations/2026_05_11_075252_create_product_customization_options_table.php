<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_customization_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_customization_id')
                  ->constrained('product_customizations')
                  ->onDelete('cascade');
            $table->string('name');
            $table->decimal('additional_price', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_customization_options');
    }
};
