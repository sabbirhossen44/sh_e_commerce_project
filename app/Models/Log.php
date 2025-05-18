<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['id'];
    public function re_to_user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
