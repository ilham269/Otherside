<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $users   = DB::table('users')->get()->keyBy('id')->toArray();
        $userIds = array_keys($users);
        $adminId = DB::table('admins')->value('id');
        $orders  = DB::table('orders')->pluck('id')->toArray();

        $messages = [
            [
                'user_id'         => $userIds[0],
                'order_id'        => $orders[0] ?? null,
                'custom_order_id' => null,
                'sender_name'     => 'Budi Santoso',
                'message'         => 'Halo, pesanan saya sudah dibayar, kapan bisa diproses?',
                'is_reply'        => false,
                'replied_by'      => null,
                'read_at'         => now()->subHours(2),
            ],
            [
                'user_id'         => $userIds[0],
                'order_id'        => $orders[0] ?? null,
                'custom_order_id' => null,
                'sender_name'     => 'Admin Otherside',
                'message'         => 'Halo Budi, pesanan kamu sudah kami terima dan sedang diproses. Estimasi selesai 3-5 hari kerja.',
                'is_reply'        => true,
                'replied_by'      => $adminId,
                'read_at'         => now()->subHour(),
            ],
            [
                'user_id'         => $userIds[1],
                'order_id'        => null,
                'custom_order_id' => 1,
                'sender_name'     => 'Siti Rahayu',
                'message'         => 'Untuk custom hoodie, apakah bisa request warna selain yang ada di katalog?',
                'is_reply'        => false,
                'replied_by'      => null,
                'read_at'         => null,
            ],
            [
                'user_id'         => $userIds[2],
                'order_id'        => $orders[2] ?? null,
                'custom_order_id' => null,
                'sender_name'     => 'Andi Wijaya',
                'message'         => 'Nomor resi pengiriman saya berapa ya?',
                'is_reply'        => false,
                'replied_by'      => null,
                'read_at'         => null,
            ],
        ];

        foreach ($messages as $msg) {
            DB::table('messages')->insertOrIgnore(array_merge($msg, [
                'url_pdf'    => null,
                'created_at' => now()->subHours(rand(1, 48)),
                'updated_at' => now(),
            ]));
        }
    }
}
