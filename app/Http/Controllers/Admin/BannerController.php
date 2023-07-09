<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller
{

  public function index()
  {
    return view('admin.banner.index');
  }


  public function allData()
  {
    $banners = Banner::latest()->get();
    return response()->json($banners);
  }
  // data insert
  public function store(Request $request)
  {
    if ($request->id == NULL) {
      $this->validate($request, [
        'title' => 'required|max:100',
        'offer_name' => 'required|max:100',
        'offer_link' => 'required|max:120',
        'image' => 'required|max:1000||Image|mimes:jpg,png,jpeg,bmp',
        'ip_address' => 'max:15'
      ]);


   
      $banner = new Banner();
      $banner->title = $request->title;
      $banner->short_details = $request->short_details;
      $banner->offer_name = $request->offer_name;
      $banner->offer_link = $request->offer_link;

      $image = $request->file('image');
      $mainImage  = 'b-' . time() . uniqid() . $image->getClientOriginalName(); 
      Image::make($image)->resize(1360,600)->save('uploads/banner/' . $mainImage);

      $banner->image = $mainImage;
      $banner->save_by = 1;
      $banner->updated_by = 1;
      $banner->ip_address = $request->ip();
      $banner->save();
      return response()->json($banner);
    } else {
    }
  }

  //  data show
  public function edit($id)
  {
    $banner = Banner::find($id)->toArray();
    $banner['image'] = asset($banner['image']);
    return response()->json($banner);
  }

  //  update 
  public function update(Request $request)
  {
    $this->validate($request, [
      'title' => 'required|max:100',
      'offer_name' => 'required|max:100',
      'offer_link' => 'required|max:120',
      'ip_address' => 'max:15'
    ]);

    $banner = Banner::where('id', $request->id)->first();
    $banner->title = $request->title;
    $banner->short_details = $request->short_details;
    $banner->offer_name = $request->offer_name;
    $banner->offer_link = $request->offer_link;
    if ($request->hasFile('image')) {
      @unlink('uploads/banner/'.$banner->image);
      $image = $request->file('image');
      $mainImage = 'B-' . time() . uniqid() . $image->getClientOriginalName();
      Image::make($image)->resize(1360,600)->save('uploads/banner/' . $mainImage);
      $banner->image = $mainImage;
    }
    
    $banner->save_by = 1;
    $banner->updated_by = 1;
    $banner->ip_address = $request->ip();
    $banner->save();
    return response()->json($banner);
  }

  public function destroy($id)
  {
    $banner = Banner::where('id', $id)->first();
    if ($banner->image) {
      unlink('uploads/banner/'.$banner->image);
    }
    $banner->delete();
    $data = "Data Deleted Successfully";
    return response()->json($data);
  }
}
