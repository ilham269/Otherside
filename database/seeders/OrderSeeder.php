<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users    = DB::table('users')->pluck('id')->toArray();
        $products = DB::table('products')->get()->keyBy('id');
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];

        $orders = [
            ['user_id' => $users[0], 'product_id' => 1, 'qty' => 2, 'status' => 'completed',  'payment_proof' => 'proofs/bukti-1.jpg'],
            ['user_id' => $users[1], 'product_id' => 3, 'qty' => 1, 'status' => 'processing', 'payment_proof' => 'proofs/bukti-2.jpg'],
            ['user_id' => $users[2], 'product_id' => 5, 'qty' => 1, 'status' => 'shipped',    'payment_proof' => 'proofs/bukti-3.jpg'],
            ['user_id' => $users[3], 'product_id' => 2, 'qty' => 3, 'status' => 'pending',    'payment_proof' => null],
            ['user_id' => $users[4], 'product_id' => 6, 'qty' => 2, 'status' => 'completed',  'payment_proof' => 'proofs/bukti-5.jpg'],
            ['user_id' => $users[0], 'product_id' => 4, 'qty' => 1, 'status' => 'cancelled',  'payment_proof' => null],
        ];

        $customerNames  = ['Budi Santoso', 'Siti Rahayu', 'Andi Wijaya', 'Dewi Lestari', 'Rizky Pratama', 'Budi Santoso'];
        $customerPhones = ['081234567890', '082345678901', '083456789012', '084567890123', '085678901234', '081234567890'];
        $customerEmails = ['budi@gmail.com', 'siti@gmail.com', 'andi@gmail.com', 'dewi@gmail.com', 'rizky@gmail.com', 'budi@gmail.com'];

        foreach ($orders as $i => $order) {
            $product     = $products[$order['product_id']] ?? null;
            $totalPrice  = $product ? $product->price * $order['qty'] : 0;

            DB::table('orders')->insertOrIgnore([
                'user_id'        => $order['user_id'],
                'product_id'     => $order['product_id'],
                'customer_name'  => $customerNames[$i],
                'customer_phone' => $customerPhones[$i],
                'customer_email' => $customerEmails[$i],
                'qty'            => $order['qty'],
                'total_price'    => $totalPrice,
                'status'         => $order['status'],
                'payment_proof'  => $order['payment_proof'],
                'fulfilled_by'   => $order['status'] === 'completed' ? true : false,
                'created_at'     => now()->subDays(rand(1, 30)),
                'updated_at'     => now(),
            ]);
        }
    }
}
