<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OfferController extends Controller
{
    public function index(){

        return view('admin.offer.index');
    }
    public function update(Request $request, Offer $offer){
        $offer->minimum_order_amount = $request->minimum_order_amount;
        $offer->save();
        if ($offer) {
            Session::flash('success', 'Information Update Successfully');
            return redirect()->back();
        }
        return redirect()->back();
    }
}
