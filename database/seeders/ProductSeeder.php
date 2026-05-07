<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $kaosId    = DB::table('categories')->where('slug', 'kaos-polos')->value('id');
        $sablonId  = DB::table('categories')->where('slug', 'kaos-sablon')->value('id');
        $hoodieId  = DB::table('categories')->where('slug', 'hoodie-zipper')->value('id');
        $totebagId = DB::table('categories')->where('slug', 'tote-bag')->value('id');

        $products = [
            [
                'category_id'  => $kaosId,
                'name'         => 'Kaos Polos Premium',
                'slug'         => 'kaos-polos-premium',
                'description'  => 'Kaos polos bahan cotton combed 30s, nyaman dipakai sehari-hari.',
                'price'        => 85000,
                'stock'        => 150,
                'sku'          => 'KP-001',
                'is_available' => true,
                'is_best'      => true,
            ],
            [
                'category_id'  => $kaosId,
                'name'         => 'Kaos Polos Oversize',
                'slug'         => 'kaos-polos-oversize',
                'description'  => 'Kaos oversize bahan cotton 24s, fit untuk semua postur.',
                'price'        => 95000,
                'stock'        => 80,
                'sku'          => 'KP-002',
                'is_available' => true,
                'is_best'      => false,
            ],
            [
                'category_id'  => $sablonId,
                'name'         => 'Kaos Sablon DTF',
                'slug'         => 'kaos-sablon-dtf',
                'description'  => 'Kaos sablon teknik DTF, warna tajam dan tahan lama.',
                'price'        => 120000,
                'stock'        => 60,
                'sku'          => 'KS-001',
                'is_available' => true,
                'is_best'      => true,
            ],
            [
                'category_id'  => $sablonId,
                'name'         => 'Kaos Sablon Screen Printing',
                'slug'         => 'kaos-sablon-screen-printing',
                'description'  => 'Kaos sablon manual screen printing, cocok untuk order massal.',
                'price'        => 110000,
                'stock'        => 40,
                'sku'          => 'KS-002',
                'is_available' => true,
                'is_best'      => false,
            ],
            [
                'category_id'  => $hoodieId,
                'name'         => 'Hoodie Zipper Fleece',
                'slug'         => 'hoodie-zipper-fleece',
                'description'  => 'Hoodie zipper bahan fleece tebal, hangat dan stylish.',
                'price'        => 250000,
                'stock'        => 35,
                'sku'          => 'HZ-001',
                'is_available' => true,
                'is_best'      => true,
            ],
            [
                'category_id'  => $totebagId,
                'name'         => 'Tote Bag Canvas Custom',
                'slug'         => 'tote-bag-canvas-custom',
                'description'  => 'Tote bag canvas tebal, bisa custom sablon atau bordir.',
                'price'        => 75000,
                'stock'        => 100,
                'sku'          => 'TB-001',
                'is_available' => true,
                'is_best'      => false,
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insertOrIgnore(array_merge($product, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Product images
        $allProducts = DB::table('products')->get();
        foreach ($allProducts as $p) {
            $existing = DB::table('product_images')->where('product_id', $p->id)->exists();
            if (!$existing) {
                DB::table('product_images')->insert([
                    ['product_id' => $p->id, 'image_path' => 'products/' . $p->slug . '-1.jpg', 'is_primary' => true,  'is_active' => true],
                    ['product_id' => $p->id, 'image_path' => 'products/' . $p->slug . '-2.jpg', 'is_primary' => false, 'is_active' => true],
                ]);
            }
        }
    }
}
