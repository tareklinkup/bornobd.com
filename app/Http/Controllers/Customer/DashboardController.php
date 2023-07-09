<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use App\Models\Country;
use App\Models\Upazila;
use App\Models\Customer;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderDetails;
use App\Models\wishList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    public function __construct()
    {
        return $this->middleware('customerCheck');
    }
    public function dashboard()
    {
        $countries= Country::all();
        $districts = District::all();
       
        $order= Order::with('orderDetails')->where('customer_id',Auth::guard('customer')->user()->id)->get();
        $reward = OrderDetails::with('product');
        $customer_id = Auth::guard('customer')->user()->id;
    //   return $total = $reward->sum(function($reward){
    //         return (int)$reward->product;
    //     });


        $reward  =  $reward->whereHas('product', function ($products) use ($customer_id) {
            $products->where('customer_id', $customer_id);
        })->get();

        // return $this->$data['reward']->sum(function ($option) {
        //     return $option->pivot->price;
        // });

        
        $wishlist = wishList::with('product')->where('customer_id', Auth::guard('customer')->user()->id)->get();
        return view('website.customer.dashboard', compact('countries','districts','order','reward','wishlist'));
    }

    public function customerInvoice($id){
        $order = Order::with('orderDetails')->where('id', $id)->where('customer_id', Auth::guard('customer')->user()->id)->first();
        return view('website.customer.customer_invoice', compact('order'));
    }
  

    public function customerUpdate(Request $request, Customer $customer)
    {
      
        $this->validate($request, [
            'name'        => 'required|max:100',
            'phone'       => 'required|unique:customers,id|max:11',
            'email'       => 'unique:customers,id|max:50',
            // 'username'    => 'unique:customers,id|max:50',
            'ip_address'  => 'max:17'
        ]);

        $customer = Customer::where('id', auth()->guard('customer')->user()->id)->first();
        if ($request->profile_picture) {
            $image             = $request->file('profile_picture');
            if(!empty($customer->profile_picture) && file_exists($customer->profile_picture)){
                @unlink($customer->profile_picture);
            }
            if(!empty($customer->thum_picture) && file_exists($customer->thum_picture)){
                @unlink($customer->thum_picture);
            }
            $thum_picture      = Auth::guard('customer')->user()->name . uniqid() . '.' . $image->getClientOriginalExtension();
            $profile_picture   = Auth::guard('customer')->user()->name . uniqid() . '.' . $image->getClientOriginalExtension();
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
        $customer->code            = $code;
        $customer->profile_picture = $profilePicture;
        $customer->thum_picture    = $thumPicture;
        $customer->save();
        if ($customer) {
            Session::flash('message', 'Profile Update Successfully');
            return redirect()->back();
        } else {
            Session::flash('error', 'Profile Update fail');
            return back();
        }
         
       
    }

    public function addressChange(Request $request){
        // dd($request->all());
        $request->validate([
            // 'country_id'   =>'required',
            // 'district_id'  =>'required',
            // 'upazila_id'   =>'required',
            'address'      =>'required',
        ]);
        
        $customer = Customer::where('id',Auth::guard('customer')->user()->id)->first();
        // $customer->country_id  = $request->country_id;
        // $customer->district_id = $request->district_id;
        // $customer->upazila_id  = $request->upazila_id;
        $customer->address     = $request->address;
        $customer->save();
        return back()->with('success','address updated successfully');
    }
}
