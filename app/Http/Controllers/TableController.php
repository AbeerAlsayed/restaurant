<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Resources\TableResource;
use App\Models\Table;
use App\Models\User;
use App\Notifications\TableFreedNotification;
use App\Notifications\TableReservedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class TableController extends Controller
{
    public function index()
    {
        return TableResource::collection(Table::all());
    }



    public function reserve(Request $request)
    {
        // التحقق من البيانات المدخلة
        $request->validate([
            'table_number' => 'required|integer|exists:tables,table_number',
        ]);

        return DB::transaction(function () use ($request) {
            // البحث عن الطاولة
            $table = Table::where('table_number', $request->table_number)->first();

            // التحقق من توفر الطاولة
            if ($table->status !== 'available') {
                return response()->json([
                    'message' => 'This table is already reserved or occupied.'
                ], 400);
            }

            // تحديث حالة الطاولة إلى "محجوزة"
            $table->update(['status' => 'reserved']);

            // إرسال إشعار إلى المدير
            $admin = User::first();
            if ($admin) {
                $admin->notify(new TableReservedNotification($table));
            }

            // إرجاع الاستجابة بعد نجاح العملية
            return response()->json([
                'message' => 'Table has been reserved successfully.',
                'table' => new TableResource($table)
            ], 200);
        });
    }

    public function free(Request $request)
    {
        $validated = $request->validate([
            'table_number' => 'required|integer|exists:tables,table_number',
        ]);

        // الحصول على الطاولة باستخدام رقم الطاولة المدخل
        $table = Table::where('table_number', $validated['table_number'])->first();

        return DB::transaction(function () use ($table) {
            // التحقق مما إذا كانت الطاولة بالفعل متاحة
            if ($table->status === 'available') {
                return response()->json([
                    'message' => 'This table is already available.'
                ], 400);
            }

            // تحرير الطاولة وجعلها متاحة مجددًا
            $table->update(['status' => 'available']);

            // إرسال إشعار عند تحرير الطاولة (اختياري)
//            Notification::send($table->user, new TableFreedNotification($table));

            return response()->json([
                'message' => 'Table has been freed successfully.',
                'table' => $table
            ], 200);
        });
    }

}
