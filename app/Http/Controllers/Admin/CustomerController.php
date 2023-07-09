<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class CustomerController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        return view('admin.customer.index', compact('areas'));
    }
    public function allData()
    {
        $customers = Customer::latest()->get();
        return response()->json($customers);
    }
    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:customers|max:50',
            'phone' => 'required|unique:customers|max:11',
            'address' => 'required',
            // 'username' => 'required|unique:customers|max:20',
            'password' => 'required|max:100',
            'ip_address' => 'max:15',
            'profile_picture' => 'required'
        ]);

        $customer = new Customer();
        $code = 'C' . $this->generateCode('Customer');
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->area_id = $request->area_id;
        $customer->username = $request->phone;
        $customer->membership_discount = $request->membership_discount;
        $customer->password = Hash::make($request->password);
        $customer->ip_address = $request->ip();
        $customer->code = $code;
        $customer->status = 'a';
        $customer->save_by = 2;
        $customer->updated_by = 2;
        // $customer->profile_picture = $this->imageUpload($request, 'profile_picture', 'uploads/customer');

        $Image = $request->file('profile_picture');

        $newImage = rand(0000, 9999) . $Image->getClientOriginalName();
        $thumb_image = rand(0000, 9999) . $Image->getClientOriginalName();
        Image::make($Image)->save('uploads/customer/' . $newImage);
        Image::make($Image)->resize(100, 100)->save('uploads/customer/' . $thumb_image);

        $customer->profile_picture = $newImage;
        $customer->thum_picture = $thumb_image;
        $customer->save();
        $data['success'] = 'Data Added Successfully';
        $data['error'] = 'Customer added fail';
        if($customer){
            return response()->json($data); 
        }
        else{
            return response()->json($data);
        }
        
    }
    public function edit($id)
    {
        $customer = Customer::find($id)->toArray();
        $customer['profile_picture'] = asset('uploads/customer/' . $customer['profile_picture']);
        return response()->json($customer);
    }

    public function update(Request $request)
    {
        //   dd($request->all());
        $this->validate($request, [
            'name' => 'required|max:100',
            'phone' => 'required|unique:customers,id|max:11',
            'address' => 'required',
            'ip_address' => 'max:17'
        ]);

        $customerImage = '';
        $customer = Customer::where('id', $request->id)->first();
        if ($request->hasFile('profile_picture')) {
            $image_path = public_path('uploads/customer/' . $customer->profile_picture);
            $image_path_thumb = public_path('uploads/customer/' . $customer->thum_picture);
            if (file_exists($image_path)) {
                @unlink($image_path);
                $Image = $request->file('profile_picture');
                $newImage = rand(0000, 9999) . $Image->getClientOriginalName();
                Image::make($Image)->save('uploads/customer/' . $newImage);
                $customer->profile_picture = $newImage;
            }
            if (file_exists($image_path_thumb)) {
                @unlink($image_path_thumb);
                $Image = $request->file('profile_picture');
                $newImage = rand(0000, 9999) . $Image->getClientOriginalName();
                Image::make($Image)->save('uploads/customer/' . $newImage);
                $customer->thum_picture = $newImage;
            }
        }
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->membership_discount = $request->membership_discount;
        $customer->area_id = $request->area_id;
        $customer->save();
        return response()->json($customer);
    }
    public function destroy($id)
    {
        $customer = Customer::where('id', $id)->first();
        $image_path = public_path('uploads/customer/' . $customer->profile_picture);
        $image_path_thumb = public_path('uploads/customer/' . $customer->thum_picture);
        if (file_exists($image_path)) {
            @unlink($image_path);
        }
        if (file_exists($image_path_thumb)) {
            @unlink($image_path_thumb);
        }
        $customer->delete();
        $data = "Data Deleted Successfully";
        return response()->json($data);
    }
    // pending
    public function pending()
    {
        $customers = Customer::where('status', '=', 'g')->get();
        return view('admin.customer.pending', compact('customers'));
    }
    // active
    public function authorizeCustomer($id)
    {
        Customer::where('id', $id)->where('status', 'g')->update([
            'status' => 'p',
        ]);

        return back()->with('success', 'Move to  Authorize Customer.');
    }
    public function customerActive($id)
    {
        Customer::where('id', $id)->where('status', 'p')->update([
            'status' => 'a',
        ]);

        return back()->with('success', 'Move to  Membership Customer.');
    }
    // deactive
    public function customerDeactive($id)
    {
        Customer::where('id', $id)->where('status', 'a')->update([
            'status' => 'p',
        ]);

        return back()->with('success', 'Move to General Customer.');
    }
    // customer list
    public function customerList()
    {
        $customers = Customer::latest()->get();
        return view('admin.customer.list', compact('customers'));
    }
}
