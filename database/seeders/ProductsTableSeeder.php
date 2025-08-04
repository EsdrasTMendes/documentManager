<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'brand' => 'Dell',
            'model' => 'Inspiron 15',
            'serial_number' => 'SN12345678',
            'processor'=> 'Intel Core i7',
            'memory' => '16GB',
            'disk' => '512GB SSD',
            'price' => 4500.00,
            'price_string' => 'quatro mil e quinhentos reais',
            "category" => "Acessorios"
        ]);

        Product::create([
            'brand' => 'Logitech',
            'model' => 'Logitech Mx Master',
            'serial_number' => 'LG1254782',
            'price' => 559.00,
            'price_string' => 'quinhentos e cinquenta e nove reais',
            "category" => "Acessorios"
        ]);

        Product::create([
            'brand' => 'Logitech',
            'model' => 'Logitech Mk 235',
            'serial_number' => 'MK2351234',
            'price' => 132.00,
            'price_string' => 'cento e trinta e dois reais',
            "category" => "Acessorios"
        ]);
    }
}
