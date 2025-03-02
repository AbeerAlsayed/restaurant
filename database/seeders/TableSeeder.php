<?php

namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Table;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء 10 طاولات بشكل عشوائي
        for ($i = 1; $i <= 10; $i++) {
            Table::create([
                'table_number' => $i,
                'status' => 'available', // جميع الطاولات متاحة في البداية
            ]);
        }
    }
}
