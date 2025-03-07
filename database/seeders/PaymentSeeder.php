<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Order;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        // الحصول على طلب موجود (افتراضيًا أول طلب)
        $order = Order::first();

        if ($order) {
            // إنشاء مدفوعات مرتبطة بالطلب
            Payment::create([
                'order_id' => $order->id,
                'amount' => 38.50, // المبلغ المدفوع
                'payment_method' => 'cash', // طريقة الدفع (نقدي، بطاقة، إلخ)
                'status' => 'completed', // حالة الدفع
            ]);

            Payment::create([
                'order_id' => $order->id,
                'amount' => 7.00, // مبلغ إضافي
                'payment_method' => 'card', // طريقة الدفع
                'status' => 'pending', // حالة الدفع
            ]);
        } else {
            $this->command->info('No orders found. Please run OrderSeeder first.');
        }
    }
}
