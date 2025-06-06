<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];
    public function rel_to_cat(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function rel_to_tag(){
        return $this->belongsTo(Tag::class, 'tags');
    }
    public function rel_to_inventory(){
        return $this->belongsTo(Inventory::class, 'product_id');
    }
    public function rel_to_inventory1(){
        return $this->hasMany(Inventory::class, 'product_id');
    }
}
