<?php

namespace App\Http\Controllers;

use App\Models\BulkQuantity;
use Illuminate\Http\Request;

class BulkQuantityController extends Controller
{
    public function storeQuntity(Request $request){
        $request->validate([
            'customer_name' => 'required|max:50',
            'customer_mobile' => 'required|max:15',
            'customer_email' => 'required|max:50',
      
        ]);

        $bulk = new BulkQuantity();
        $bulk->product_id = $request->product_id;
        $bulk->customer_name = $request->customer_name;
        $bulk->customer_mobile = $request->customer_mobile;
        $bulk->customer_email = $request->customer_email;
        $bulk->customer_message = $request->customer_message;
        $bulk->save();
        if($bulk){
            $success = 'successfully submit Bulk Quantity';
        }
        return response()->json($success);
    }

    public function bulkQuntityList(){
        $bulk = BulkQuantity::latest()->get();
        return view('admin.quation.index', compact('bulk'));
    }
}
