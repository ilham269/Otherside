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
                'product_id'      => 1,
                'track_id_pos'    => 'POS-2026-001',
                'track_id_store'  => 'STR-2026-001',
                'customer_email'  => 'budi@gmail.com',
                'qty'             => '50',
                'subject'         => 'Custom kaos komunitas motor',
                'notes'           => 'Logo di dada kiri, nama di punggung, warna hitam semua',
                'reference_file'  => 'references/ref-001.pdf',
                'estimated_price' => 4250000,
                'type'            => 'bulk',
                'status'          => 'completed',
                'fulfilled_by'    => $adminId,
            ],
            [
                'user_id'         => $users[1],
                'product_id'      => null,
                'track_id_pos'    => null,
                'track_id_store'  => 'STR-2026-002',
                'customer_email'  => 'siti@gmail.com',
                'qty'             => '1',
                'subject'         => 'Hoodie custom anniversary',
                'notes'           => 'Bordir nama pasangan di lengan kanan, warna navy',
                'reference_file'  => null,
                'estimated_price' => 320000,
                'type'            => 'personal',
                'status'          => 'processing',
                'fulfilled_by'    => null,
            ],
            [
                'user_id'         => $users[2],
                'product_id'      => 6,
                'track_id_pos'    => 'POS-2026-003',
                'track_id_store'  => 'STR-2026-003',
                'customer_email'  => 'andi@gmail.com',
                'qty'             => '20',
                'subject'         => 'Tote bag event kampus',
                'notes'           => 'Sablon logo kampus, ukuran A4, warna putih',
                'reference_file'  => 'references/ref-003.png',
                'estimated_price' => 1500000,
                'type'            => 'event',
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
