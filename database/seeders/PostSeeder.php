<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = DB::table('admins')->value('id');

        $posts = [
            [
                'title'            => 'Tips Memilih Bahan Kaos yang Tepat',
                'slug'             => 'tips-memilih-bahan-kaos',
                'thumbnail'        => 'posts/tips-kaos.jpg',
                'body'             => '<p>Memilih bahan kaos yang tepat sangat penting untuk kenyamanan dan ketahanan produk. Cotton combed 30s adalah pilihan terbaik untuk kaos harian karena lembut dan menyerap keringat dengan baik.</p><p>Untuk kaos sablon, pastikan bahan tidak terlalu tipis agar sablon tidak tembus ke dalam. Bahan 24s atau 30s sangat direkomendasikan.</p>',
                'tags'             => 'kaos,bahan,tips,fashion',
                'meta_title'       => 'Tips Memilih Bahan Kaos yang Tepat | Otherside Store',
                'meta_description' => 'Panduan lengkap memilih bahan kaos yang tepat untuk kebutuhan sehari-hari maupun custom order.',
                'status'           => 'published',
                'published_at'     => now()->subDays(10),
            ],
            [
                'title'            => 'Perbedaan Sablon DTF dan Screen Printing',
                'slug'             => 'perbedaan-sablon-dtf-screen-printing',
                'thumbnail'        => 'posts/sablon-dtf.jpg',
                'body'             => '<p>DTF (Direct to Film) dan Screen Printing adalah dua teknik sablon yang paling populer. DTF cocok untuk desain detail dan warna banyak dengan minimum order rendah. Screen Printing lebih ekonomis untuk order massal dengan desain sederhana.</p>',
                'tags'             => 'sablon,dtf,screen printing,custom',
                'meta_title'       => 'DTF vs Screen Printing | Otherside Store',
                'meta_description' => 'Perbandingan teknik sablon DTF dan Screen Printing, mana yang cocok untuk kebutuhanmu?',
                'status'           => 'published',
                'published_at'     => now()->subDays(5),
            ],
            [
                'title'            => 'Cara Order Custom di Otherside Store',
                'slug'             => 'cara-order-custom-otherside',
                'thumbnail'        => 'posts/cara-order.jpg',
                'body'             => '<p>Memesan produk custom di Otherside Store sangat mudah. Cukup pilih produk, upload desain, dan isi form custom order. Tim kami akan menghubungi kamu dalam 1x24 jam untuk konfirmasi estimasi harga dan waktu pengerjaan.</p>',
                'tags'             => 'custom order,panduan,cara order',
                'meta_title'       => 'Cara Order Custom | Otherside Store',
                'meta_description' => 'Panduan lengkap cara memesan produk custom di Otherside Store.',
                'status'           => 'draft',
                'published_at'     => null,
            ],
        ];

        foreach ($posts as $post) {
            DB::table('posts')->insertOrIgnore(array_merge($post, [
                'admin_id'   => $adminId,
                'created_at' => now()->subDays(rand(1, 15)),
                'updated_at' => now(),
            ]));
        }
    }
}
