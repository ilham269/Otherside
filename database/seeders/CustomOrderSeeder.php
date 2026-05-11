<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomOrderSeeder extends Seeder
{
    public function run(): void
    {
        $users   = DB::table('users')->pluck('id')->toArray();
        $adminId = DB::table('admins')->value('id');

        $customOrders = [
            [
                'user_id'         => $users[0],
                'product_id'      => DB::table('products')->where('slug', 'otherside-custom-sleeve-laptop')->value('id'),
                'track_id_store'  => 'STR-2026-C001',
                'customer_email'  => 'budi@gmail.com',
                'qty'             => '50',
                'subject'         => 'Custom sleeve laptop untuk seminar kampus',
                'notes'           => 'Logo kampus di bagian depan, ukuran 14 inch, warna hitam semua, bordir nama kampus di sudut kanan bawah',
                'reference_file'  => null,
                'estimated_price' => 4250000,
                'type'            => 'event',
                'status'          => 'completed',
                'fulfilled_by'    => $adminId,
            ],
            [
                'user_id'         => $users[1],
                'product_id'      => DB::table('products')->where('slug', 'otherside-custom-pouch-clutch')->value('id'),
                'track_id_store'  => 'STR-2026-C002',
                'customer_email'  => 'siti@gmail.com',
                'qty'             => '30',
                'subject'         => 'Pouch custom souvenir pernikahan',
                'notes'           => 'Sablon nama pengantin dan tanggal pernikahan, warna navy, ukuran medium',
                'reference_file'  => null,
                'estimated_price' => 1650000,
                'type'            => 'personal',
                'status'          => 'processing',
                'fulfilled_by'    => null,
            ],
            [
                'user_id'         => $users[2],
                'product_id'      => DB::table('products')->where('slug', 'otherside-custom-sleeve-laptop')->value('id'),
                'track_id_store'  => 'STR-2026-C003',
                'customer_email'  => 'andi@gmail.com',
                'qty'             => '100',
                'subject'         => 'Sleeve laptop corporate gift perusahaan',
                'notes'           => 'Logo perusahaan bordir di depan, ukuran 15.6 inch, warna hitam, ada slot kartu nama di dalam',
                'reference_file'  => null,
                'estimated_price' => 9500000,
                'type'            => 'bulk',
                'status'          => 'pending',
                'fulfilled_by'    => null,
            ],
        ];

        foreach ($customOrders as $order) {
            DB::table('custom_orders')->insertOrIgnore(array_merge($order, [
                'created_at' => now()->subDays(rand(1, 20)),
                'updated_at' => now(),
            ]));
        }
    }
}
