<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,card',
            'status' => 'nullable|string|in:pending,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // إذا كانت طريقة الدفع "card"، نقوم بإنشاء PaymentIntent مع Stripe
        if ($request->payment_method === 'card') {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            try {
                // إنشاء PaymentIntent
                $paymentIntent = PaymentIntent::create([
                    'amount' => $request->amount * 100, // المبلغ يجب أن يكون بالسنت
                    'currency' => 'usd', // العملة
                    'payment_method' => $request->payment_method_id, // معرف طريقة الدفع
                    'confirmation_method' => 'manual',
                    'confirm' => true,
                ]);

                // إذا نجحت العملية، نقوم بحفظ الدفعة في قاعدة البيانات
                $payment = Payment::create([
                    'order_id' => $request->order_id,
                    'amount' => $request->amount,
                    'payment_method' => $request->payment_method,
                    'status' => 'completed', // تم الدفع بنجاح
                    'stripe_payment_id' => $paymentIntent->id, // حفظ معرف الدفع من Stripe
                ]);

                return response()->json([
                    'message' => 'تم إنشاء الدفعة بنجاح',
                    'payment' => $payment,
                    'client_secret' => $paymentIntent->client_secret, // السر الخاص للعميل
                ], 201);

            } catch (\Exception $e) {
                // في حالة حدوث خطأ، يتم إرجاع رسالة الخطأ
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        // إذا كانت طريقة الدفع "cash"، نقوم بحفظ الدفعة بدون استخدام Stripe
        $payment = Payment::create([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json(['message' => 'تم إنشاء الدفعة بنجاح', 'payment' => $payment], 201);
    }

    /**
     * الحصول على جميع المدفوعات المرتبطة بطلب معين.
     *
     * @param  int  $orderId
     * @return \Illuminate\Http\Response
     */
    public function show($orderId)
    {
        // التحقق من وجود الطلب
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'الطلب غير موجود'], 404);
        }

        // جلب المدفوعات المرتبطة بالطلب
        $payments = $order->payments;

        return response()->json(['payments' => $payments], 200);
    }
}
