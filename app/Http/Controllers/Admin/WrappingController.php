<?php

namespace App\Http\Controllers\Admin;

use App\Models\Wrapping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class WrappingController extends Controller
{
    public function index()
    {
        $wrapper = Wrapping::latest()->get();
        return view('admin.wrapping.index', compact('wrapper'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'price' => 'required',
            'image' => 'required|Image|mimes:jpg,png,jpeg,bmp,gif',
        ]);

        $wrapper = new Wrapping();
        $wrapper->name = $request->name;
        $wrapper->price = $request->price;
        $wrapper->details = $request->details;
        $wrapper->image = $this->imageUpload($request, 'image', 'uploads/wrapper') ?? '';

        $wrapper->save();
        if ($wrapper) {
            Session::flash('success', 'Successfully save');
            return back();
        } else {
            Session::flash('errors', 'something went wrong');
        }
        return redirect()->back();
    }

    public function edit($id)
    {
        $wrapper = Wrapping::find($id);
        return view('admin.wrapping.edit', compact('wrapper'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'price' => 'required',
            'image' => 'Image|mimes:jpg,png,jpeg,bmp,gif',
        ]);

        $wrapper = Wrapping::find($id);
        $Image = '';
        if ($request->hasFile('image')) {
            if (!empty($wrapper->image) && file_exists($wrapper->image)) {
                unlink($wrapper->image);
            }
            $Image = $this->imageUpload($request, 'image', 'uploads/wrapper');
        } else {
            $Image = $wrapper->image;
        }
        $wrapper->name = $request->name;
        $wrapper->price = $request->price;
        $wrapper->details = $request->details;
        $wrapper->image = $Image;

        $wrapper->save();
        if ($wrapper) {
            Session::flash('success', 'Successfully save');
            return redirect()->route('wrapping.index');
        } else {
            Session::flash('errors', 'something went wrong');
        }
        return redirect()->back();
    }


    public function delete($id)
    {
        $wrapper = Wrapping::find($id);
        
        if ($wrapper->image) {
            unlink($wrapper->image);
        }
        $wrapper->delete();
        return redirect()->route('wrapping.index')->with('success', 'Deleted Successfully');
    }
}
