<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = ['category_id','sub_category_id','code','expiry_date','start_date','percent '];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
