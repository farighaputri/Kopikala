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
        // Nonaktifkan foreign key checks sementara untuk mengosongkan tabel pivot secara aman
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_permission')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Sinkronisasi MASTER ADMIN (Mendapatkan semua Permission ID 1 s/d 21)
        // Kolom 'description' dihapus karena tidak ada di tabel database Anda
        $masterAdmin = Role::updateOrCreate(
            ['name' => 'Master Admin'],
            [
                'status' => true,
                'access' => json_encode(['WHOLE ACCESS']) // Sesuai kolom json tabel Anda
            ]
        );

        if ($masterAdmin) {
            $allPermissionIds = Permission::pluck('id')->toArray();
            $masterAdmin->permissions()->sync($allPermissionIds);
        }

        // 2. Sinkronisasi STAFF / KASIR SEMERU
        $aksesSemeru = ['Semeru Branch', 'Semeru Dashboard', 'Semeru Transaction', 'Semeru Staff', 'Semeru Stock', 'Stock'];
        $staffSemeru = Role::updateOrCreate(
            ['name' => 'Staff Semeru'],
            [
                'status' => true,
                'access' => json_encode($aksesSemeru)
            ]
        );

        if ($staffSemeru) {
            $semeruIds = Permission::whereIn('name', $aksesSemeru)->pluck('id')->toArray();
            $staffSemeru->permissions()->sync($semeruIds);
        }

        // 3. Sinkronisasi STAFF / KASIR DJUANDA
        $aksesDjuanda = ['Djuanda Branch', 'Djuanda Dashboard', 'Djuanda Transaction', 'Djuanda Staff', 'Djuanda Stock', 'Stock'];
        $staffDjuanda = Role::updateOrCreate(
            ['name' => 'Staff Djuanda'],
            [
                'status' => true,
                'access' => json_encode($aksesDjuanda)
            ]
        );

        if ($staffDjuanda) {
            $djuandaIds = Permission::whereIn('name', $aksesDjuanda)->pluck('id')->toArray();
            $staffDjuanda->permissions()->sync($djuandaIds);
        }

        $this->command->info('Relasi Role dan Permission Berhasil Disinkronkan ke Database!');
    }
}