<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Subsubcategory;
use App\Models\AnotherCategory;
use Psy\CodeCleaner\ReturnTypePass;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AnotherCategoryController extends Controller
{

    public function index()
    {   
        $category = Category::all();
        $SubCategory = SubCategory::all();
        $SubsubCategory = Subsubcategory::all();
        $anotherCategory = AnotherCategory::where('status', 'a')->get();
        return view('admin.anotherCategory.index', compact('category', 'SubCategory', 'SubsubCategory', 'anotherCategory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'subsubcategory_id' => 'required',
            'name' => 'required|max:50',
        ]);
        $slug = Str::slug($request->name . '-' . time());
        $anotherCategory = new AnotherCategory();
        $anotherCategory->category_id = $request->category_id;
        $anotherCategory->sub_category_id = $request->sub_category_id;
        $anotherCategory->subsubcategory_id = $request->subsubcategory_id;
        $anotherCategory->name = $request->name;
        $anotherCategory->slug = $slug;
        $anotherCategory->save_by = 1;
        $anotherCategory->ip_address = $request->ip();
        $anotherCategory->save();
        if ($anotherCategory) 
        {
            Session::flash('success', 'Another Category added successfully');
            return redirect()->back();
         }
    }

    public function edit($id)
    {
     $category = Category::all();
     $subCategory = SubCategory::all();
     $subsubcategory = Subsubcategory::all();
     $anotherCategory = AnotherCategory::find($id);
     return view('admin.anotherCategory.edit', compact('category', 'subCategory', 'subsubcategory','anotherCategory'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'name' => 'required',
        ]);

        $anotherCategory = AnotherCategory::find($id);
           
            $slug = Str::slug($request->name) . '-' . time();
            $anotherCategory->category_id = $request->category_id;
            $anotherCategory->sub_category_id = $request->sub_category_id;
            $anotherCategory->subsubcategory_id = $request->subsubcategory_id;
            $anotherCategory->name = $request->name;
            $anotherCategory->slug = $slug;
            $anotherCategory->updated_by = 1;
            $anotherCategory->save();
            if ($anotherCategory) {
                Session::flash('success', 'Another Category Update Successfully');
                return redirect()->route('anotherCategory.index');
            } else {
                Session::flash('error', 'Update Fail');
                return redirect()->bacK();
            }
    }

    public function delete($id)
    {
        $anotherCategory = AnotherCategory::find($id);
        $anotherCategory->delete();
        if ($anotherCategory) {
            Session::flash('warning', 'Another Category Delete Successfully');
            return redirect()->back();
        } else {
            Session::flash('error', 'Delete failed');
         }
    }

    public function list()
    {
        $anotherCategory = AnotherCategory::where('status','a')->get();
    return view('admin.anotherCategory.list',compact('anotherCategory'));
    }

}
