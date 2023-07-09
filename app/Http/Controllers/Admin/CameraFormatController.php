<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\CameraFormat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CameraFormatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $camera_format = CameraFormat::latest()->get();
        return view('admin.camera_format.index', compact('camera_format'));
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
            'name' => ['required','max:100','unique:camera_formats'],

        ]);
       

        try {
           
            $camera_format = new CameraFormat();
            $camera_format->name = $request->name;
            
            $camera_format->save();

            if ($camera_format) {
                Session::flash('success', ' Camera Format Added Successfully');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Session::flash('error', 'Opps! Camera Format Added Fail');
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
        $camera_format = CameraFormat::where('id', $id)->first();
        return view('admin.camera_format.edit', compact('camera_format'));
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
            'name' => 'max:100|unique:camera_formats,id',
        ]);
        $brand = CameraFormat::find($id);
        $brand->name = $request->name;
        $brand->save();
        return redirect()->route('camera_format.index')->with('success','Brand Updated Successfully');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $camera_format = CameraFormat::where('id',$id)->first();
         $product = Product::where('camera_format_id', $camera_format->id)->count();
        if ($product > 0 ) {
            Session::flash('delete_check', 'Delete First dependency product');
            return back();
        } else {
          
            $camera_format->delete();
            if ($camera_format) {
                Session::flash('delete', 'Camera Format Delete Successfully');
                return redirect()->back();
            } else {
                Session::flash('error', 'Delete fail');
                return redirect()->back();
            }
        }
    }
}
