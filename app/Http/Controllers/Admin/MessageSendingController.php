<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class MessageSendingController extends Controller
{

    public function smsSending()
    {
        $customers = Customer::where('status', 'a')->get();
        return view('admin.sms_sending.sms', compact('customers'));
    }

    public function sms()
    {
        return view('admin.sms_sending.message');
    }
    public function smsSentAll(Request $request){
        try {
            $message = $request->sms;
            $count = count($request->customer_id);
            $customers = Customer::whereIn('id', $request->customer_id)->get();
     
            foreach($customers as $customer){
                $phone = $customer->phone ;
                // $this->send_sms($phone , $message);   
            }
            return back()->with('success','SMS sent successufully');
        } catch (\Throwable $th) {
            return back()->with('error','Minimum one customer select');
        }
       
       
          
    }
}
