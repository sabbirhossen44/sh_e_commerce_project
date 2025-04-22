<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCancel extends Model
{
    public function re_to_order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
   
}
