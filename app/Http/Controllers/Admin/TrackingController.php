<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tracking;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class TrackingController extends Controller
{
    public function index(){
        $track = Tracking::latest()->get();
        return view('admin.tracking.index', compact('track'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:50',
            'link' => 'required|max:250'
        ]);
        $track = new Tracking();
        $track->name = $request->name;
        $track->link = $request->link;
        $track->details = $request->details;
        $track->save();
        if($track){
            return redirect()->back()->with('success', 'Save Successfully');
        }else{
            return redirect()->back()->with('error', 'Opps Something went wrong');
        }
    }

    public function edit($id){
        $track = Tracking::find($id);
        return view('admin.tracking.edit', compact('track'));
    }

    public function update(Request $request,  $id){
        $request->validate([
            'name' => 'required|max:50',
            'link' => 'required|max:250'
        ]);
        $track = Tracking::find($id);
        $track->name = $request->name;
        $track->link = $request->link;
        $track->details = $request->details;
        $track->save();
        if($track){
            return redirect()->route('tracking.index')->with('success', 'update Successfully');
        }else{
            return redirect()->back()->with('error', 'Opps Something went wrong');
        }
    }



    public function destroy($id){
        $track = Tracking::find($id);
        $track->delete();
        if($track){
             return redirect()->back()->with('success', 'Delete successfully');
        }else{
            return redirect()->back()->with('success', 'Delete fail');
        }
    }
}
