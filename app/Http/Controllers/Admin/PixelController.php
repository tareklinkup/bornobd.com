<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pixel;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PixelController extends Controller
{
    public function index()
    {
        $pixel = Pixel::latest()->get();
        return view('admin.pixel.index', compact('pixel'));
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
            'name' => ['required','max:100','unique:pixels'],

        ]);
       

        try {
           
            $pixel = new Pixel();
            $pixel->name = $request->name;
            
            $pixel->save();

            if ($pixel) {
                Session::flash('success', 'pixel Added Successfully');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Session::flash('error', 'Opps! pixel Added Fail');
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
        $brand = Pixel::where('id', $id)->first();
        return view('admin.pixel.edit', compact('pixel'));
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
        $brand = Pixel::find($id);
        $brand->name = $request->name;
        $brand->save();
        return redirect()->route('brand.index')->with('success','pixel Updated Successfully');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pixel = Pixel::where('id',$id)->first();
         $product = Product::where('category_id', $pixel->id)->count();
        if ($product > 0 ) {
            Session::flash('delete_check', 'Delete First dependency product');
            return back();
        } else {
          
            $pixel->delete();
            if ($pixel) {
                Session::flash('delete', 'pixel Delete Successfully');
                return redirect()->back();
            } else {
                Session::flash('error', 'Delete fail');
                return redirect()->back();
            }
        }
    }
}
