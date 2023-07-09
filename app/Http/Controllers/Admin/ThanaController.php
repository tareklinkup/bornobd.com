<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\District;
use App\Models\Thana;
use Illuminate\Http\Request;

class ThanaController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thanas = Thana::all();
        $district = District::all();
        return view('admin.thana.index', compact('thanas','district'));
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
        $request->validate([
            'name' => 'required|max:50',
        ]);
        $thana = new Thana();
        $thana->name = $request->name;
        $thana->district_id = $request->district_id;
        $thana->save();
        return back()->with('success', 'Area Inserted Successfully');
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
        $district = District::all();
        $thana = Thana::where('id',$id)->first();
        return view('admin.thana.edit', compact('thana','district'));
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
        $this->validate($request, [
            'name'          => 'required',
        ]);
        $thana = Thana::find($id);
        $thana->name = $request->name;
        $thana->district_id = $request->district_id;
        $thana->save();
        return redirect()->route('thana.index')->with('success', 'Thana updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $area_id = Area::where('thana_id',$id)->count();
        if($area_id > 0){
            return back()->with('error', 'First Delete Area');
        }
        else{
            Thana::where('id', $id)->delete();
            return back()->with('success', 'Area Deleted successfully');
        }
       
        
    }

    
}
