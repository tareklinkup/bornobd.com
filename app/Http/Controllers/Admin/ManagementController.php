<?php

namespace App\Http\Controllers\Admin;

use App\Models\Managment;
use App\Models\Management;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $management = Management::orderBy('rank', 'asc')->get();
        return view('admin.management.index', compact('management'));
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
            'name' => 'required|string|max:100',
            'rank' => 'required|unique:management',
            'designation' => 'required|string|max:50',
            'image' => 'required|Image|mimes:jpg,png,jpeg,bmp',
            'ip_address' => 'max:15'
        ]);

        $management = new Management();
        $management->name = $request->name;
        $management->rank = $request->rank;
        $management->designation = $request->designation;
        $management->department = $request->department;
        $management->description = $request->description;
        $management->designation = $request->designation;
        $management->image = $this->imageUpload($request, 'image', 'uploads/management') ?? '';
        $management->save_by = 1;
        $management->ip_address = $request->ip();
        $management->save();

        if ($management) {
            Session::flash('success', 'Management Member Added Successfully');
            return back();
        } else {
            Session::flash('errors', ' something went wrong');
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
    public function edit(Management $management)
    {
        return view('admin.management.edit', compact('management'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Management $management)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            // 'rank' => 'required',
            'designation' => 'required|string|max:50',
            'image' => 'Image|mimes:jpg,png,jpeg,bmp',
            'ip_address' => 'max:15'
        ]);

        $managementImage = '';
        if ($request->hasFile('image')) {
            if (!empty($management->image) && file_exists($management->image)) {
                unlink($management->image);
            }
            $managementImage = $this->imageUpload($request, 'image', 'uploads/management');
        } else {
            $managementImage = $management->image;
        }
        $management->name = $request->name;
        $management->designation = $request->designation;
        $management->department = $request->department;
        $management->description = $request->description;
        $management->updated_by = 1;
        $management->ip_address = $request->ip();
        $management->image = $managementImage;
        $management->rank = $request->rank;
    
        $management->save();

        if ($management) {
            Session::flash('success', 'Management Member Updated Successfully');
            return redirect()->route('management.index');
        } else {
            Session::flash('errors', ' something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Management $management)
    {
        if (!empty($management->image) && file_exists($management->image)) {
            unlink($management->image);
        }
        $management->delete();
        if ($management) {
            Session::flash('warning', 'Delete Success');
            return redirect()->back();
        } else {
            Session::flash('errors', 'something went wrong');
            return redirect()->back();
        }
    }
}
