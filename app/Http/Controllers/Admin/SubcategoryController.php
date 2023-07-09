<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $category = Category::all();
        $subcategory = SubCategory::latest()->get();
        return view('admin.subcategory.index', compact('category', 'subcategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $subcategory = SubCategory::latest()->get();
        return view('admin.subcategory.list', compact('subcategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|max:50',
            'image' => 'required|Image|mimes:jpg,png,jpeg,bmp',
            'ip_address' => 'max:15'
        ]);
        $unique_check = SubCategory::where('category_id', $request->category_id)->where('name', $request->name)->get();
        if (count($unique_check) > 0) {
            Session::flash('duplicate', 'duplicate founded');
            return redirect()->back();
        } else {
            $slug = Str::slug($request->name . '-' . time());
            $subcategory = new SubCategory();
            $subcategory->category_id = $request->category_id;
            $subcategory->name = $request->name;
            $subcategory->slug = $slug;
            $subcategory->image = $this->imageUpload($request, 'image', 'uploads/subcategory');
            $subcategory->save_by = 1;
            $subcategory->ip_address = $request->ip();
            $subcategory->save();
            if ($subcategory) {
                Session::flash('success', 'subcategory added successfully');
                return redirect()->back();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcategory = SubCategory::find($id);
        $category = Category::all();
        return view('admin.subcategory.edit', compact('category', 'subcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'image' => 'Image|mimes:jpg,png,jpeg,bmp',
        ]);
        $subcategory = SubCategory::find($id);

        $duplicate = SubCategory::where('id', '!=', $id)->where('category_id', $request->category_id)->where('name', $request->name)->get();
        if (count($duplicate) > 0) {
            Session::flash('duplicate', 'duplicate founded');
            return redirect()->back();
        } else {
            $subcategoryImage = '';
            if ($request->hasFile('image')) {
                if (!empty($subcategory->image) && file_exists($subcategory->image)) {
                    unlink($subcategory->image);
                }
                $subcategoryImage = $this->imageUpload($request, 'image', 'uploads/subcategory');
            } else {
                $subcategoryImage = $subcategory->image;
            }

            $slug = Str::slug($request->name) . '-' . time();
            $subcategory->category_id = $request->category_id;
            $subcategory->name = $request->name;
            $subcategory->slug = $slug;
            $subcategory->image = $subcategoryImage;
            $subcategory->updated_by = 1;
            $subcategory->save();
            if ($subcategory) {
                Session::flash('success', 'Subcategory Update Successfully');
                return redirect()->route('subcategory.index');
            } else {
                Session::flash('error', 'Update Fail');
                return redirect()->bacK();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = SubCategory::find($id);

        if (!empty($subcategory->image) && file_exists($subcategory->image)) {
            unlink($subcategory->image);
        }
        $subcategory->delete();
        if ($subcategory) {
            Session::flash('warning', 'Sub Category Delete Successfully');
            return redirect()->back();
        } else {
            Session::flash('error', 'Delete fail');
            return redirect()->back();
        }
    }
}
