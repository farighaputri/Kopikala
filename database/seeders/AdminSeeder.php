<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        
        if (!User::where('email', 'admin@kopikala.com')->exists()) {
            User::create([
                'name' => 'Master Admin',
                'email' => 'admin@kopikala.com',
                'password' => Hash::make('password123'), 
                'role' => 'master_admin', 
            ]);
        }
    }
}
