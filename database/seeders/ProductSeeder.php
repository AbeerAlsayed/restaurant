<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {


        // المنتجات التي سيتم إضافتها
        $products = [
            [
                'name' => 'Chicken Wings',
                'description' => 'Crispy chicken wings with hot sauce.',
                'price' => 20.00,
                'category' => 'Appetizers',
                'image' =>'a.jpg' ,
                'spiciness_level' => 2,
                'availability_status' => 'A',
                'gratuity' => false,
                'discount_percentage' => 0,
            ],
            [
                'name' => 'Summer Salad',
                'description' => 'Fresh summer salad with mixed greens.',
                'price' => 10.00,
                'category' => 'Salads',
                'image' =>'a.jpg' ,
                'spiciness_level' => 0,
                'availability_status' => 'A',
                'gratuity' => false,
                'discount_percentage' => 0,
            ],
            [
                'name' => 'Chocolate Cake',
                'description' => 'Delicious dark chocolate cake.',
                'price' => 15.50,
                'category' => 'Desserts',
                'image' =>'a.jpg' ,
                'spiciness_level' => 0,
                'availability_status' => 'N',
                'gratuity' => false,
                'discount_percentage' => 0,
            ],
            [
                'name' => 'Turkish Coffee',
                'description' => 'Freshly brewed Turkish coffee.',
                'price' => 10.00,
                'category' => 'Drinks',
                'image' =>'a.jpg' ,
                'spiciness_level' => 0,
                'availability_status' => 'A',
                'gratuity' => true,
                'discount_percentage' => 10,
            ],
            [
                'name' => 'Grilled Steak',
                'description' => 'Grilled steak with vegetables.',
                'price' => 50.00,
                'category' => 'Main Course',
                'image' =>'a.jpg' ,
                'spiciness_level' => 1,
                'availability_status' => 'A',
                'gratuity' => true,
                'discount_percentage' => 5,
            ],
        ];

        // إضافة المنتجات إلى قاعدة البيانات
        foreach ($products as $product) {
            $category = Category::where('name', $product['category'])->first();
            if ($category) {
                Product::create([
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'category_id' => $category->id,
                    'image' =>$product['image'] ,
                    'spiciness_level' => $product['spiciness_level'],
                    'availability_status' => $product['availability_status'],
                    'gratuity' => $product['gratuity'],
                    'discount_percentage' => $product['discount_percentage'],
                ]);
            }
        }
    }
}
