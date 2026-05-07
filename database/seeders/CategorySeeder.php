<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $parents = [
            ['name' => 'Kaos',      'slug' => 'kaos',      'description' => 'Produk kaos custom'],
            ['name' => 'Hoodie',    'slug' => 'hoodie',    'description' => 'Produk hoodie custom'],
            ['name' => 'Tote Bag',  'slug' => 'tote-bag',  'description' => 'Tote bag custom'],
            ['name' => 'Aksesoris', 'slug' => 'aksesoris', 'description' => 'Aksesoris custom'],
        ];

        foreach ($parents as $cat) {
            DB::table('categories')->insertOrIgnore(array_merge($cat, ['is_active' => true]));
        }

        // Sub-categories
        $kaosId   = DB::table('categories')->where('slug', 'kaos')->value('id');
        $hoodieId = DB::table('categories')->where('slug', 'hoodie')->value('id');

        $subs = [
            ['name' => 'Kaos Polos',    'slug' => 'kaos-polos',    'parent_id' => $kaosId],
            ['name' => 'Kaos Sablon',   'slug' => 'kaos-sablon',   'parent_id' => $kaosId],
            ['name' => 'Hoodie Zipper', 'slug' => 'hoodie-zipper', 'parent_id' => $hoodieId],
            ['name' => 'Hoodie Pullover','slug' => 'hoodie-pullover','parent_id' => $hoodieId],
        ];

        foreach ($subs as $sub) {
            DB::table('categories')->insertOrIgnore(array_merge($sub, [
                'description' => null,
                'is_active'   => true,
            ]));
        }
    }
}
