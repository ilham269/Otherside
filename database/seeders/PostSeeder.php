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
                'title'            => 'Kenapa Sleeve Laptop Waterproof Itu Penting?',
                'slug'             => 'kenapa-sleeve-laptop-waterproof-penting',
                'body'             => '<p>Laptop adalah investasi mahal yang perlu dijaga. Salah satu ancaman terbesar adalah air — baik dari hujan, minuman tumpah, atau kelembaban. Sleeve laptop waterproof hadir sebagai solusi perlindungan pertama sebelum tas utama.</p><p>Material waterproof pada sleeve Otherside menggunakan lapisan khusus yang menolak air masuk, sementara padding tebal di dalamnya meredam benturan. Kombinasi ini memberikan perlindungan ganda untuk laptopmu.</p><p>Investasi Rp 65.000 - 79.000 untuk sleeve berkualitas jauh lebih murah dibanding biaya servis laptop yang rusak karena air.</p>',
                'tags'             => 'tips,laptop,waterproof,sleeve',
                'meta_title'       => 'Kenapa Sleeve Laptop Waterproof Penting | Otherside',
                'meta_description' => 'Pelajari mengapa sleeve laptop waterproof adalah aksesori wajib untuk melindungi laptopmu.',
                'status'           => 'published',
                'published_at'     => now()->subDays(7),
            ],
            [
                'title'            => 'Panduan Memilih Ukuran Sleeve Laptop yang Tepat',
                'slug'             => 'panduan-memilih-ukuran-sleeve-laptop',
                'body'             => '<p>Memilih ukuran sleeve laptop yang tepat sangat penting agar laptop tidak goyang di dalam dan terlindungi dengan baik. Berikut panduan ukurannya:</p><ul><li><strong>13 inch</strong>: MacBook Air M1/M2, MacBook Pro 13"</li><li><strong>14 inch</strong>: Lenovo ThinkPad, HP Pavilion 14, ASUS VivoBook 14</li><li><strong>15.6 inch</strong>: Laptop gaming, Dell Inspiron 15, Acer Aspire 5</li></ul><p>Semua produk sleeve Otherside tersedia dalam ketiga ukuran tersebut. Jika ragu, pilih ukuran yang lebih besar agar laptop tetap bisa masuk dengan nyaman.</p>',
                'tags'             => 'panduan,ukuran,sleeve,laptop',
                'meta_title'       => 'Panduan Ukuran Sleeve Laptop | Otherside',
                'meta_description' => 'Cara memilih ukuran sleeve laptop yang tepat untuk berbagai merek dan tipe laptop.',
                'status'           => 'published',
                'published_at'     => now()->subDays(3),
            ],
            [
                'title'            => 'Custom Tas untuk Event dan Komunitas — Solusi Corporate Gift Terbaik',
                'slug'             => 'custom-tas-event-komunitas-corporate-gift',
                'body'             => '<p>Mencari souvenir atau corporate gift yang fungsional dan berkesan? Custom tas dari Otherside bisa jadi pilihan tepat. Kami melayani custom sleeve laptop, pouch, dan clutch dengan logo atau desain sesuai kebutuhanmu.</p><p>Keunggulan custom order Otherside:</p><ul><li>Minimum order fleksibel mulai 10 pcs</li><li>Bisa custom ukuran, warna, dan material</li><li>Logo bisa sablon atau bordir</li><li>Pengerjaan 7-14 hari kerja</li><li>Harga kompetitif dengan kualitas premium</li></ul><p>Cocok untuk event perusahaan, seminar, wisuda, komunitas motor, dan lainnya. Hubungi kami sekarang untuk konsultasi gratis!</p>',
                'tags'             => 'custom,corporate gift,event,komunitas',
                'meta_title'       => 'Custom Tas untuk Event & Corporate Gift | Otherside',
                'meta_description' => 'Layanan custom tas sleeve laptop dan pouch untuk event, komunitas, dan corporate gift dengan harga terbaik.',
                'status'           => 'published',
                'published_at'     => now()->subDays(1),
            ],
        ];

        foreach ($posts as $post) {
            DB::table('posts')->insertOrIgnore(array_merge($post, [
                'admin_id'   => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
