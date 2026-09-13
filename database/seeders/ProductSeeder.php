<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $daun   = Category::where('name', 'Tanaman Hias Daun')->first()->id;
        $bunga  = Category::where('name', 'Tanaman Hias Bunga')->first()->id;
        $kaktus = Category::where('name', 'Kaktus & Sukulen')->first()->id;

        $products = [
            [
                'category_id' => $daun,
                'name'        => 'Monstera Deliciosa',
                'price'       => 150000,
                'stock'       => 12,
                'description' => 'Tanaman hias daun tropis populer dengan daun berlubang khas.',
                'is_active'   => true,
            ],
            [
                'category_id' => $daun,
                'name'        => 'Calathea Orbifolia',
                'price'       => 85000,
                'stock'       => 20,
                'description' => 'Daun bulat besar dengan corak garis-garis silver.',
                'is_active'   => true,
            ],
            [
                'category_id' => $daun,
                'name'        => 'Aglonema Red Valentine',
                'price'       => 75000,
                'stock'       => 15,
                'description' => 'Aglaonema dengan warna daun merah menyala.',
                'is_active'   => true,
            ],
            [
                'category_id' => $bunga,
                'name'        => 'Anggrek Bulan Putih',
                'price'       => 120000,
                'stock'       => 8,
                'description' => 'Anggrek Phalaenopsis putih elegan, cocok untuk hadiah.',
                'is_active'   => true,
            ],
            [
                'category_id' => $bunga,
                'name'        => 'Mawar Merah Pot',
                'price'       => 65000,
                'stock'       => 25,
                'description' => 'Mawar merah dalam pot kecil, mudah dirawat.',
                'is_active'   => true,
            ],
            [
                'category_id' => $bunga,
                'name'        => 'Bougenville Pink',
                'price'       => 55000,
                'stock'       => 18,
                'description' => 'Tanaman bougenville warna pink cerah.',
                'is_active'   => true,
            ],
            [
                'category_id' => $kaktus,
                'name'        => 'Kaktus Mammillaria',
                'price'       => 35000,
                'stock'       => 30,
                'description' => 'Kaktus mini bulat dengan duri halus, cocok untuk meja kerja.',
                'is_active'   => true,
            ],
            [
                'category_id' => $kaktus,
                'name'        => 'Echeveria Elegans',
                'price'       => 45000,
                'stock'       => 22,
                'description' => 'Sukulen rosette berwarna hijau kebiruan.',
                'is_active'   => true,
            ],
            [
                'category_id' => $kaktus,
                'name'        => 'Haworthia Fasciata',
                'price'       => 40000,
                'stock'       => 0,
                'description' => 'Sukulen zebra dengan garis putih horizontal. Stok habis.',
                'is_active'   => false,
            ],
            [
                'category_id' => $daun,
                'name'        => 'Philodendron Birkin',
                'price'       => 95000,
                'stock'       => 10,
                'description' => 'Philodendron dengan garis-garis putih pada daun hijau gelap.',
                'is_active'   => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
