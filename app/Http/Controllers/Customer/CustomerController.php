<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DeliveryCharge;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{

    public function customer()
    {
        if (Auth::guard('customer')->check()) {
            Session::flash('message', 'You have already login');
            return redirect()->route('customer.dashboard');
        } else {
            return view('website.customer.login');
        }
    }
   
    public function AuthCheck(Request $request)
    {

        $request->validate([
            'password' => 'required',
        ]);
        $credential = $request->only('password');
        $credential['phone'] = $request->phone;
        $redirect_url = session('redirect_url');
        if (Auth::guard('customer')->attempt($credential)) {
            session()->flash('message', 'Login Successfully !');
            $redirect_url = route('customer.dashboard');
            if(session()->has('redirect_url')){
                $redirect_url = session('redirect_url');
                session()->forget('redirect_url');
                return redirect()->to($redirect_url);
            }
           
            else{
                return redirect($redirect_url);
            }
            
        } else {
            Session::flash('error', 'Mobile number or password not match');
            return redirect()->back();
        }
    }


    public function signUp()
    {
        if (Auth::guard('customer')->check()) {
            Session::flash('message', 'You have already login');
            return redirect()->route('checkout.user');
        } else {
            return view('website.customer.signup');
        }
    }


    public function customerForm()
    {
        return view('website.customer.signup');
    }

    public function customerStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|min:3|max:100',
            'phone' => 'required|unique:customers|regex:/^01[13-9][\d]{8}$/|min:11',
            'password' => 'required|string|same:cpassword|min:1',
            'address' => 'required',
            'ip_address' => 'max:15'
        ]);
       
       try {
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
            Auth::guard('customer')->login($customer);
            return redirect()->route('customer.dashboard');
            Session::flash('success', 'Registration Successfully');
       } catch (\Throwable $th) {
          
           return redirect()->back();
           Session::flash('error', 'Registration Faild');
       }
       
    }


    public function customerPasswordUpdate(Request $request)
    {
        if (Auth::guard('customer')->check()) {
            $request->validate([
                'currentPass' => 'required',
                'password' => 'required|confirmed|min:2',
            ]);
            $currentPassword = Auth::guard('customer')->user()->password;
            if (Hash::check($request->currentPass, $currentPassword)) {
                if (!Hash::check($request->password, $currentPassword)) {
                    $customer = Customer::find(Auth::guard('customer')->id());
                    $customer->password = HasH::make($request->password);
                    $customer->save();
                    if ($customer) {
                        Auth::guard('customer')->logout();
                        Session::flash('success', 'Password Update Successfully');
                        return back();
                    } else {
                        Session::flash('error', 'Current password not match');
                        return back();
                    }
                } else {
                    Session::flash('error', 'Same as Current password');
                    return back();
                }
            } else {
                Session::flash('error', '!Current password not match');
                return back();
            }
        }
        else {
            return redirect()->route('home.index');
        }
    
    }



    public function customerPanel()
    {
        if (Auth::guard('customer')->check()) {
                $order = Order::with('orderDetails')->where('customer_id', Auth::guard('customer')->user()->id)->latest()->get();
            return view('website.customer.dashboard', compact('order'));
        } else {
            return redirect()->route('home.index');
        }
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        Session::flash('error', 'Logout Successfully');
        return redirect()->route('home.index');
    }

    public function getCharge(Request $request){
        $charge = DeliveryCharge::where('id',$request->area_id)->first();
        return response()->json($charge->charge);
    }
}
