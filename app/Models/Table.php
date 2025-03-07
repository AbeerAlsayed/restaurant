<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['table_number', 'floor', 'status','reserved_by','guests_count','capacity'];

    public function reservedBy()
    {
        return $this->belongsTo(User::class, 'reserved_by');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
