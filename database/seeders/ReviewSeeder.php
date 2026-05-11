<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $orders  = DB::table('orders')->where('status', 'completed')->get();
        $reviews = [
            ['rating' => 5, 'body' => 'Kualitasnya bagus banget, waterproof beneran! Laptop aman dari hujan. Recommended banget buat yang sering bawa laptop kemana-mana.'],
            ['rating' => 5, 'body' => 'Bahan tebal dan jahitannya rapi. Udah pakai 3 bulan masih bagus. Worth it banget harganya.'],
            ['rating' => 4, 'body' => 'Produknya sesuai ekspektasi, pengiriman cepat. Cuma warnanya sedikit beda dari foto, tapi overall oke.'],
            ['rating' => 5, 'body' => 'Mantap! Sudah order ke-3 kalinya. Kualitas konsisten dan seller responsif.'],
            ['rating' => 4, 'body' => 'Bagus, padding-nya tebal. Laptop 14 inch masuk pas. Sedikit susah masuknya tapi itu justru berarti fit banget.'],
        ];

        foreach ($orders as $i => $order) {
            if (!isset($reviews[$i])) break;

            $alreadyExists = DB::table('reviews')
                ->where('user_id', $order->user_id)
                ->where('order_id', $order->id)
                ->where('product_id', $order->product_id)
                ->exists();

            if (!$alreadyExists) {
                DB::table('reviews')->insert([
                    'user_id'    => $order->user_id,
                    'product_id' => $order->product_id,
                    'order_id'   => $order->id,
                    'rating'     => $reviews[$i]['rating'],
                    'body'       => $reviews[$i]['body'],
                    'is_visible' => true,
                    'created_at' => now()->subDays(rand(1, 15)),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
