<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    protected $dates = ['created_at', 'updated_at','deleted_at'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }

    public function getDeletedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('m/d/Y') : null;
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
