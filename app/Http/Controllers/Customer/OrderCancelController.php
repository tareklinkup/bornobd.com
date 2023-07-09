<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderCancelController extends Controller
{
    public function cancel($id){
        if (Auth::guard('customer')->check()){
            $order = Order::find($id);
            $orderDetails = OrderDetails::where('order_id',$id)->get();
            foreach($orderDetails as $item){
                $product = Product::with('inventory')->where('id',$item->product_id)->first();
                $product->inventory->purchage = $product->inventory->purchage + $item->quantity;
                $product->inventory->sales = $product->inventory->sales - $item->quantity;
                $product->inventory->save();
            }
            
            $order->status = 'c';
            $order->updated_by = Auth::guard('customer')->user()->id;
            $order->save();
            $customer = Order::where('customer_id',Auth::guard('customer')->user()->id)->first();
            $customer_phone = $customer->customer_mobile;
            $message = "You order cancel now. Your order invoice no. $customer->invoice_no ";
            $this->send_sms($customer_phone , $message);
            return back()->with('success','Order cancel successfully');
        }
    }
}
