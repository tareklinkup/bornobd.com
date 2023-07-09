<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\DeliveryCharge;
use App\Models\District;
use App\Models\Thana;
use App\Models\Upazila;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['delivery_charge'] = DeliveryCharge::all();
        $data['district'] = District::all();
        return view('admin.area.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'charge' => 'required',
            'area'  => 'required|unique:delivery_charges'
        ]);
        try {

            $charge = new DeliveryCharge();
            $charge->area   = $request->area;
            $charge->charge = $request->charge;
            $charge->save();
            return back()->with('success', 'Charge inserted successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Ooops! Something Errors');
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
        $data['delivery_charge'] = DeliveryCharge::find($id);
        return view('admin.area.edit', $data);
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
            'charge' => 'required',
            'area'   => 'required|unique:delivery_charges,id'
        ]);
        $charge = DeliveryCharge::find($id);
        $charge->area   = $request->area;
        $charge->charge = $request->charge;
        $charge->save();
        return redirect()->route('area.index')->with('success', 'Area updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy($id)
    {
        DeliveryCharge::where('id', $id)->delete();
        return back()->with('success', 'Area Deleted successfully');
    }
    public function change(Request $request)
    {
        $area = Area::where('id', $request->area_id)->first();
        $charge = $area->amount;
        return response()->json($charge);
    }
}
