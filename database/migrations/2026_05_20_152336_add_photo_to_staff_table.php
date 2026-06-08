<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('staff', function (Blueprint $table) {
        // Menambahkan kolom photo (string/varchar) setelah kolom status agar rapi
        $table->string('photo')->nullable()->after('status');
    });
}

public function down()
{
    Schema::table('staff', function (Blueprint $table) {
        // Menghapus kolom jika ingin rollback
        $table->dropColumn('photo');
    });
}
};
