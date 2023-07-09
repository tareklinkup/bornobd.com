<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partner = Partner::all();
        return view('admin.partner.index', compact('partner'));
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
            'name'       => 'required', 'max:60',
            'image'      => 'required|max:1024||Image|mimes:jpg,png,jpeg,bmp',
            'details_image'      => 'max:1024||Image|mimes:jpg,png,jpeg,bmp',
            'ip_address' => 'max:15'
        ]);
        $partner             = new Partner();
        $partner->name       = $request->name;
        $partner->details       = $request->details;
        $partner->image      = $this->imageUpload($request, 'image', 'uploads/partner');
        $partner->details_image      = $this->imageUpload($request, 'details_image', 'uploads/partner');
        $partner->save_by    = Auth::user()->id;
        $partner->ip_address = $request->ip();
        $partner->save();
        return back()->with('success', 'partner added successfully');
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
        $partner = Partner::where('id', $id)->first();
        return view('admin.partner.edit', compact('partner'));
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
        //
        $request->validate([
            'name'       => 'required', 'max:60',
            'image'      => 'max:1024||Image|mimes:jpg,png,jpeg,bmp',
            'details_image'      => 'max:1024||Image|mimes:jpg,png,jpeg,bmp',
            'ip_address' => 'max:15'
        ]);


        $partner   = Partner::where('id', $id)->first();
        $Image = '';
        if ($request->hasFile('image')) {
            if (!empty($partner->image) && file_exists($partner->image)) {
                unlink($partner->image);
            }
            $Image = $this->imageUpload($request, 'image', 'uploads/ad');
        } else {
            $Image = $partner->image;
        }
        $detailsImage = '';
        if ($request->hasFile('details_image')) {
            if (!empty($partner->details_image) && file_exists($partner->details_image)) {
                unlink($partner->details_image);
            }
            $detailsImage = $this->imageUpload($request, 'details_image', 'uploads/partner');
        } else {
            $detailsImage = $partner->image;
        }
        $partner->name       = $request->name;
        $partner->details       = $request->details;
        $partner->image      = $Image;
        $partner->details_image      = $detailsImage;
        $partner->updated_by    = Auth::user()->id;
        $partner->ip_address = $request->ip();
        $partner->save();
        return redirect()->route('partner.index')->with('success', 'partner updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $partner = Partner::where('id', $id)->first();
        if ($partner->image) {
            @unlink($partner->image);
        }
        $partner->delete();
        return redirect()->route('partner.index')->with('success', 'Partner Deleted Successfully');
    }
}
