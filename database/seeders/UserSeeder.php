<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Master Admin',
            'email' => 'admin@kopikala.com',
            'password' => Hash::make('admin123'),
            'role' => 'master_admin'
        ]);

        User::create([
            'name' => 'HRD',
            'email' => 'hrd@kopikala.com',
            'password' => Hash::make('hrd123'),
            'role' => 'hrd'
        ]);
    }
}
