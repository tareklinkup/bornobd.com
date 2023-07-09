<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sensor;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SensorController extends Controller
{
   


   public function index()
   {
       $sensor = Sensor::latest()->get();
       return view('admin.sensor.index', compact('sensor'));
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
           'name' => ['required','max:100','unique:sensors'],

       ]);
      

       try {
          
           $sensor = new Sensor();
           $sensor->name = $request->name;
           $sensor->save();

           if ($sensor) {
               Session::flash('success', 'Sensor Added Successfully');
               return redirect()->back();
           }
       } catch (\Throwable $th) {
           Session::flash('error', 'Opps! Sensor Added Fail');
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
       $sensor = Sensor::where('id', $id)->first();
       return view('admin.sensor.edit', compact('sensor'));
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
           'name' => 'max:100|unique:sensors,id',
       ]);
       $sensor = Sensor::find($id);
       $sensor->name = $request->name;
       $sensor->save();
       return redirect()->route('sensor.index')->with('success','Sensor Updated Successfully');

       
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       $sensor = Sensor::where('id',$id)->first();
        $product = Product::where('sensor_id', $sensor->id)->count();
       if ($product > 0 ) {
           Session::flash('delete_check', 'Delete First dependency product');
           return back();
       } else {
         
           $sensor->delete();
           if ($sensor) {
               Session::flash('delete', 'Sensor Delete Successfully');
               return redirect()->back();
           } else {
               Session::flash('error', 'Delete fail');
               return redirect()->back();
           }
       }
   }
}
