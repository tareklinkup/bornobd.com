<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\TryCatch;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $category = Category::get();
        return view('admin.category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $category = Category::latest()->get();
        return view('admin.category.list', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100', Rule::unique('categories')->whereNull('deleted_at')],

            'image' => 'required|max:1000||Image|mimes:jpg,png,jpeg,bmp,webp',
            'ip_address' => 'max:15'
        ]);
        $image = $request->file('image');

        $mainImage  = 'big' . time() . uniqid() . $image->getClientOriginalName();
        $thumbImage = 'thumb-' . time() . uniqid() . $image->getClientOriginalName();
        $smallImage = 'small-' . time() . uniqid() . $image->getClientOriginalName();

        Image::make($image)->resize(546, 564)->save('uploads/category/original/' . $mainImage);
        Image::make($image)->resize(356,350)->save('uploads/category/thumbnail/' . $thumbImage);
        Image::make($image)->resize(100,75)->save('uploads/category/small/' . $smallImage);


        try {
            $slug = Str::slug($request->name . '-' . time());
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $slug;
            $category->is_homepage = $request->is_homepage;
            $category->is_menu = $request->is_menu;
            $category->details = $request->details;
            $category->image = $mainImage;
            $category->thumbimage = $thumbImage;
            $category->smallimage = $smallImage;
            $category->save_by = Auth::user()->id;
            $category->ip_address = $request->ip();
            $category->save();

            if ($category) {
                Session::flash('success', 'Category Added Successfully');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Session::flash('error', 'Opps! Category Added Fail');
            return redirect()->back();
        }
        // dd($request->all());

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
    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return view('admin.category.edit', compact('category'));
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
        // dd($request->all());
        $request->validate([
            'name' => 'max:100',
            'image' => 'Image|mimes:jpg,png,jpeg,bmp,webp',
            'ip_address' => 'max:15'
        ]);
        $category = Category::find($id);
        $duplicate = Category::where('id', '!=', $id)->where('name', $request->name)->get();


        if (count($duplicate) > 0) {
            Session::flash('error', 'Category Already exist');
            return back();
        } else {
            if($request->file('image')){
                $image = $request->file('image');
                if($category->image){
                    @unlink('uploads/category/original/'.$category->image);
                }
                if($category->thumbimage){
                    @unlink('uploads/category/thumbnail/'.$category->thumbimage);
                }
                if($category->smallimage){
                    @unlink('uploads/category/small/'.$category->smallimage);
                }
               
                $mainImage  = 'main' . time() . uniqid() . $image->getClientOriginalName();
                $thumbImage = 'thumb-' . time() . uniqid() . $image->getClientOriginalName();
                $smallImage = 'small-' . time() . uniqid() . $image->getClientOriginalName();
        
                Image::make($image)->resize(546, 564)->save('uploads/category/original/' . $mainImage);
                Image::make($image)->resize(356,350)->save('uploads/category/thumbnail/' . $thumbImage);
                Image::make($image)->resize(100,75)->save('uploads/category/small/' . $smallImage);
            }
            else{
                $mainImage  = $category->image;
                $thumbImage = $category->thumbimage;
                $smallImage = $category->smallimage;
            }

            $slug = Str::slug($request->name . '-' . time());
            $i = 0;
            while (true) {
                if (Category::where('slug', '=', $slug)->exists()) {
                    $i++;
                    $slug .= '_' . $i;
                    continue;
                }
                break;
            }
            $category->name = $request->name;
            $category->slug = $slug;
            $category->is_homepage = $request->is_homepage;
            $category->is_menu = $request->is_menu;
            $category->details = $request->details;
            $category->updated_by = Auth::user()->user_id;;
            $category->ip_address = $request->ip();
            $category->image = $mainImage;
            $category->thumbimage = $thumbImage;
            $category->smallimage = $smallImage;
            $category->save();
            if ($category) {
                Session::flash('success', 'Category Update Successfully');
                return redirect()->route('category.index');
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
    public function destroy(Category $category)
    {
        $product = Product::where('category_id', $category->id)->count();
        $sub = SubCategory::where('category_id', $category->id)->count();
        if ($product > 0 OR $sub > 0) {
            Session::flash('delete_check', 'Delete First dependency subcategory or product');
            return back();
        } else {
            if($category->image){
                @unlink('uploads/category/original/'.$category->image);
            }
            if($category->thumbimage){
                @unlink('uploads/category/thumbnail/'.$category->thumbimage);
            }
            if($category->smallimage){
                @unlink('uploads/category/small/'.$category->smallimage);
            }
            $category->delete();
            if ($category) {
                Session::flash('delete', 'Category Delete Successfully');
                return redirect()->back();
            } else {
                Session::flash('error', 'Delete fail');
                return redirect()->back();
            }
        }
    }

    public function  test()
    {
        return 'hlw';
    }
}
