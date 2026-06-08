<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan relasi pivot lama agar bersih
        DB::table('role_permission')->truncate();

        // 1. Sinkronisasi MASTER ADMIN (Mendapatkan ID 1 s/d 21)
        $masterAdmin = Role::where('name', 'Master Admin')->first();
        if ($masterAdmin) {
            $allPermissionIds = Permission::pluck('id')->toArray();
            $masterAdmin->permissions()->sync($allPermissionIds);
            
            // Perbarui kolom 'access' JSON bawaan skema Anda
            $masterAdmin->update(['access' => json_encode(['WHOLE ACCESS'])]);
        }

        // 2. Sinkronisasi KASIR / STAFF SEMERU
        $staffSemeru = Role::where('name', 'Staff Semeru')->first();
        if ($staffSemeru) {
            $aksesSemeru = ['Semeru Branch', 'Semeru Dashboard', 'Semeru Transaction', 'Semeru Staff', 'Semeru Stock', 'Stock'];
            $semeruIds = Permission::whereIn('name', $aksesSemeru)->pluck('id')->toArray();
            $staffSemeru->permissions()->sync($semeruIds);
            $staffSemeru->update(['access' => json_encode($aksesSemeru)]);
        }

        // 3. Sinkronisasi KASIR / STAFF DJUANDA
        $staffDjuanda = Role::where('name', 'Staff Djuanda')->first();
        if ($staffDjuanda) {
            $aksesDjuanda = ['Djuanda Branch', 'Djuanda Dashboard', 'Djuanda Transaction', 'Djuanda Staff', 'Djuanda Stock', 'Stock'];
            $djuandaIds = Permission::whereIn('name', $aksesDjuanda)->pluck('id')->toArray();
            $staffDjuanda->permissions()->sync($djuandaIds);
            $staffDjuanda->update(['access' => json_encode($aksesDjuanda)]);
        }

        $this->command->info('Relasi Role dan Permission Berhasil Sinkron!');
    }
}