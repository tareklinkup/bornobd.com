<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreLocation;
use Illuminate\Http\Request;

class StoreLocationController extends Controller
{
    public function index(){
        $store = StoreLocation::latest()->get();
        return view('admin.store.index', compact('store'));
    }


    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:150',
            'phone' => 'required|max:15',
            'address' => 'required|max:150',
            'location' => 'required|max:150',
            'close_day' => 'max:150',

        ]);

        $store = new StoreLocation();
        $store->name = $request->name;
        $store->phone = $request->phone;
        $store->address = $request->address;
        $store->location = $request->location;
        $store->open_hour = $request->open_hour;
        $store->close_day = $request->close_day;
        $store->save();
        return redirect()->route('store.index')->with('success', 'Successfully save Sotre Location');
    }

    public function edit($id){
        $store = StoreLocation::find($id);
        return view('admin.store.edit', compact('store'));
    }


    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|max:150',
            'phone' => 'required|max:15',
            'address' => 'required|max:150',
            'location' => 'required|max:150',
            'close_day' => 'max:150',

        ]);

        $store = StoreLocation::find($id);
        $store->name = $request->name;
        $store->phone = $request->phone;
        $store->address = $request->address;
        $store->location = $request->location;
        $store->close_day = $request->close_day;
        $store->open_hour = $request->open_hour;
        $store->save();
        return redirect()->route('store.index')->with('success', 'Successfully Updated Sotre Location');
    }

    public function destroy($id){
        $store = StoreLocation::find($id);
        $store->delete();
        if($store){
            return redirect()->route('store.index')->with('success', 'Successfully Delete Sotre Location'); 
        }
    }
}
