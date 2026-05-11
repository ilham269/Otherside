<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Sleeve Laptop',  'slug' => 'sleeve-laptop',  'description' => 'Sleeve case laptop premium waterproof untuk berbagai ukuran laptop.'],
            ['name' => 'Sleeve Tablet',  'slug' => 'sleeve-tablet',  'description' => 'Sleeve case tablet dan iPad dengan bahan premium.'],
            ['name' => 'Pouch & Clutch', 'slug' => 'pouch-clutch',   'description' => 'Pouch dan clutch bag untuk pria dan wanita.'],
            ['name' => 'Custom Bag',     'slug' => 'custom-bag',     'description' => 'Tas custom sesuai desain dan kebutuhanmu.'],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->insertOrIgnore(array_merge($cat, ['is_active' => true]));
        }
    }
}
