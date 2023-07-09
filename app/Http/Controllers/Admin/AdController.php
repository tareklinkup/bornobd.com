<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Contracts\Session\Session;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ad::latest()->get();
        return view('admin.ad.index', compact('ads'));
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
            'title' => 'required|max:100',
            'position' => 'required',
            'image' => 'required|max:1000||Image|mimes:jpg,png,jpeg,bmp',
            'ip_address' => 'max:15'
        ]);
        // return $request;
        if($request->position == 1){
            // $ad->image = $this->imageUpload($request, 'image', 'uploads/ad');
            $image = $request->file('image');
            $smallImage = 'big-add' . time() . uniqid() . $image->getClientOriginalName();
            Image::make($image)->resize(1337,386)->save('uploads/ad/'.$smallImage);
        }elseif($request->position == 2){
            $image = $request->file('image');
            $smallImage = 'middle-add' . time() . uniqid() . $image->getClientOriginalName();
            Image::make($image)->resize(890,386)->save('uploads/ad/'.$smallImage);
        }else{
            $image = $request->file('image');
            $smallImage = 'left-add' . time() . uniqid() . $image->getClientOriginalName();
            Image::make($image)->resize(546,500)->save('uploads/ad/'.$smallImage);
        }

        try {
            $ad = new Ad();
            $ad->title = $request->title;
            $ad->position = $request->position;
          
            $ad->image = $smallImage;
            $ad->save_by = Auth::user()->id;
            $ad->ip_address = $request->ip();
            $ad->save();

            if ($ad) 
            { 
                return redirect()->back()->with('success', 'Ad Inserted Successfully');
            }
        } catch (\Throwable $th) {
            
            return redirect()->back()->with('error', 'Ad not inserted');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ad = Ad::where('id', $id)->first();
        return view('admin.ad.edit', compact('ad'));
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
            'title' => 'required|max:100',
            'image' => 'Image|mimes:jpg,png,jpeg,bmp',
            'ip_address' => 'max:15'
        ]);
        $ad = Ad::find($id);
        $smallImage = '';
        if($request->file('image')){
            $image = $request->file('image');
            if($ad->image){
                @unlink('uploads/ad/'.$ad->image);
            }
            if($request->position == 1){
                $image = $request->file('image');
                $smallImage = 'big-add' . time() . uniqid() . $image->getClientOriginalName();
                Image::make($image)->resize(1337,386)->save('uploads/ad/'.$smallImage);
            }elseif($request->position == 2){
                $image = $request->file('image');
                $smallImage = 'middle-add' . time() . uniqid() . $image->getClientOriginalName();
                Image::make($image)->resize(890,386)->save('uploads/ad/'.$smallImage);
            }else{
                $image = $request->file('image');
                $smallImage = 'left-add' . time() . uniqid() . $image->getClientOriginalName();
                Image::make($image)->resize(546,500)->save('uploads/ad/'.$smallImage);
            }
        }
        else{
            $smallImage  = $ad->image;
        }


        // $adImage = '';
        // if ($request->hasFile('image')) {
        //     if (!empty($ad->image) && file_exists($ad->image)) {
        //         unlink($ad->image);
        //     }
        //     $adImage = $this->imageUpload($request, 'image', 'uploads/ad');
        // } else {
        //     $adImage = $ad->image;
        // }

        $ad->title = $request->title;
        $ad->position = $request->position;
        $ad->updated_by = Auth::user()->user_id;;
        $ad->ip_address = $request->ip();
        $ad->image = $smallImage;
        $ad->save();
        if ($ad) {
            return redirect()->route('ad.index')->with('success', 'Ad updated successfulyy');
        } else {
            return redirect()->bacK()->with('error', 'Fail updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $ad = Ad::where('id', $id)->first();
        if ($ad->image) {
            @unlink('uploads/ad/'.$ad->image);
        }
        $ad->delete();
        return redirect()->route('ad.index')->with('success', 'Ad Deleted Successfully');
    }

    public function active($id)
    {
        $ad = Ad::where('id', $id)->first();
        if ($ad->status == 'd') {
            $ad->status = 'a';
            $ad->save();
        } else {
            $ad->status = 'd';
            $ad->save();
        }
        return back()->with('success', 'Banner Status Updated Successfully');
    }
}
