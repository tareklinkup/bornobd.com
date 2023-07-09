<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class ContentController extends Controller
{

    // Company Profile 
    public function edit()
    {
        $company = CompanyProfile::first();
        return view('admin.content.profile', compact('company'));
    }

    public function update(Request $request, CompanyProfile $company)
    {
        // dd($request->all());
     $request->validate([
            'company_name' => 'required|max:50',
            'email' => 'required|email',
            'phone_1' => 'required|max:15',
            'phone_2' => 'max:15',
            'address' => 'required|string',
            'logo' => 'mimes:jpg,jpeg,png,bmp,gif',
            'size_guide' => 'mimes:jpg,jpeg,png,bmp,webp,gif',
        ]);

        // Image Update 
        $companyLogo = '';
        if ($request->hasFile('logo')) {
            if (!empty($company->logo) && file_exists($company->logo)) {
                unlink($company->logo);
            }
            $companyLogo = $this->imageUpload($request, 'logo', 'uploads/logo/');
        } else {
            $companyLogo = $company->logo;
        }

        $companySizeGuide = '';
        if ($request->hasFile('size_guide')) {
            if (!empty($company->size_guide) && file_exists($company->size_guide)) {
                unlink($company->size_guide);
            }
            $companySizeGuide = $this->imageUpload($request, 'size_guide', 'uploads/size_guide/');
        } else {
            $companySizeGuide = $company->size_guide;
        }
        $company->company_name = $request->company_name;
        $company->email = $request->email;
        $company->phone_1 = $request->phone_1;
        $company->phone_2 = $request->phone_2;

        $company->office_time = $request->office_time;
        $company->free_shipping = $request->free_shipping;
        $company->cashback = $request->cashback;

        $company->happy_hour_date = $request->happy_hour_date;
        $company->happy_hour_time_from = $request->happy_hour_time_from;
        $company->happy_hour_time_to = $request->happy_hour_time_to;

        $company->address = $request->address;
        $company->facebook = $request->facebook;
        $company->youtube = $request->youtube;
        $company->linkedin = $request->linkedin;
        $company->instagram = $request->instagram;
        $company->news_headline = $request->news_headline;
        $company->updated_by = Auth::user()->id;
        $company->size_guide = $companySizeGuide;
        $company->logo = $companyLogo;
        $company->save();
        if ($company) {
            Session::flash('success', 'Company Profile Update Successfully');
            return redirect()->back();
        }
        return redirect()->back();
    }

    //Welcome note
    public function welcome(CompanyProfile $company)
    {
        $company = CompanyProfile::first();
        return view('admin.content.welcome', compact('company'));
    }

    // Welcome data update
    public function welcomeUpdate(Request $request)
    {
        $this->validate($request, [
            'welcome_title' => 'required|max:200',
        ]);
        $company = CompanyProfile::first();
        $company->welcome_title = $request->welcome_title;
        $company->welcome_note = $request->welcome_note;
        $company->updated_by = Auth::user()->id;
        if ($request->hasFile('welcome_image')) {
            $image_path = public_path($company->welcome_image);
            @unlink($image_path);
            $company->welcome_image = $this->imageUpload($request, 'welcome_image', 'uploads/welcome');
        }

        $company->save();
        return back()->with('success', 'welcome note updated successfully.');
    }
    //service function
    public function service()
    {
        return view('admin.service.service');
    }
    public function banner()
    {
        return view('admin.banner.banner');
    }
    public function aboutUs()
    {
        $company = CompanyProfile::first();
        return view('admin.content.about_us', compact('company'));
    }
    // about data update
    public function aboutUpdate(Request $request)
    {
        $company = CompanyProfile::first();
        $about_image = '';
        if ($request->hasFile('about_image')) {
            if (!empty($company->about_image) && file_exists($company->about_image)) {
                unlink($company->about_image);
            }
            $about_image = $this->imageUpload($request, 'about_image', 'uploads/about/');
        } else {
            $about_image = $company->about_image;
        }

        $company->about_image       = $about_image;
        $company->about_title       = $request->about_title;
        $company->about_description = $request->about_description;
        $company->save();
        return back()->with('success', 'welcome note updated successfully.');
    }
    public function mission(Request $request)
    {
        $company = CompanyProfile::first();
        return view('admin.content.mission', compact('company'));
    }

    // mission vission data update
    public function missionUpdate(Request $request)
    {
        $company = CompanyProfile::first();
        $company->mission_vision_title = $request->mission_vision_title;
        $company->mission_vision = $request->mission_vision;
        $company->trams_condition_title = $request->trams_condition_title;
        $company->trams_condition = $request->trams_condition;
        $company->save();
        return back()->with('success', 'Mission Vission & term condition updated successfully');
    }
    public function refund(CompanyProfile $company)
    {
        $company = CompanyProfile::first();
        return view('admin.content.refund', compact('company'));
    }
    public function refundUpdate(Request $request)
    {
        $company = CompanyProfile::first();
        $company->refund_title = $request->refund_title;
        $company->refund_details = $request->refund_details;
        $company->save();
        return back()->with('success', 'Refund data updated successfully');
    }
    public function faq()
    {
        $company = CompanyProfile::first();
        return view('admin.content.faq', compact('company'));
    }
    public function faqUpdate(Request $request)
    {
        $company = CompanyProfile::first();
        $company->faq_title = $request->faq_title;
        $company->faq_details = $request->faq_details;
        $company->save();
        return back()->with('success', 'FAQ data updated successfully');
    }

    public function adminPhone(){
        return  view('admin.permission.admin_mobile');
    }
    public function adminPhoneUpdate(Request $request){
        $this->validate($request, [
            'phone_3' => 'required|max:11',
            'phone_4' => 'required|max:11',
            'phone_5' => 'required|max:11',
        ]);
        $company = CompanyProfile::first();
        $company->phone_3 = $request->phone_3;
        $company->phone_4 = $request->phone_4;
        $company->phone_5 = $request->phone_5;
        $company->save();
        return back()->with('success', 'Admin Phone Updated Successfully');
    }


    // is collection

    public function isCollection(){
        return view('admin.content.is_collection');
    }

    public function isCollectionUpdate(Request $request){
        // dd($request->all());
        $company = CompanyProfile::first();
        // $is_collection_img_1 = '';
        if($request->file('is_collection_img_1')){
           $image = $request->file('is_collection_img_1');
            if(!empty($company->is_collection_img_1)){
                @unlink('uploads/collection/large/'.$company->is_collection_img_1);
            }
            $is_collection_img_1 = 'large-' . time() . uniqid() . $image->getClientOriginalName();
            Image::make($image)->resize(540,310)->save('uploads/collection/large/'.$is_collection_img_1);
        }
        else{
           $is_collection_img_1 = $company->is_collection_img_1;
        }
       
        if($request->file('is_collection_img_2')){
            $image = $request->file('is_collection_img_2');
            if(!empty($company->is_collection_img_2)){
                @unlink('uploads/collection/large/'.$company->is_collection_img_2);
            }
            $is_collection_img_2 = 'large-' . time() . uniqid() . $image->getClientOriginalName();
            Image::make($image)->resize(540,310)->save('uploads/collection/large/'.$is_collection_img_2);
           
        }
        else{
            $is_collection_img_2 = $company->is_collection_img_2;
        }

        $company->is_collection_title_1       = $request->is_collection_title_1;
        $company->is_collection_img_1       = $is_collection_img_1;
        $company->is_collection_title_2       = $request->is_collection_title_2;
        $company->is_collection_img_2       = $is_collection_img_2;
        $company->save();
        return back()->with('success', 'Collection update successfully');
    }


    public function  popUp(){
        return view('admin.content.popup');
    }

    public function popUpUpdate(Request $request){
    //    dd($request->all());
        $company = CompanyProfile::first();
        $popUpImage = '';
        if ($request->hasFile('pop_up_image')) {
            if (!empty($company->pop_up_image) && file_exists($company->pop_up_image)) {
                unlink($company->pop_up_image);
            }
            $popUpImage = $this->imageUpload($request, 'pop_up_image', 'uploads/about/');
        } else {
            $popUpImage = $company->pop_up_image;
        }
        $popUpicon = '';
        if ($request->hasFile('pop_up_icon')) {
            if (!empty($company->pop_up_icon) && file_exists($company->pop_up_icon)) {
                unlink($company->pop_up_icon);
            }
            $popUpicon = $this->imageUpload($request, 'pop_up_icon', 'uploads/about/');
        } else {
            $popUpicon = $company->pop_up_icon;
        }
        $company->pop_up_title       = $request->pop_up_title;
        $company->pop_up_status       = $request->pop_up_status;
        $company->pop_up_image       = $popUpImage;
        $company->pop_up_icon       = $popUpicon;
        $company->save();
        return back()->with('success', 'Pop Up Update Successfully.');
    }
}
