<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Subsubcategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SubsubcategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        $SubCategory = SubCategory::get();
        $subsubcategory = Subsubcategory::where('status', 'a')->get();
        return view('admin.subsubcategory.index',compact('category','SubCategory', 'subsubcategory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'name' => 'required|max:50',
        ]);
      
            $slug = Str::slug($request->name . '-' . time());
            $subsubcategory = new Subsubcategory();
            $subsubcategory->category_id = $request->category_id;
            $subsubcategory->sub_category_id = $request->sub_category_id;
            $subsubcategory->name = $request->name;
            $subsubcategory->slug = $slug;
            $subsubcategory->save_by = 1;
            $subsubcategory->ip_address = $request->ip();
            $subsubcategory->save();
            if ($subsubcategory) 
            {
                Session::flash('success', 'subsubcategory added successfully');
                return redirect()->back();
             }
    }

    public function edit($id)
    {
     $category = Category::all();
     $subCategory = SubCategory::all();
     $subsubcategory = Subsubcategory::find($id);
     return view('admin.subsubcategory.edit', compact('category', 'subCategory', 'subsubcategory'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'name' => 'required',
        ]);

        $subsubcategory = Subsubcategory::find($id);
           
            $slug = Str::slug($request->name) . '-' . time();
            $subsubcategory->category_id = $request->category_id;
            $subsubcategory->sub_category_id = $request->sub_category_id;
            $subsubcategory->name = $request->name;
            $subsubcategory->slug = $slug;
            $subsubcategory->updated_by = 1;
            $subsubcategory->save();
            if ($subsubcategory) {
                Session::flash('success', 'Sub Subcategory Update Successfully');
                return redirect()->route('subsubcategory.index');
            } else {
                Session::flash('error', 'Update Fail');
                return redirect()->bacK();
            }
        
    }

    public function delete($id)
    {
        $subsubcategory = Subsubcategory::find($id);
        $subsubcategory->delete();
        if ($subsubcategory) {
            Session::flash('warning', 'Sub Subcategory Delete Successfully');
            return redirect()->back();
        } else {
            Session::flash('error', 'Delete failed');
            return redirect()->back();
        }
    }

    public function list()
    {
        $subsubcategory = Subsubcategory::where('status','a')->get();
    return view('admin.subsubcategory.list',compact('subsubcategory'));
    }

  
}
