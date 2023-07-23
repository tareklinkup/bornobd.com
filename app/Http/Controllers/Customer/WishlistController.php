<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use App\Models\wishList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{



    public function wishtlistStore(Request $request)
    {
        if (Auth::guard('customer')->check()) {
            $wishlist = new wishList();
            $wishlist->product_id = $request->product_id;
            $wishlist->customer_id = Auth::guard('customer')->user()->id;
            $wishlist->save();
            if ($wishlist) {
                $message = array('title' => 'Successfully added to wishlist');
            }
            return response()->json($message);
        } else {
            return redirect()->route('customer.login');
        }
    }

    public function wishtlistShow()
    {
        if (Auth::guard('api')->check()) {
            $wishlist = wishList::where('customer_id', Auth::guard('api')->user()->id)->count();
            if ($wishlist) {
                return response()->json($wishlist);
            }
        } else {
            return response()->json(['title' => 'Wishlist Not Found!']);
        }
    }


    public function deleteWishlist($id)
    {
        if (Auth::guard('customer')->check()) {
            $delete = wishList::where('id', $id)->where('customer_id', Auth::guard('customer')->user()->id)->delete();
            if ($delete) {
                return back()->with('success', 'Wishlist remove successfully');
            }else{
                return 'not deleted';
            }
        } else {
            return redirect()->route('customer.login');
        }
    }

}