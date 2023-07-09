<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Coupon;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
   public function index(){
    $coupons =  Coupon::all();
    $category = Category::all();
    return view('admin.coupon.index', compact('coupons', 'category'));
   }

   public function store(Request $request)
   {
       $request->validate([
           'start_date' => 'required',
           'expiry_date' => 'required|after:start_date',
           'percent' => 'required',
           'category_id' => 'required',
       ]);
       
       // dd($request->all());
       // try {  
           $coupon = new Coupon();
           $coupon->code = $request->code;
           if($request->sub_category_id){
               $coupon->category_id = $request->category_id;
               $coupon->sub_category_id = $request->sub_category_id;
           }else{
               $coupon->category_id = $request->category_id;
           }
           $coupon->percent = $request->percent;
           $coupon->start_date = $request->start_date;
           $coupon->expiry_date = $request->expiry_date;
           $coupon->save();
           return redirect()->route('coupon.index')->with('success', "Coupon Successfully Created");
       // } catch (Exception $e) {
           // return redirect()->back()->with('error', "Coupon Code doesn't Created");
       // }
   }
   public function edit($id)
   {
       $data['coupon'] = Coupon::find($id);
       $data['coupons'] = Coupon::all();
       $data['category'] = Category::all();
       return view('admin.coupon.edit', $data);
   }

   public function update(Request $request, $id)
   {
       try {
           $request->validate([
               'start_date' => 'required',
               'expiry_date' => 'required|after:start_date',
               'percent' => 'required',
               'category_id' => 'required',
           ]);
           // $code = rand(1000, 9999);
           $coupons = Coupon::find($id);
           $coupons->code = $request->code;
           $coupons->category_id = $request->category_id;
           $coupons->sub_category_id = $request->sub_category_id;
           $coupons->percent = $request->percent;
           $coupons->start_date = $request->start_date;
           $coupons->expiry_date = $request->expiry_date;
           $coupons->save();
           return redirect()->route('coupon.index')->with('success', "Coupon Update Successfully");
       } catch (Exception $e) {
           return redirect()->back()->with('error', "Somethig Is Worng");
       }
   }
   public function destroy($id)
   {
       try {
           $coupon = Coupon::find($id);
           $coupon->delete();
           return redirect()->route('coupon.index')->with('success', "Coupon code Successfully Delete");
       } catch (Exception $e) {
           return redirect()->back()->with('error', "Something Is worng");
       }
   }
}
