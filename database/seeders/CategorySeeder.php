<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Tanaman Hias Daun'],
            ['name' => 'Tanaman Hias Bunga'],
            ['name' => 'Kaktus & Sukulen'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
