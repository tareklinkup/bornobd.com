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
use App\Models\Payment;
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
use Intervention\Image\Facades\Image;


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

    // public function productDetails($id)
    // {
    //     $data['product'] = Product::with('productImage')->find($id);
    //     if($data['product']->sub_category_id != null){
    //         $data['similerProduct'] = Product::where('category_id',  $data['product']->category_id)->where('id','!=' , $data['product']->id)->get();
    //     }else{
    //         $data['similerProduct'] = Product::where('sub_category_id',  $data['product']->sub_category_id)->where('id','!=' , $data['product']->id)->get();
    //     }
    //     return response()->json(['data' =>$data ], 200);
    // }

    // public function productDetails($id)
    // {
    //     $data['product'] = Product::with(['productImage', 'category'])->find($id);

    //       return response()->json(['data' => $data]);

    //     $size = explode(',', $data['product']->size_id);
    //     $sizes = Size::all();
    //     $data['size'] = [];
    //     foreach($sizes as $item){
    //         foreach ($size as $key => $s) {
    //             if ($s == $item->id){
    //                 $dataValue= $item;
    //                 array_push($data['size'], $dataValue);
    //             }
    //         }
    //     }

    //     $color = explode(',', $data['product']->color_id);
    //     $colors = Color::all();
    //     $data['color'] = [];
    //     foreach($colors as $item){
    //         foreach ($color as $key => $c) {
    //             if ($c == $item->id){
    //                 $dataValue = $item;
    //                 array_push($data['color'], $dataValue);
    //             }
    //         }
    //     }

    //     return response()->json(['data' => $data]);

    // }

       public function productDetails($id)
    {
        $data['product'] = Product::with(['productImage', 'category'])->find($id);

        $size = explode(',', $data['product']->size_id);
        $sizes = Size::all();
        $data['size'] = [];
        foreach($sizes as $item){
            foreach ($size as $key => $s) {
                if ($s == $item->id){
                    $dataValue= $item;
                    array_push($data['size'], $dataValue);
                }
            }
        }

        $color = explode(',', $data['product']->color_id);
        $colors = Color::all();
        $data['color'] = [];
        foreach($colors as $item){
            foreach ($color as $key => $c) {
                if ($c == $item->id){
                    $dataValue = $item;
                    array_push($data['color'], $dataValue);
                }
            }
        }

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
        $data['store'] = StoreLocation::all();

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


    // Wishlist section

    public function wishtlistStore(Request $request)
    {
        if (Auth::guard('api')->check()) {
            $wishlist = new wishList();
            $wishlist->product_id = $request->product_id;
            $wishlist->customer_id = Auth::guard('api')->user()->id;
            $wishlist->save();
            if ($wishlist) {
                // $message = array('title' => 'Successfully added to wishlist');
                return response()->json(['title' => 'Successfully added to wishlist'], 200);
            }
        } else {
            return response()->json(['title' => 'Failed added to wishlist'], 404);
        }

    }



    public function deleteWishlist($id)
    {
        if (Auth::guard('api')->check()) {
            $delete = wishList::where('product_id', $id)->where('customer_id', Auth::guard('api')->user()->id)->delete();
            if ($delete) {
                return response()->json(['title' => 'Successfully deleted wishlist'], 200);
            }
        } else {
            return response()->json(['title' => 'Failed deleted wishlist'], 404);
        }
    }


    public function wishtlistShow()
    {
        if (Auth::guard('api')->check()) {
            // $wishlist = wishList::where('customer_id', Auth::guard('api')->user()->id)->count();

        $data['wishlist'] = wishList::with('product')->where('customer_id', Auth::guard('api')->user()->id)->get();
        // return  $data['wishlist'];
            if ($data['wishlist']) {

                $sizes = [];
                $colors = [];

               foreach( $data['wishlist'] as $item)
               {

                    $size = explode(',', $item->product->size_id);
                    $color = explode(',', $item->product->color_id);

                    //size
                    foreach ($size as $key => $s) {
                        $dataValue= Size::where("id", $s)->first();
                        array_push($sizes, $dataValue);
                    }

                    //Color
                    foreach ($color as $key => $c)
                     {
                        $dataValue= Color::where("id", $c)->first();
                        array_push($colors, $dataValue);
                    }

                    $item->product->size = $sizes;
                    $item->product->color = $colors;

                    $sizes = [];
                    $colors = [];
                }

                 return response()->json(['data' => $data], 200);
            }
        } else {
            return response()->json(['title' => 'Wishlist not found'], 404);
        }
    }

    public function customerPasswordUpdate(Request $request)
    {
        if (Auth::guard('api')->check()) {
            // $request->validate([
            //     'currentPass' => 'required',
            //     'password' => 'required|confirmed|min:2',
            // ]);
            $currentPassword = Auth::guard('api')->user()->password;

            if (Hash::check($request->currentPass, $currentPassword)) {

                if (!Hash::check($request->password, $currentPassword)) {

                    $customer = Customer::find(Auth::guard('api')->id());
                    $customer->password = HasH::make($request->password);
                    $customer->save();

                    if ($customer) {
                        // Auth::guard('customer')->logout();
                        // Session::flash('success', 'Password Update Successfully');
                        return response()->json(['title' => 'Password Update Successfully'], 200);
                        // return back();
                    } else {
                        // Session::flash('error', 'Current password not match');
                        return response()->json(['title' => 'Current password not match'], 404);
                        // return back();
                    }

                } else {
                    // Session::flash('error', 'Same as Current password');
                    return response()->json(['title' => 'Same as Current password'], 404);
                    // return back();
                }
            } else {
                // Session::flash('error', '!Current password not match');
                return response()->json(['title' => '!Current password not match'], 404);
                // return back();
            }
        }
        else {
             return response()->json(['title' => 'success'], 200);
        }

    }


    public function customerUpdate(Request $request, Customer $customer)
    {

        $this->validate($request, [
            'name'        => 'required|max:100',
            'phone'       => 'required|unique:customers,id|max:11',
            'email'       => 'unique:customers,id|max:50',
            // 'username'    => 'unique:customers,id|max:50',
            'ip_address'  => 'max:17',
            'address'      =>'required'
        ]);

        $customer = Customer::where('id', auth()->guard('api')->user()->id)->first();
        if ($request->profile_picture) {
            $image             = $request->file('profile_picture');
            if(!empty($customer->profile_picture) && file_exists($customer->profile_picture)){
                @unlink($customer->profile_picture);
            }
            if(!empty($customer->thum_picture) && file_exists($customer->thum_picture)){
                @unlink($customer->thum_picture);
            }
            $thum_picture      = Auth::guard('api')->user()->name . uniqid() . '.' . $image->getClientOriginalExtension();
            $profile_picture   = Auth::guard('api')->user()->name . uniqid() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('uploads/customer/' . $thum_picture);
            Image::make($image)->resize(100, 100)->save('uploads/customer/profile_picture/' .$profile_picture);
            $thumPicture = 'uploads/customer/'.$thum_picture;
            $profilePicture = 'uploads/customer/profile_picture/'.$profile_picture;
        }else{
            $profilePicture =  $customer->profile_picture;
            $thumPicture =  $customer->thum_picture;
        }

        // $Image = $this->imageUpload($request, 'profile_picture', 'uploads/customer');
        $code = 'C' . $this->generateCode('Customer');
        $customer->name            = $request->name;
        $customer->email           = $request->email;
        $customer->phone           = $request->phone;
        $customer->username        = $request->phone;
        $customer->address         = $request->address;
        $customer->code            = $code;
        $customer->profile_picture = $profilePicture;
        $customer->thum_picture    = $thumPicture;
        $customer->save();
        if ($customer) {
            // Session::flash('message', 'Profile Update Successfully');
            return response()->json(['title' => 'Profile update Successfully']);
        } else {
            // Session::flash('error', 'Profile Update fail');
            return response()->json(['title' => 'Profile update Failed']);
        }


    }

    public function checkoutStore(Request $request)
    {


        $cart = json_encode($request->cart, true);


        $jsonDecode = json_decode($cart);

        // return response()->json(['cart' => $jsonDecode]);
        // dd();

        if (Auth::guard('api')->check()) {

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
                $charge = $Dcharge->charge ?? 0; // cash
            }

            // $total_amount = \Cart::getTotal() + $charge + $sum + $trailoring_sum;
            $total_amount = \Cart::getTotal() + $charge;
            $member_ship_discount = 0;
            if(!is_null(Auth::guard('api')->user()->membership_discount) && !session()->has('is_coupon_apply')){
                $discount_percent = Auth::guard('api')->user()->membership_discount;
                $member_ship_discount = (($total_amount * $discount_percent) / 100);
                $total_amount -= $member_ship_discount;
            }

            try {
                DB::beginTransaction();
                $order = new Order();
                $order->invoice_no              = $invoice_no;
                $order->customer_name           = $request->order['customer_name'];
                $order->shipping_name           = $request->order['shipping_name'] ?? $request->order['customer_name'];
                $order->customer_mobile         = $request->order['customer_mobile'];
                $order->shipping_phone          = $request->order['shipping_phone'] ?? $request->order['customer_mobile'];
                $order->customer_email          = $request->order['customer_email'];
                $order->shipping_email          = $request->order['shipping_email'] ?? $request->order['customer_mobile'];
                $order->billing_address         = $request->order['billing_address'];
                $order->shipping_address        = $request->order['shipping_address'] ?? $request->order['billing_address'];
                $order->note                    = $request->order['note'] ?? '';
                $order->updated_by              = Auth::guard('api')->user()->id;
                $order->customer_id             = Auth::guard('api')->user()->id;
                $order->shipping_cost           = $request->order['shipping_cost'];
                $order->ip_address              = $request->ip();
                $order->membership_discount     = $member_ship_discount;
                // $order->total_trailoring_charge = $trailoring_sum;
                // $order->total_wrapping_charge   = $sum;
                $order->total_amount            = $request->order['total_amount'];
                // $order->shop_id                 = $request->shop_id ?? NULL;
                // $order->area_id                 = $request->area_id ?? NULL;
                // $order->courier_id              = $request->courier_id ?? NULL;
                $order->save();


                // dd(\Cart::getContent());
                // return response()->json(['data' => $jsonDecode]);

                $orderDetails = array_map(function($product) {
                    return [
                        'product_id'     => $product['product_id'],
                        'product_name'  => $product['product_name'],
                        'customer_id'   => Auth::guard('api')->user()->id,
                        'price'        => $product['price'],
                        'color_id'      => $product['color_id'],
                        'size_id'      => $product['size_id'],
                        'quantity'     => $product['quantity'],
                        'message'     => $product['message'],
                        'total_price' => ($product['price'] *  $product['quantity'])
                    ];
                }, $request->cart);

                //  return $request->cart;

                $order->orderDetails()->createMany($orderDetails);

                foreach($jsonDecode as $value) {

                        $product_id = $value->product_id;

                        $wishlist = wishList::where('product_id', $product_id)->where('customer_id', Auth::guard('api')->user()->id)->delete();
                    }


                DB::commit();
                // $message = "সফল ভাবে আপনার অর্ডারটি সম্পন্ন হয়েছে, আপনি {$order->total_amount} টাকার অর্ডার করেছেন।";

                // Session::flash('message', 'Order Submit successfully');
                return response()->json(['title' => 'Order Submit Successfully', 'id' =>  $order->id, 'total_amount' => $order->total_amount]);

                // $this->send_sms($order->customer_mobile, $message);

                // Mail::to($order->customer_email)->send(new OrderConfirmation($order));

                if(session()->has('is_coupon_apply')){
                    session()->forget('is_coupon_apply');
                }



                \Cart::clear();

                // session(['orderId' => $order->id, 'invoice' => $invoice_no, 'order_total' => $order->total_amount]);
                // // dd($request->bkash_payment);
                // // if( isset($request->bkash_payment) && $request->bkash_payment == 1) {
                // //     return redirect()->route('url-pay');
                // // } else {
                // //     return redirect()->route('home.index');
                // // }

            } catch (\Exception $e) {
                return $e->getMessage();
                DB::rollBack();
                // Session::flash('error', 'order submitted fail!');
                return response()->json(['title' => 'Order Submitted Fail']);
            }
        } else {
            if ($request->customer_mobile) {
                $customer_check = Customer::where('phone', '=', $request->customer_mobile)->first();
                if ($customer_check) {
                    // Session::flash('success', 'You Have Already an Account Please login first to checkout');
                    return response()->json(['title' => 'You Have Already an Account Please login first to checkout']);

                    // return redirect()->route('customer.login');
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
                            $orderDetails->color_id = $value->color_id;
                            $orderDetails->size_id = $value->size_id;
                            $orderDetails->wp_price = $value->wp_price ?? NULL;
                            // $orderDetails->trailoring_charge = 0;
                            // $orderDetails->trailoring_charge = $value->tailoring_charge ?? NULL;
                            $orderDetails->total_price = $price;
                            $orderDetails->save();
                        }
                        if ($order) {
                            DB::commit();
                            // $message = "সফল ভাবে আপনার অর্ডারটি সম্পন্ন হয়েছে, আপনি {$order->total_amount} টাকার অর্ডার করেছেন।";

                            // Session::flash('message', 'Order Submit successfully');
                            return response()->json(['title' => 'Order Submit successfully']);

                            // $this->send_sms($order->customer_mobile, $message);

                            // Mail::to($order->customer_email)->send(new OrderConfirmation($order));

                            if(session()->has('is_coupon_apply')){
                                session()->forget('is_coupon_apply');
                            }

                            \Cart::clear();
                            // return redirect()->route('home.index');
                        } else {
                            DB::rollBack();
                            // Session::flash('error', 'order submitted fail!');
                            return response()->json(['title' => 'Order Submitted Fail!']);
                        }

                        } catch (\Exception $e) {
                            return $e->getMessage();
                            DB::rollBack();
                            // Session::flash('error', 'order submitted fail!');
                            return response()->json(['title' => 'Order Submitted Fail!']);
                        }
                    }
                }
            }
        }
    }


    public function reviewStore(Request $request){
        if (Auth::guard('api')->check()) {
            $request->validate([
                'customer_name' => 'required:max:50',
                'customer_email' => 'required|email|max:255',
                'review' => 'required:min:5',
                'product_id' => 'required',

            ]);

            $review = new Review();
            $review->product_id = $request->product_id;
            $review->rate = $request->rate;
            $review->customer_id = Auth::guard('api')->user()->id;
            $review->customer_name = $request->customer_name;
            $review->customer_email = $request->customer_email;
            $review->review = $request->review;
            $review->save();
            if($review){
                $success = 'successfully review waiting for approve admin';
            }
           return response()->json(['title' => $success], 200);
        } else {
            return response()->json(['title' => 'Opps Something Wrong!'], 404);
        }
    }

        public function executePayment(Request $request)
    {

            $payment = new Payment();
            $payment->order_id = $request->payerReference;
            $payment->invoice = $request->merchantInvoiceNumber;
            $payment->payment_id = $request->paymentID;
            $payment->trx_id = $request->trxID;
            $payment->phone = $request->customerMsisdn;
            $payment->amount = $request->amount;
            $payment->status = 'a';
            $payment->save();

            $order = Order::where('id', $payment->order_id)->first();
            $order->payment_status = 'a';
            $order->save();

            if($payment){
                return response()->json(['title' => 'Payment Success'], 200);
            } else {
            return response()->json(['title' => 'Opps Something Wrong!'], 404);
           }

    }


    public function showReview($id)
    {

        if(Auth::guard('api')->check()){
            $reviewList = Review::with('customer')->where('product_id', $id)->where('customer_id', Auth::guard('api')->user()->id)->orWhere('status', 'a')->latest()->get();

        }else{
            $reviewList = Review::where('product_id', $id)->where('status', 'a')->latest()->get();
        }
        return response()->json($reviewList);
    }

    public function orderList()
    {
        if(Auth::guard('api')->check())
        {
            $data['order'] = Order::with('orderDetails')->where('customer_id',Auth::guard('api')->user()->id)->get();

            // $data['size'] = Size::where('id', )
            return $data['order'];

            //return response()->json(['data' => $data['order'] ]);
        }

    }

 }