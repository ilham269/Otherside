<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            CustomOrderSeeder::class,
            PostSeeder::class,
            MessageSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
