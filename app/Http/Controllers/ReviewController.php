<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller

{

    public function showReview($id){
        if(Auth::guard('customer')->check()){
            $reviewList = Review::where('product_id', $id)->where('customer_id', Auth::guard('customer')->user()->id)->orWhere('status', 'a')->latest()->get(); 
           
        }else{
            $reviewList = Review::where('product_id', $id)->where('status', 'a')->latest()->get(); 
        }
        return response()->json($reviewList);
    }

    public function reviewStore(Request $request){
        if (Auth::guard('customer')->check()) {
            $request->validate([
                'customer_name' => 'required:max:50',
                'customer_email' => 'required|email|max:255',
                'review' => 'required:min:5',
              
            ]);

            $review = new Review();
            $review->product_id = $request->product_id;
            $review->rate = $request->rate;
            $review->customer_id = Auth::guard('customer')->user()->id;
            $review->customer_name = $request->customer_name;
            $review->customer_email = $request->customer_email;
            $review->review = $request->review;
            $review->save();
            if($review){
                $success = 'successfully review waiting for approve admin';
            }
           return response()->json($success);
        } else {
            return response()->json('Opps');
        }
    }

    public function reviewList(){
        $reviewList = Review::with('product')->latest()->get(); 
        return view('admin.customer.reviewList', compact('reviewList'));
    }

    public function reviewActive($id){
       Review::where('id', $id)->update([
            'status' => 'a',
        ]);
        return redirect()->back()->with('success', 'Review Active Successfully');
    }
    public function reviewPending($id){
        Review::where('id', $id)->update([
            'status' => 'p'
        ]);
        return redirect()->back()->with('success', 'Review Pending Successfully');
    }

    public function delete($id){
      Review::where('id', $id)->delete();
        return back()->with('success', 'Product review deleted successfully');
    }



}
