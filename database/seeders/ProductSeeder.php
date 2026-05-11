<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sleeveLaptopId  = DB::table('categories')->where('slug', 'sleeve-laptop')->value('id');
        $sleeveTabletId  = DB::table('categories')->where('slug', 'sleeve-tablet')->value('id');
        $pouchId         = DB::table('categories')->where('slug', 'pouch-clutch')->value('id');
        $customId        = DB::table('categories')->where('slug', 'custom-bag')->value('id');

        $products = [
            // ─── Sleeve Laptop ────────────────────────────────────────────────
            [
                'category_id'  => $sleeveLaptopId,
                'name'         => 'OTHERSIDE - Confy Sleeve Basic',
                'slug'         => 'otherside-confy-sleeve-basic',
                'description'  => 'Sleeve laptop basic dengan bahan premium waterproof. Cocok untuk laptop 13-14 inch. Desain minimalis dengan padding tebal untuk perlindungan maksimal. Tersedia dalam berbagai ukuran.',
                'price'        => 65000,
                'stock'        => 120,
                'sku'          => 'OS-CSB-001',
                'is_available' => true,
                'is_best'      => true,
            ],
            [
                'category_id'  => $sleeveLaptopId,
                'name'         => 'OTHERSIDE - PREMIUM Sniugh Sleeve Waterproof',
                'slug'         => 'otherside-premium-sniugh-sleeve-waterproof',
                'description'  => 'Sleeve laptop premium dengan teknologi waterproof tingkat tinggi. Bahan luar tahan air, padding dalam tebal melindungi laptop dari benturan. Cocok untuk 13-15.6 inch. Dilengkapi handle dan aksesoris slot.',
                'price'        => 79000,
                'stock'        => 85,
                'sku'          => 'OS-PSW-001',
                'is_available' => true,
                'is_best'      => true,
            ],
            [
                'category_id'  => $sleeveLaptopId,
                'name'         => 'OTHERSIDE - Sleeve Case Confy Waterproof',
                'slug'         => 'otherside-sleeve-case-confy-waterproof',
                'description'  => 'Sleeve case laptop dengan material waterproof premium. Desain slim namun tetap memberikan perlindungan optimal. Tersedia ukuran 13, 14, dan 15.6 inch.',
                'price'        => 75000,
                'stock'        => 95,
                'sku'          => 'OS-SCC-001',
                'is_available' => true,
                'is_best'      => false,
            ],
            [
                'category_id'  => $sleeveLaptopId,
                'name'         => 'OTHERSIDE - Confy Sleeve Basic Premium',
                'slug'         => 'otherside-confy-sleeve-basic-premium',
                'description'  => 'Versi premium dari Confy Sleeve Basic. Material lebih tebal, jahitan lebih rapi, dan padding lebih padat. Ideal untuk laptop 14-16 inch. Tersedia warna hitam dan abu.',
                'price'        => 73000,
                'stock'        => 70,
                'sku'          => 'OS-CSBP-001',
                'is_available' => true,
                'is_best'      => false,
            ],

            // ─── Sleeve Tablet ────────────────────────────────────────────────
            [
                'category_id'  => $sleeveTabletId,
                'name'         => 'OTHERSIDE - VELVET Sleeve Tablet',
                'slug'         => 'otherside-velvet-sleeve-tablet',
                'description'  => 'Sleeve tablet dengan material velvet premium yang lembut dan elegan. Melindungi tablet dari goresan dan debu. Cocok untuk iPad 10-11 inch dan tablet sejenis.',
                'price'        => 48000,
                'stock'        => 60,
                'sku'          => 'OS-VST-001',
                'is_available' => true,
                'is_best'      => false,
            ],

            // ─── Pouch & Clutch ───────────────────────────────────────────────
            [
                'category_id'  => $pouchId,
                'name'         => 'OTHERSIDE - MADE Mini Pouch Pria',
                'slug'         => 'otherside-made-mini-pouch-pria',
                'description'  => 'Mini pouch pria dengan desain maskulin dan simpel. Bahan premium waterproof, cukup untuk menyimpan charger, kabel, earphone, dan aksesoris kecil lainnya. Cocok dibawa sehari-hari.',
                'price'        => 46000,
                'stock'        => 80,
                'sku'          => 'OS-MMP-001',
                'is_available' => true,
                'is_best'      => true,
            ],

            // ─── Custom Bag ───────────────────────────────────────────────────
            [
                'category_id'  => $customId,
                'name'         => 'OTHERSIDE - Custom Sleeve Laptop',
                'slug'         => 'otherside-custom-sleeve-laptop',
                'description'  => 'Sleeve laptop custom sesuai desain dan kebutuhanmu. Bisa custom ukuran, warna, logo, dan bordir nama. Minimum order 10 pcs. Hubungi kami untuk estimasi harga dan waktu pengerjaan.',
                'price'        => 85000,
                'stock'        => 999,
                'sku'          => 'OS-CSL-CUSTOM',
                'is_available' => true,
                'is_best'      => false,
            ],
            [
                'category_id'  => $customId,
                'name'         => 'OTHERSIDE - Custom Pouch / Clutch',
                'slug'         => 'otherside-custom-pouch-clutch',
                'description'  => 'Pouch atau clutch custom untuk kebutuhan event, komunitas, atau corporate gift. Bisa custom ukuran, warna, logo sablon atau bordir. Minimum order 20 pcs.',
                'price'        => 55000,
                'stock'        => 999,
                'sku'          => 'OS-CPC-CUSTOM',
                'is_available' => true,
                'is_best'      => false,
            ],
        ];

        foreach ($products as $product) {
            $exists = DB::table('products')->where('slug', $product['slug'])->exists();
            if (!$exists) {
                DB::table('products')->insert(array_merge($product, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
