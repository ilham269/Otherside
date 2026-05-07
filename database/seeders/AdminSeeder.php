<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            ['name' => 'Super Admin',    'email' => 'admin@otherside.com',   'role' => 'admin'],
            ['name' => 'Editor Admin',   'email' => 'editor@otherside.com',  'role' => 'editor'],
        ];

        foreach ($admins as $data) {
            Admin::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['password' => Hash::make('password')])
            );
        }
    }
}
