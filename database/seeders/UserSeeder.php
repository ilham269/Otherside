<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Budi Santoso',   'email' => 'budi@gmail.com'],
            ['name' => 'Siti Rahayu',    'email' => 'siti@gmail.com'],
            ['name' => 'Andi Wijaya',    'email' => 'andi@gmail.com'],
            ['name' => 'Dewi Lestari',   'email' => 'dewi@gmail.com'],
            ['name' => 'Rizky Pratama',  'email' => 'rizky@gmail.com'],
        ];

        foreach ($users as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password'          => Hash::make('password'),
                    'email_verified_at' => now(),
                ])
            );
        }
    }
}
