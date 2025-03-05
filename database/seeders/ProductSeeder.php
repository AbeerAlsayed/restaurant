<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'Chocolate Cake', 'description' => 'Delicious dark chocolate cake.', 'price' => 15.50, 'category' => 'Desserts', 'image' => 'chocolate_cake.jpg'],
            ['name' => 'Turkish Coffee', 'description' => 'Freshly brewed Turkish coffee.', 'price' => 10.00, 'category' => 'Drinks', 'image' => 'turkish_coffee.jpg'],
            ['name' => 'Grilled Steak', 'description' => 'Grilled steak with vegetables.', 'price' => 50.00, 'category' => 'Main Course', 'image' => 'grilled_steak.jpg'],
            ['name' => 'Greek Salad', 'description' => 'Fresh salad with cucumbers, tomatoes, and feta cheese.', 'price' => 20.00, 'category' => 'Appetizers', 'image' => 'greek_salad.jpg'],
        ];

        foreach ($products as $product) {
            $category = Category::where('name', $product['category'])->first();
            if ($category) {
                Product::create([
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'category_id' => $category->id,
                    'image' => $product['image'],
                ]);
            }
        }
    }
}
