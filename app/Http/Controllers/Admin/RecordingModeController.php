<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RecordingMode;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class RecordingModeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $recording_mode = RecordingMode::latest()->get();
        return view('admin.recording_mode.index', compact('recording_mode'));
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
            'name' => ['required','max:100','unique:recording_modes'],

        ]);
       

        try {
           
            $brand = new RecordingMode();
            $brand->name = $request->name;
            
            $brand->save();

            if ($brand) {
                Session::flash('success', 'Recording Mode Added Successfully');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Session::flash('error', 'Opps! Recording Mode Added Fail');
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
        $recording_mode = RecordingMode::where('id', $id)->first();
        return view('admin.recording_mode.edit', compact('recording_mode'));
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
            'name' => 'max:100|unique:recording_modes,id',
        ]);
        $recording_mode = RecordingMode::find($id);
        $recording_mode->name = $request->name;
        $recording_mode->save();
        return redirect()->route('recording_mode.index')->with('success','Recording Mode Updated Successfully');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recording_mode = RecordingMode::where('id',$id)->first();
         $product = Product::where('recording_mode_id', $recording_mode->id)->count();
        if ($product > 0 ) {
            Session::flash('delete_check', 'Delete First dependency product');
            return back();
        } else {
          
            $recording_mode->delete();
            if ($recording_mode) {
                Session::flash('delete', 'Recording Mode Delete Successfully');
                return redirect()->back();
            } else {
                Session::flash('error', 'Delete fail');
                return redirect()->back();
            }
        }
    }
}
