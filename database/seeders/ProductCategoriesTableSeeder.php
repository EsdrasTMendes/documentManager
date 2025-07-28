<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Notebook',
            'Periferico',
            'Acessorios',
        ];

        foreach ($categories as $category) {
            ProductCategory::create(['name'=> $category]);
        }
    }
}
