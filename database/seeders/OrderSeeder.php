<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Table;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // الحصول على طاولة متاحة
        $table = Table::where('status', 'available')->first();

        // إنشاء طلب جديد
        $order = Order::create([
            'table_id' => $table->id, // ربط الطلب بالطاولة
            'order_number' => 'ORD' . time(), // رقم طلب فريد
            'subtotal' => 55.00,
            'service_charge' => 3.50,
            'total' => 58.50,
            'status' => 'pending',
        ]);

        // الحصول على المنتجات المراد إضافتها إلى الطلب
        $chickenWings = Product::where('name', 'Chicken Wings')->first();
        $summerSalad = Product::where('name', 'Summer Salad')->first();

        // إضافة المنتجات إلى الطلب مع الكمية والسعر
        if ($chickenWings) {
            $order->products()->attach($chickenWings->id, [
                'quantity' => 2, // كمية Chicken Wings
                'price' => $chickenWings->price,
            ]);
        }

        if ($summerSalad) {
            $order->products()->attach($summerSalad->id, [
                'quantity' => 1, // كمية Summer Salad
                'price' => $summerSalad->price,
            ]);
        }

        // تحديث حالة الطاولة إلى "مشغولة"
        $table->update(['status' => 'occupied']);
    }
}
