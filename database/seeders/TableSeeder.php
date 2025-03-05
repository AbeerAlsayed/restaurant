<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    public function run()
    {
        // إنشاء 10 طاولات لكل طابق (طابق 1 وطابق 2)
        for ($floor = 1; $floor <= 2; $floor++) {
            for ($i = 1; $i <= 10; $i++) {
                // تحديد السعة العشوائية للطاولة بين 2 و 6
                $capacity = rand(2, 6);

                // تحديد عدد الضيوف بشكل عشوائي من 0 حتى السعة
                $guests_count = rand(0, $capacity);

                Table::create([
                    'table_number' => ($floor * 100) + $i, // مثال: 101, 102, ..., 201, 202, ...
                    'floor' => $floor,
                    'status' => 'available', // الطاولة متاحة في البداية
                    'reserved_by' => null, // لم يتم حجزها
                    'guests_count' => $guests_count, // عدد الضيوف العشوائي
                    'capacity' => $capacity, // السعة العشوائية للطاولة
                ]);
            }
        }
    }
}
