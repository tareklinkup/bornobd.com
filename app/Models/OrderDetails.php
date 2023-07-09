<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetails extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['product_id','order_id','product_name','price','quantity','total_price',''];
    public function order(){
    	return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function product(){
    	return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
    public function color(){
    	return $this->belongsTo(Color::class, 'color_id', 'id');
    }
    public function size(){
    	return $this->belongsTo(Size::class, 'size_id', 'id');
    }
    
    
}
