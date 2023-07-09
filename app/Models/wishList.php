<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wishList extends Model
{
    use HasFactory;
    protected $filable= ['product_id', 'customer_id'];
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
