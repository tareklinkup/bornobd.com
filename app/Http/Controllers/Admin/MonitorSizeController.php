<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\MonitorSize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class MonitorSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $monitor_size = MonitorSize::latest()->get();
        return view('admin.monitor_size.index', compact('monitor_size'));
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
            'name' => ['required','max:100','unique:monitor_sizes'],

        ]);
       
        try {
           
            $monitor_size = new MonitorSize();
            $monitor_size->name = $request->name;
            $monitor_size->save();

            if ($monitor_size) {
                Session::flash('success', 'Monitor Size Added Successfully');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Session::flash('error', 'Opps! Monitor Size Added Fail');
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
        $monitor_size = MonitorSize::where('id', $id)->first();
        return view('admin.monitor_size.edit', compact('monitor_size'));
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
            'name' => 'max:100|unique:monitor_sizes,id',
        ]);
        $brand = MonitorSize::find($id);
        $brand->name = $request->name;
        $brand->save();
        return redirect()->route('monitor_size.index')->with('success','Monitor Size Updated Successfully');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $monitor_size = MonitorSize::where('id',$id)->first();
         $product = Product::where('monitor_size_id', $monitor_size->id)->count();
        if ($product > 0 ) {
            Session::flash('delete_check', 'Delete First dependency product');
            return back();
        } else {
          
            $monitor_size->delete();
            if ($monitor_size) {
                Session::flash('delete', 'Monitor Size Delete Successfully');
                return redirect()->back();
            } else {
                Session::flash('error', 'Delete fail');
                return redirect()->back();
            }
        }
    }
}
