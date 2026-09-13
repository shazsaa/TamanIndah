<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin Taman Indah',
            'email'    => 'admin@tamanindah.test',
            'password' => bcrypt('password123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Customer',
            'email'    => 'user@tamanindah.test',
            'password' => bcrypt('password123'),
            'role'     => 'customer',
        ]);

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
