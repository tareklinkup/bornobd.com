<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Gd\Shapes\CircleShape;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $services = Service::latest()->get();
        return view('admin.service.index', compact('services'));
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
        // return json_encode($request->all());
        $request->validate([
            'title' => 'required|string|max:100',
            'image' => 'required|Image|mimes:jpg,png,jpeg,bmp,gif',

        ]);
        $service = new Service();
        $service->title = $request->title;
        $service->short_details = $request->short_details;
        $service->details = $request->details;
        $service->image = $this->imageUpload($request, 'image', 'uploads/service') ?? '';
        $service->save_by = 1;
        $service->ip_address = $request->ip();
        $service->save();
        if ($service) {
            Session::flash('status', 'success');
            return back();
        } else {
            Session::flash('errors', 'something went wrong');
        }
        return redirect()->back();
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
        $service = Service::where('id', $id)->first();
        return view('admin.service.edit', compact('service'));
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
        $request->validate([
            'title' => 'required|string|max:100',
            'image' => 'Image|mimes:jpg,png,jpeg,bmp,gif|dimensions:min_width=100,min_height=200',

        ]);
        $Image = '';

        $service = Service::where('id', $id)->first();
        if ($request->hasFile('image')) {
            if (!empty($service->image) && file_exists($service->image)) {
                unlink($service->image);
            }
            $Image = $this->imageUpload($request, 'image', 'uploads/service');
        } else {
            $Image = $service->image;
        }

        $service->title = $request->title;
        $service->short_details = $request->short_details;
        $service->details = $request->details;
        $service->image = $Image;
        $service->save_by = 1;
        $service->ip_address = $request->ip();
        $service->save();
        if ($service) {
            return redirect()->route('service.index')->with('success', 'Service updated successfully');
        } else {
            return back()->with('error', 'Update Fail!');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::where('id', $id)->first();
        if ($service->image) {
            @unlink($service->image);
        }
        $service->delete();
        return redirect()->route('service.index')->with('success', 'Service Deleted Successfully');
    }
}
