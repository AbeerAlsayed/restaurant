<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {


        $categories = ['Desserts', 'Drinks', 'Main Course', 'Appetizers','Salads'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
