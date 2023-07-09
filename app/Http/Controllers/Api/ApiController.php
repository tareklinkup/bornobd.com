<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\Size;
use App\Models\Color;
use App\Models\Order;
use App\Models\Thana;
use App\Models\Banner;
use App\Models\Review;
use App\Models\Country;
use App\Models\Product;
use App\Models\Service;
use App\Models\Upazila;
use App\Models\Category;
use App\Models\Customer;
use App\Models\District;
use App\Models\Tracking;
use App\Models\wishList;
use App\Models\Inventory;
use App\Models\SubCategory;
use App\Models\OrderDetails;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\StoreLocation;
use App\Models\CompanyProfile;
use App\Models\DeliveryCharge;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class ApiController extends Controller
{
    public function hotline(){
        $hotline = CompanyProfile::select('phone_1', 'phone_2')->first();
        return response()->json(['data' => $hotline], 200);
    }
 
    public function product(){
        $products = Product::with(['category'])->latest()->paginate(20);
        foreach ($products as $product) {
            $size_id = $product->size_id;
            $size_array = explode(',', $size_id);
            $sizes = [];
            foreach ($size_array as $size) {
                $size_obj = Size::find($size);
                array_push($sizes, $size_obj);
            }
            $product->sizes = $sizes;

            // Color Get
            $color_id = $product->color_id;
            $color_array = explode(',', $color_id);
            $colors = [];
            foreach ($color_array as $color) {
                $color_obj = Color::find($color);
                array_push($colors, $color_obj);
            }
            $product->colors = $colors;
        }
        // $product = Product::select('id','product_code as code','category_id','sub_category_id','name','price','discount','main_image','small_image', 'thumb_image','short_details','description','is_deal')->whereNull('deleted_at')->inRandomOrder()->get()->makeHidden(['color_id','size_id' ]);
        // $size = explode(',', $product->size_id);     
        return response()->json(['data' =>  $products], 200);
    }

    public function productDetails($id)
    {
        $data['product'] = Product::with('productImage')->find($id);
        if($data['product']->sub_category_id != null){
            $data['similerProduct'] = Product::where('category_id',  $data['product']->category_id)->where('id','!=' , $data['product']->id)->get();
        }else{
            $data['similerProduct'] = Product::where('sub_category_id',  $data['product']->sub_category_id)->where('id','!=' , $data['product']->id)->get();
        }
        return response()->json(['data' =>$data ], 200);
    }
 
    public function getProductImage($id){
        $productImage = ProductImage::select('other_main_image', 'other_mediam_image', 'other_small_image')->where('product_id', $id)->get();
        return response()->json(['data' =>$productImage ], 200);
    }
    // category api
    public function getCategory(){
        $category = Category::with(['SubCategory', 'product'])->latest()->get();
        return response()->json(['data' => $category], 200);
    }
 
    public function getCategoryOnly(){
        $category = Category::latest()->get();
        return response()->json(['data' => $category], 200);
    }

    public function getSubcategory($id){
        $subcategory = SubCategory::where('category_id', $id)->get();
        return response()->json(['data' =>  $subcategory]);
    }
 
     // slider 
    public function banner(){
        $banner = Banner::select('image')->latest()->get();
        return response()->json(['data'=>$banner], 200);
    }
 
     // product api 
    public function recentProduct(){
        $recent = Product::select('id','product_code as code','category_id','sub_category_id','name','price','discount','main_image','small_image', 'thumb_image','short_details','description','is_deal')->latest()->take(20)->get();
        return response()->json(['data' =>$recent]); 
    }
    public function recentProductInner(){
        $recent = Product::select('id','product_code as code','category_id','sub_category_id','name','price','discount','main_image','small_image', 'thumb_image','short_details','description','is_deal')->latest()->paginate(20);
        return response()->json($recent); 
    }

    // Hot Deal Product
    public function dealProduct()
    {
        $product = Product::with('category', 'productImage')->where('is_deal', 1)->latest()->paginate(4);
        return response()->json(['data'=>$product], 200);
    }

     // popular
    //  public function popularInner(){
    //      $popular = Product::select('id','code','name','slug','category_id','sub_category_id','price','discount','image','thum_image','discount','size_id','color_id','short_details',strip_tags('description'),'is_popular','is_offer')->with('inventory')->where('is_popular', '1')->latest()->paginate(20);
    //  //    response()->json(!$popular->short_details !);
    //      return response()->json($popular); 
    //  }
    
     public function newArrival(){
        $newarrival = Product::where('new_arrival', '1')->latest()->paginate(20);
        return response()->json($newarrival); 
     }
     public function featureProduct(){
        $feature = Product::where('is_feature', '1')->latest()->get();
        return response()->json($feature); 
     }
     public function trending(){
        $trending = Product::where('is_trending', '1')->latest()->paginate(20);
        return response()->json($trending); 
     }
    //  public function featureProduct(){
    //     $feature = Product::where('is_feature', '1')->latest()->paginate(12);
    //     return response()->json($feature, 200); 
    //  }
     public function trendingHome(){
        $trendingHome = Product::select('id','product_code as code','category_id','sub_category_id','name','price','discount','main_image','small_image', 'thumb_image','short_details','description','is_deal')->where('is_trending', '1')->latest()->take(20)->get();
        return response()->json(['data' =>$trendingHome]); 
     }
   
    public function subcategoryWiseProduct($id){
        $product = Product::select('id','product_code as code','category_id','sub_category_id','name','price','discount','main_image','small_image', 'thumb_image','short_details','description','is_deal')->where('sub_category_id', $id)->get();
        return response()->json(['data' => $product]);   
    }

    public function categoryWiseProduct($id){
        $product = Product::where('category_id', $id)->paginate(12);
        return response()->json(['data' => $product], 200);
    }
    
    // order
    public function search($name)
    {
        $result = Product::where('name', 'LIKE', '%'. $name. '%')->orderBy('name', 'asc')->get();
        if(count($result)){
          return Response()->json(['data' => $result]);
        }
        else
        { 
        return response()->json(['Result' => 'Data not found'], 404);
       }
    }

    public function getArea(){
        $area = DeliveryCharge::get();
        return response()->json(['data' => $area]);
    }

    public function getCharge($id){
        $thana = DeliveryCharge::where('id',$id)->first();
        return response()->json(['data' => $thana]);
    }

    public function cartAdd(Request $request, $id)
    {
        $product = Product::find($id);
        if($request->color_id){
         $color = Color::where('id', $request->color_id)->first()->name;
        }else{
            return response()->json(['message'=>'Please Select Color First'], 406);
        }
        
        $size = Size::where('id', $request->size_id)->first()->name;

        if($product->discount != ''){
            $price = calculateDiscount($product->price, $product->discount);
        }else{
            $price = $product->price; 
        }

        \Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $product->small_image,
                'slug' => $product->slug,
                'color' => $color,
                'size'  => $size,
                'category_id' => $product->category_id,
                'sub_category_id' => $product->sub_category_id,
            )
        ]);
        // session(['key' => 'value']);
        return response()->json(['data' => 'Item Added to Cart'], 200);
    }

    public function getCart()
    {
        return response()->json(['data' => \Cart::getContent()], 200);
    }

    public function checkout()
    {
        $data['colors'] = Color::all();
        $data['sizes'] = Size::all();
        $data['countries'] = Country::all();
        $data['delivery_charge'] = DeliveryCharge::all();
        $data['upazilas'] = Upazila::all();
        $data['courier'] = Tracking::all();
        // $data['store'] = StoreLocation::all();

        $data['carts'] = \Cart::getContent();
        $data['product'] = Product::with('category')->get();
        return response()->json(['data' => $data], 200);
    }

    public function justOrderStore(Request $request)
    {
        $last_invoice_no =  Order::whereDate('created_at', today())->latest()->take(1)->pluck('invoice_no');
        
        if (count($last_invoice_no) > 0) {
            $invoice_no = $last_invoice_no[0] + 1;
        } else {
            $invoice_no = date('ymd') . '000001';
        }

        $cart = json_decode($request->cart);
        $cart = array_values((array)$cart);
        $charge = 0;
        if ($request->total_amount) {
            $charge = 0;
        } 

        // $cart_total = 0;
        // foreach ($cart as $item) {
        //     $cart_total +=  $item->total_amount;
        // }

        // $total_amount = $cart_total + $charge + $sum + $trailoring_sum;
        // $total_amount = $cart_total + $charge;
        

        $order = new Order();
        $order->invoice_no              = $invoice_no;
        $order->customer_name           = $request->customer_name;
        $order->shipping_name           = $request->shipping_name ?? $request->customer_name;
        $order->customer_mobile         = $request->customer_mobile;
        $order->shipping_phone          = $request->shipping_phone ?? 0;
        $order->customer_email          = $request->customer_email ?? null;
        $order->billing_address         = $request->billing_address;
        $order->shipping_address        = $request->shipping_address;
        $order->note                    = $request->note ?? '';
        $order->updated_by              = Auth::guard('api')->user()->id;
        $order->customer_id             = Auth::guard('api')->user()->id;
        $order->shipping_cost           = $request->shipping_cost;
        $order->ip_address              = $request->ip();
        $order->total_amount            = $request->total_amount;
        $order->save();

        foreach ($request->products as $value) {
            $orderDetails = new OrderDetails();
            $orderDetails->order_id = $order->id;
            $orderDetails->product_id = $value["id"];
            $orderDetails->product_name = $value["name"];
            $orderDetails->customer_id = Auth::guard('api')->user()->id;
            $orderDetails->price = $value["price"];
            $orderDetails->quantity = $value["quantity"];
            $orderDetails->color_id = $value["size_id"];
            $orderDetails->size_id = $value["color_id"];
            $orderDetails->total_price = $value["quantity"] * $value["price"];
            $orderDetails->save();
        } 
        // return response()->json(['data' => $products], 200);
        return response()->json(['data' => 'Successfully Place Order'], 200);
    }
 
    public function orderStore(Request $request)
    {  
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

        $cart = json_decode($request->cart);
        $cart = array_values((array)$cart);
        $charge = 0;
        if (($request->total_amount > $freeShipping) || $is_free_shipping) {
            $charge = 0;
        } 

        // else {
        //     $Dcharge = DeliveryCharge::where('id', $request->area_id)->select('charge')->first();
        //     $charge = $Dcharge->charge;
        // }

        $sum = 0;
        $trailoring_sum = 0;
        $cart_total = 0;
        foreach ($cart as $item) {
            $cart_total +=  $item->total_amount;
            // $sum +=  $item->wp_price;
            // $trailoring_sum +=  $item->tailoring_charge;
        }

        // $total_amount = $cart_total + $charge + $sum + $trailoring_sum;
        $total_amount = $cart_total + $charge;
        $member_ship_discount = 0;
        // if(!is_null($request->customer_id->membership_discount) && !session()->has('is_coupon_apply')){
        //     $discount_percent = $request->customer_id->membership_discount;

        //     $member_ship_discount = (($total_amount * $discount_percent) / 100);

        //     $total_amount -= $member_ship_discount;

        // }
          
            // try {
            //  DB::beginTransaction();
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
                $order->updated_by              = Auth::guard('api')->user()->id;
                $order->customer_id             = Auth::guard('api')->user()->id;
                $order->shipping_cost           = $charge;
                // $order->shipping_cost           = $request->shipping_cost;
                $order->ip_address              = $request->ip();
                $order->membership_discount     = $member_ship_discount ;
                $order->total_amount            = $total_amount;
                $order->save();
           
                foreach ($cart as $value) {
                    $price = $value->price * $value->quantity;
                    $orderDetails = new OrderDetails();
                    $orderDetails->order_id = $order->id;
                    $orderDetails->product_id = $value->id;
                    $orderDetails->product_name = $value->name;
                    $orderDetails->customer_id = Auth::guard('api')->user()->id;
                    $orderDetails->price = $value->price;
                    $orderDetails->quantity = $value->quantity;
                    $orderDetails->total_price = $price;
                    $orderDetails->save();
                    // if ($orderDetails) {
                    //     $product_id = $orderDetails->product_id;
                        // $wishlist = wishList::where('product_id', $product_id)->where('customer_id', Auth::guard('customer')->user()->id)->delete();
                        // if ($wishlist) {
                        //     Session::flash('success', 'Your Wishlist Is clear');
                        // }
                    // }
                }
                if($order){
                    DB::commit();
                    // $message = "সফল ভাবে আপনার অর্ডারটি সম্পন্ন হয়েছে, আপনি {$order->total_amount} টাকার অর্ডার করেছেন।";
    
                    // Session::flash('message', 'Order Submit successfully');
    
                    // $this->send_sms($order->customer_mobile, $message);
    
                    // Mail::to($order->customer_email)->send(new OrderConfirmation($order));
    
                    // if(session()->has('is_coupon_apply')){
                    //     session()->forget('is_coupon_apply');
                    // }
                    return 'success';
                }else{
                    \DB::rollBack();
                    return 'opps';
                }
               
            // } catch (\Throwable $th) {
            //     \DB::rollBack();
            //    return 'opps';
            // }
       
    
    }

    public function customerStore(Request $request)
    {
        $rules=array(
            'name' => 'required',
            'phone' => 'required|unique:customers|regex:/^01[13-9][\d]{8}$/|min:11',
            'password' => 'required'
        );

        $messages=array(
            'name.required'     => 'Please enter name.',
            'phone.required'    => 'Please enter phone number.',
            'password.required' => 'Please enter password.'
        );
      
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $errors   = $messages->all();
            return response()->json($errors); 
        }
             $customer = new Customer();
             $code = 'C' . $this->generateCode('Customer');
             $customer->name = $request->name;
             $customer->phone = $request->phone;
             $customer->username = $request->phone;
             $customer->address = $request->address;
             $customer->password = Hash::make($request->password);
             $customer->ip_address = $request->ip();
             $customer->code = $code;
             $customer->save_by = $request->ip();
             $customer->updated_by = $request->ip();
            $customer->save();
            if( $customer){
                return "Customer Register Successfully";  
            }else{

                return "Customer Register faild";  
            }
        // } catch (\Throwable $th) {
           
        // }
        
     }

    //  Customer Logout
    public function logout()
    {

        // $customer_login = Auth::guard('customer')->logout();
        // return response()->json(['data' => $customer_login], 200);
        Auth::guard('customer')->logout();
        return response()->json(['message' => 'Logout Successfully']);
    }

    // Customer Dashboard
    public function dashboard()
    {
        $countries= Country::all();
        $districts = District::all();
       
        $order= Order::with('orderDetails')->where('customer_id',Auth::guard('customer')->user()->id)->get();
        $reward = OrderDetails::with('product');
        $customer_id = Auth::guard('customer')->user()->id;

        $reward  =  $reward->whereHas('product', function ($products) use ($customer_id) {
            $products->where('customer_id', $customer_id);
        })->get();

        $wishlist = wishList::with('product')->where('customer_id', Auth::guard('customer')->user()->id)->get();
        // return view('website.customer.dashboard', compact('countries','districts','order','reward','wishlist'));
        return response()->json(['data' => $order], 200);
    }

    public function get_user()
    {
        return response()->json(auth()->guard('api')->user());
    }

 }
 

