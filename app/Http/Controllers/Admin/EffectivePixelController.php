<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\EffectivePixel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class EffectivePixelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $effective_pixel = EffectivePixel::latest()->get();
        return view('admin.effective_pixel.index', compact('effective_pixel'));
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
            'name' => ['required','max:100','unique:effective_pixels'],

        ]);
       

        try {
           
            $effective_pixel = new EffectivePixel();
            $effective_pixel->name = $request->name;
            
            $effective_pixel->save();

            if ($effective_pixel) {
                Session::flash('success', 'Effective Pixel Added Successfully');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Session::flash('error', 'Opps! Effective Pixel Added Fail');
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
        $effective_pixel = EffectivePixel::where('id', $id)->first();
        return view('admin.effective_pixel.edit', compact('effective_pixel'));
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
            'name' => 'max:100|unique:effective_pixels,id',
        ]);
        $effective_pixel = EffectivePixel::find($id);
        $effective_pixel->name = $request->name;
        $effective_pixel->save();
        return redirect()->route('effective_pixel.index')->with('success','Effective Pixel Updated Successfully');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $effective_pixel = EffectivePixel::where('id',$id)->first();
         $product = Product::where('effective_pixel_id', $effective_pixel->id)->count();
        if ($product > 0 ) {
            Session::flash('delete_check', 'Delete First dependency product');
            return back();
        } else {
          
            $effective_pixel->delete();
            if ($effective_pixel) {
                Session::flash('delete', 'Effective Pixel Delete Successfully');
                return redirect()->back();
            } else {
                Session::flash('error', 'Delete fail');
                return redirect()->back();
            }
        }
    }
}
