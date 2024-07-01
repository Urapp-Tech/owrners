<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderExtra extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'order_id',
        'price',
        'is_basic_standard_premium'
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

}
