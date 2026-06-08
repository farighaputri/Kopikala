<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kategori default ISCPE
        $defaultCategories = [
            ['name' => 'Ingredients', 'is_protected' => true],
            ['name' => 'Stationary',  'is_protected' => true],
            ['name' => 'Cleaning',    'is_protected' => true],
            ['name' => 'Packaging',   'is_protected' => true],
            ['name' => 'Essentials',  'is_protected' => true],
        ];

        foreach ($defaultCategories as $cat) {
            // firstOrCreate -> biar gak duplikat kalau dijalankan berkali-kali
            Category::firstOrCreate(
                ['name' => $cat['name']],
                ['is_protected' => $cat['is_protected']]
            );
        }

        // Contoh kategori tambahan (bisa dihapus atau diubah)
        $additionalCategories = [
            ['name' => 'Office Supplies', 'is_protected' => false],
            ['name' => 'Electronics',    'is_protected' => false],
        ];

        foreach ($additionalCategories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name']],
                ['is_protected' => $cat['is_protected']]
            );
        }
    }
}
