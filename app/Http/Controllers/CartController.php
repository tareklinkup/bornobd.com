<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function cartAdd(Request $request,$id){

        $product = Product::where('id',$id)->first();
        if($request->color_id){
         $color = Color::where('id',$request->color_id)->first()->name;
        }else{
            return back()->with('success','Please Select Color First');
        }

        $size = Size::where('id',$request->size_id)->first()->name;
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

        return back()->with('success','Cart Added Successfully');

    }

    public function cartUpdate(Request $request,$id){
        \Cart::update(
            $id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );
        return back()->with('success','Card Updated Successfully');
    }

    public function cartRemove($id){
        \Cart::remove($id);
        return back()->with('success','Cart Remove Successfully');
    }

    public function checkoutCart(Request $request, $id){
        // dd($request->all());
        $product = Product::where('id', $id)->first();
        if($request->color_id !=''){
            $color = Color::where('id', $request->color_id)->first()->name;
        }else{
            $color = '';
        }

        if($request->size_id != ''){
            $size = Size::where('id', $request->size_id)->first()->name;
        }else{
            $size = '';
        }

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
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
                'category_id' => $product->category_id,
            )
        ]);

        return redirect()->route('checkout')->with('success','Checkout Added Successfully');
    }

    public function cartIncrementDecrement($data,$id)
    {
        \Cart::update(
            $id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $data
                ],
            ]
        );
        return response()->json('success');
    }

    public function giftCartUpdate(Request $request,$id){
    // dd($request->all());
        $product = Product::where('id',$id)->first();

        \Cart::update(
            $id,
            [
                'from_name' =>  $request->from_name,
                'to_name' =>  $request->to_name,
                'message' =>  $request->message,
                'wp_price' =>  $request->wp_price,
            ]
        );
        // dd(\Cart::getContent());
        return back()->with('success','Wrapping Added Successfully');

    }


    public function ajaxCartRemove($id){
        \Cart::remove($id);

        return response()->json('success');
    }

    public function trailoringAdd(Request $request,$id){
        $product =Product::where('id',$id)->where('is_tailoring',1)->first();
        \Cart::update(
            $id,
            [
                'tailoring_charge' =>  $product->tailoring_charge,
                'trailoring_description' => $request->description
            ]
        );
        return back()->with('success','Trailoring Added Successfully');
    }


}