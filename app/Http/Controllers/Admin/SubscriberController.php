<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{

    public function index()
    {
        $subscriber = Subscriber::latest()->get();
        return view('admin.subscriber.index', compact('subscriber'));
    }

    public function subscriberList(Request $request)
    {
        //    dd($request->all());
        $request->validate([
            'name' => 'max:50',
            'phone' => 'max:15',
            'email' => 'required|max:40',
            'ip_address' => 'max:15'
        ]);

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->ip_address = $request->ip();
        $subscriber->save();
        if ($subscriber) {
            session()->flash('success', 'Successfully Subscribe');
            return redirect()->back();
        } else {
            session()->flash('error', 'Subscribe fail');
            return redirect()->back();
        }
    }
}
