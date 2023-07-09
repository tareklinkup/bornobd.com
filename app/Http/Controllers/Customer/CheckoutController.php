<?php

namespace App\Http\Controllers\Customer;

use Exception;

use Carbon\Carbon;
use App\Models\Size;
use App\Models\Color;
use App\Models\Order;
use App\Mail\SendMail;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Country;
use App\Models\Upazila;
use App\Models\Customer;
use App\Models\District;
use App\Models\wishList;

use App\Models\OrderDetails;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use App\Models\DeliveryCharge;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\StoreLocation;
use App\Models\Tracking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Claims\Custom;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $data['colors'] = Color::all();
        $data['sizes'] = Size::all();
        $data['countries'] = Country::all();
        $data['delivery_charge'] = DeliveryCharge::all();
        $data['upazilas'] = Upazila::all();
        $data['courier'] = Tracking::all();
        $data['store'] = StoreLocation::all();

        $carts = \Cart::getContent();
        $similar_ids = [];

        foreach($carts as $item){
            $simillar_porduct = Product::select('simillar_porduct')->where('id', $item->id)->first()->simillar_porduct;
            if(!is_null($simillar_porduct)){
                $similar_ids = array_merge($similar_ids,explode(",",$simillar_porduct));
            }
        }

        $similar_ids = array_unique($similar_ids);

        $data['product'] = Product::with('category')->whereIn('id', $similar_ids)->get();

        return view('website.customer.checkout', $data);
    }

    public function checkoutStore(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'customer_name'     => 'required|max:150',
                'customer_mobile'   => 'required|regex:/^01[3-9][\d]{8}$/|max:14',
                'customer_email'    => 'required|email|max:50',
                'billing_address'   => 'required',
                'area_id'           => 'required',
                // 'charge'            => 'required'
            ],

        );

        // $sum = 0;
        // $trailoring_sum = 0;
        // foreach (\Cart::getContent() as $item) {
        //     $sum +=  $item->wp_price;
        //     $trailoring_sum +=  $item->tailoring_charge;
        // }

        if (Auth::guard('customer')->check()) {
            $last_invoice_no =  Order::whereDate('created_at', today())->latest()->take(1)->pluck('invoice_no');
            if (count($last_invoice_no) > 0) {
                $invoice_no = $last_invoice_no[0] + 1;
            } else {  
                $invoice_no = date('ymd') . '000001';
            }
            $content = CompanyProfile::first();
            $freeShipping = $content->free_shipping;

            $is_free_shipping = false;

            if($content->happy_hour_date ){
                $today = now();
                if($content->happy_hour_date == $today->format('Y-m-d')){
                    $time_from = \Carbon\Carbon::parse($content->happy_hour_date . ' '. $content->happy_hour_time_from);
                    $time_to = \Carbon\Carbon::parse($content->happy_hour_date . ' '. $content->happy_hour_time_to);
                    if($today->gte($time_from) && $today->lt($time_to)){
                         $is_free_shipping = true;
                    }
                }
            }

            if ((\Cart::getTotal() > $freeShipping) || $is_free_shipping) {
                $charge = 0;
            } else {
                $Dcharge = DeliveryCharge::where('id', $request->area_id)->select('charge')->first();
                $charge = $Dcharge->charge;
            }

            // $total_amount = \Cart::getTotal() + $charge + $sum + $trailoring_sum;
            $total_amount = \Cart::getTotal() + $charge;
            $member_ship_discount = 0;
            if(!is_null(Auth::guard('customer')->user()->membership_discount) && !session()->has('is_coupon_apply')){
                $discount_percent = Auth::guard('customer')->user()->membership_discount;
                $member_ship_discount = (($total_amount * $discount_percent) / 100);
                $total_amount -= $member_ship_discount;
            }

            try {
                DB::beginTransaction();
                $order = new Order();
                $order->invoice_no              = $invoice_no;
                $order->customer_name           = $request->customer_name;
                $order->shipping_name           = $request->shipping_name ?? $request->customer_name;
                $order->customer_mobile         = $request->customer_mobile;
                $order->shipping_phone          = $request->shipping_phone ?? $request->customer_mobile;
                $order->customer_email          = $request->customer_email;
                $order->shipping_email          = $request->shipping_email ?? $request->customer_email;
                $order->billing_address         = $request->billing_address;
                $order->shipping_address        = $request->shipping_address ?? $request->billing_address;
                $order->note                    = $request->note ?? '';
                $order->updated_by              = Auth::guard('customer')->user()->id;
                $order->customer_id             = Auth::guard('customer')->user()->id;
                $order->shipping_cost           = $charge;
                $order->ip_address              = $request->ip();
                $order->membership_discount     = $member_ship_discount;
                // $order->total_trailoring_charge = $trailoring_sum;
                // $order->total_wrapping_charge   = $sum;
                $order->total_amount            = $total_amount;
                // $order->shop_id                 = $request->shop_id ?? NULL;
                // $order->area_id                 = $request->area_id ?? NULL;
                // $order->courier_id              = $request->courier_id ?? NULL;
                $order->save();

                foreach (\Cart::getContent() as $value) {
                    // $price = $value->price * $value->quantity + $value->tailoring_charge + $value->wp_price;
                    $price = $value->price * $value->quantity;
                    $orderDetails = new OrderDetails();
                    $orderDetails->order_id = $order->id;
                    $orderDetails->product_id = $value->id;
                    $orderDetails->product_name = $value->name;
                    $orderDetails->customer_id = Auth::guard('customer')->user()->id;
                    $orderDetails->price = $value->price;
                    $orderDetails->quantity = $value->quantity;
                    $orderDetails->total_price = $price;
                    $orderDetails->from_name = $value->from_name;
                    $orderDetails->to_name = $value->to_name;
                    $orderDetails->wp_price = $value->wp_price ?? NULL;
                    $orderDetails->message = $value->message;
                    // $orderDetails->trailoring_charge = $value->tailoring_charge ?? '0';
                    // $orderDetails->trailoring_charge = 0;
                    $orderDetails->save();
                    if ($orderDetails) {
                        $product_id = $orderDetails->product_id;
                        $wishlist = wishList::where('product_id', $product_id)->where('customer_id', Auth::guard('customer')->user()->id)->delete();
                        if ($wishlist) {
                            Session::flash('success', 'Your Wishlist Is clear');
                        }
                    }
                }

                DB::commit();
                // $message = "সফল ভাবে আপনার অর্ডারটি সম্পন্ন হয়েছে, আপনি {$order->total_amount} টাকার অর্ডার করেছেন।";

                Session::flash('message', 'Order Submit successfully');

                // $this->send_sms($order->customer_mobile, $message);

                // Mail::to($order->customer_email)->send(new OrderConfirmation($order));

                if(session()->has('is_coupon_apply')){
                    session()->forget('is_coupon_apply');
                }

                \Cart::clear();
                return redirect()->route('home.index');
            } catch (\Exception $e) {
                return $e->getMessage();
                DB::rollBack();
                Session::flash('error', 'order submitted fail!');
            }
        } else {
            if ($request->customer_mobile) {
                $customer_check = Customer::where('phone', '=', $request->customer_mobile)->first();
                if ($customer_check) {
                    Session::flash('success', 'You Have Already an Account Please login first to checkout');
                    return redirect()->route('customer.login');
                } else {
                    $customer = new Customer();
                    $code = 'C' . $this->generateCode('Customer');
                    $customer->name = $request->customer_name;
                    $customer->phone = $request->customer_mobile;
                    $customer->email = $request->customer_email;
                    $customer->username = $request->customer_mobile;
                    $customer->address = $request->address;
                    $customer->password = Hash::make(1234);
                    $customer->ip_address = $request->ip();
                    $customer->status = 'g';
                    $customer->code = $code;
                    $customer->save_by = $request->ip();
                    $customer->updated_by = $request->ip();
                    $customer->save();

                    if ($customer) {
                        $last_invoice_no = Order::whereDate('created_at', today())->latest()->take(1)->pluck('invoice_no');
                        if (count($last_invoice_no) > 0) {
                            $invoice_no = $last_invoice_no[0] + 1;
                        } else {
                            $invoice_no = date('ymd') . '000001';
                        }
                        $content = CompanyProfile::first();
                        $freeShipping = $content->free_shipping;

                        $is_free_shipping = false;

                        if($content->happy_hour_date ){
                            $today = now();
                            if($content->happy_hour_date == $today->format('Y-m-d')){
                                $time_from = \Carbon\Carbon::parse($content->happy_hour_date . ' '. $content->happy_hour_time_from);
                                $time_to = \Carbon\Carbon::parse($content->happy_hour_date . ' '. $content->happy_hour_time_to);
                                if($today->gte($time_from) && $today->lt($time_to)){
                                    $is_free_shipping = true;
                                }
                            }
                        }

                        if ((\Cart::getTotal() > $freeShipping) || $is_free_shipping) {
                            $charge = 0;
                        } else {
                            $Dcharge = DeliveryCharge::where('id', $request->area_id)->select('charge')->first();
                            $charge = $Dcharge->charge;
                        }

                        try {
                        DB::beginTransaction();
                        $order = new Order();
                        $order->invoice_no          = $invoice_no;
                        $order->customer_name       = $request->customer_name;
                        $order->shipping_name       = $request->shipping_name ?? $customer->name;
                        $order->customer_mobile     = $request->customer_mobile;
                        $order->shipping_phone      = $request->shipping_phone ?? $customer->phone;
                        $order->customer_email      = $request->customer_email;
                        $order->shipping_email      = $request->shipping_email ?? $customer->email;
                        $order->billing_address     = $request->billing_address;
                        $order->shipping_address    = $request->shipping_address ?? $customer->address;
                        $order->note                = $request->note ?? '';
                        $order->updated_by          = $customer->id;
                        $order->customer_id         = $customer->id;
                        $order->shipping_cost       = $charge;
                        $order->membership_discount = $member_ship_discount ?? '0';
                        // $order->total_trailoring_charge = $trailoring_sum ?? '0';
                        // $order->total_trailoring_charge = 0;
                        $order->ip_address          = $request->ip();
                        $order->shop_id                 = $$request->shop_id ?? NULL;
                        $order->area_id                 = $request->area_id ?? NULL;
                        $order->courier_id              = $request->courier_id ?? NULL;
                        $order->total_amount        = \Cart::getTotal() + $charge;
                        // $order->total_amount        = \Cart::getTotal() + $charge + $sum + $trailoring_sum;
                        $order->save();

                        foreach (\Cart::getContent() as $value) {
                            // $price = $value->price * $value->quantity + $value->tailoring_charge + $value->wp_price;
                            $price = $value->price * $value->quantity;
                            $orderDetails = new OrderDetails();
                            $orderDetails->order_id = $order->id;
                            $orderDetails->product_id = $value->id;
                            $orderDetails->product_name = $value->name;
                            $orderDetails->customer_id = $customer->id;
                            $orderDetails->price = $value->price;
                            $orderDetails->quantity = $value->quantity;
                            $orderDetails->wp_price = $value->wp_price ?? NULL;
                            // $orderDetails->trailoring_charge = 0;
                            // $orderDetails->trailoring_charge = $value->tailoring_charge ?? NULL;
                            $orderDetails->total_price = $price;
                            $orderDetails->save();
                        }
                        if ($order) {
                            DB::commit();
                            // $message = "সফল ভাবে আপনার অর্ডারটি সম্পন্ন হয়েছে, আপনি {$order->total_amount} টাকার অর্ডার করেছেন।";

                            Session::flash('message', 'Order Submit successfully');

                            // $this->send_sms($order->customer_mobile, $message);

                            // Mail::to($order->customer_email)->send(new OrderConfirmation($order));

                            if(session()->has('is_coupon_apply')){
                                session()->forget('is_coupon_apply');
                            }
                            
                            \Cart::clear();
                            return redirect()->route('home.index');
                        } else {
                            DB::rollBack();
                            Session::flash('error', 'order submitted fail!');
                        }

                        } catch (\Exception $e) {
                            return $e->getMessage();
                            DB::rollBack();
                            Session::flash('error', 'order submitted fail!');
                        }
                    }
                }
            }
        }
    }



    public function cuponCheck(Request $request)
    {

        $customer_id = Auth::guard('customer')->user()->id;

        
        if (Auth::guard('customer')->check()) {
            $today = now()->format('Y-m-d');
            $cuponCode = Coupon::whereDate('start_date', '<=', now())->whereDate('expiry_date', '>=', now())->get();

            $cupon = $request->cupon_code;
            $res = 'opps';
            foreach ($cuponCode as $cs) {
                $customer_ids = $cs->customer_id;
                $customer_ids = explode(",",$customer_ids);
                if ($cs->code == $cupon && !in_array($customer_id, $customer_ids)) {
                    foreach (\Cart::getContent() as  $cart) {
                        if ($cart->attributes->sub_category_id) {
                            if ($cart->attributes->sub_category_id == $cs->sub_category_id) {
                                $cupon_discount = ($cart->price * $cs->percent) / 100;
                                $discount_total = $cart->price - $cupon_discount;
                                \Cart::update(
                                    $cart->id,
                                    [
                                        'price' => $discount_total
                                    ]
                                );
                                Coupon::where('id', $cs->id)->update([
                                    'customer_id' => $cs->customer_id . ',' . $customer_id,
                                    'product_id' => $cs->product_id . ',' . $cart->id,
                                ]);
                                session()->flash('update', 'Cart is Updated Successfully !');
                                session(['is_coupon_apply' => 'yes']);
                                $res = "ok";
                            }
                        } elseif ($cart->attributes->category_id == $cs->category_id) {
                            $cupon_discount = ($cart->price * $cs->percent) / 100;
                            $discount_total = $cart->price - $cupon_discount;
                            \Cart::update(
                                $cart->id,
                                [
                                    'price' => $discount_total,
                                ]
                            );
                            Coupon::where('id', $cs->id)->update([
                                'customer_id' => $cs->customer_id . ',' . $customer_id,
                                'product_id' => $cs->product_id . ',' . $cart->id,
                            ]);
                            session()->flash('update', 'Cart is Updated Successfully !');
                            session(['is_coupon_apply' => 'yes']);
                            $res = "ok";
                        }
                    }
                }
            }
            return  $res;
        } else {
            return redirect()->route('customer.login');
        }
    }




    public function membershipApply()
    {
        $customer_id = Auth::guard('customer')->user()->id;

        if (Auth::guard('customer')->check()) {
            $memberShip = Coupon::where('expiry_date', '>=', now())->where('customer_id', 'not like', "%$customer_id%")->where('status', 'a')->get();
            if ($memberShip) {
            }
        }
    }
}
