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
    public function index(Request $request)
    {
        $request->validate([
            'floor' => 'nullable|integer|in:1,2',
        ]);

        $tables = Table::when($request->floor, function ($query) use ($request) {
            return $query->where('floor', $request->floor);
        })->get();

        return TableResource::collection($tables);
    }

    public function reserve(Request $request, $tableNumber)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'You must be logged in to reserve a table.'], 403);
        }

        $table = Table::where('table_number', $tableNumber)->first();

        if (!$table) {
            return response()->json(['message' => 'Table not found.'], 404);
        }

        $validated = $request->validate([
            'guests_count' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($table, $validated) {
            if ($table->status !== 'available') {
                return response()->json(['message' => 'This table is not available.'], 400);
            }

            if ($validated['guests_count'] > $table->capacity) {
                return response()->json([
                    'message' => 'The table cannot accommodate this number of guests.',
                    'table_capacity' => $table->capacity,
                ], 400);
            }

            $table->update([
                'status' => 'reserved',
                'reserved_by' => auth()->id(),
                'guests_count' => $validated['guests_count'],
            ]);

            return response()->json([
                'message' => 'Table has been reserved successfully.',
                'table' => new TableResource($table),
            ], 200);
        });
    }

    public function free($tableNumber)
    {
        $table = Table::where('table_number', $tableNumber)->first();

        return DB::transaction(function () use ($table) {
            if ($table->status !== 'reserved') {
                return response()->json([
                    'message' => 'This table is not reserved.'
                ], 400);
            }

            if ($table->reserved_by !== auth()->id()) {
                return response()->json([
                    'message' => 'You are not authorized to free this table.'
                ], 403);
            }

            $table->update([
                'status' => 'available',
                'reserved_by' => null,
                'guests_count' => null,
            ]);

            return response()->json([
                'message' => 'Table has been freed successfully.',
                'table' => new TableResource($table), // استخدام المورد لعرض الطاولة
            ], 200);
        });
    }

}
