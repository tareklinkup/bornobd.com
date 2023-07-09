<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $brand = Brand::latest()->get();
        return view('admin.brand.index', compact('brand'));
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
            'name' => ['required','max:100','unique:brands'],

        ]);
       

        try {
           
            $brand = new Brand();
            $brand->name = $request->name;
            
            $brand->save();

            if ($brand) {
                Session::flash('success', 'Brand Added Successfully');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Session::flash('error', 'Opps! Brand Added Fail');
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
    public function edit($id)
    {
        $brand = Brand::where('id', $id)->first();
        return view('admin.brand.edit', compact('brand'));
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
            'name' => 'max:100|unique:brands,id',
        ]);
        $brand = Brand::find($id);
        $brand->name = $request->name;
        $brand->save();
        return redirect()->route('brand.index')->with('success','Brand Updated Successfully');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::where('id',$id)->first();
         $product = Product::where('category_id', $brand->id)->count();
        if ($product > 0 ) {
            Session::flash('delete_check', 'Delete First dependency product');
            return back();
        } else {
          
            $brand->delete();
            if ($brand) {
                Session::flash('delete', 'Brand Delete Successfully');
                return redirect()->back();
            } else {
                Session::flash('error', 'Delete fail');
                return redirect()->back();
            }
        }
    }
}
