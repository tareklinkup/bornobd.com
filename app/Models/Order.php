<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable  = ['customer_id','invoice_no','customer_name','customer_mobile','customer_email','shipping_address','billing_address','vat_amount','shipping_cost','total_amount','updated_by','status'];

    // customer relationship
    public function customer(){
    	return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    // customer relationship
    public function orderDetails(){
    	return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    public function deliveryTime(){
        return $this->belongsTo(DeliveryTime::class,'time_id','id');
    }
}
