<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use App\Models\ProductImage;

use Illuminate\Http\Request;
use Intervention\Image\Size;
use App\Models\Size as ModelsSize;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AnotherCategory;
use App\Models\Subsubcategory;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::latest()->get();
        return view('admin.product.index', compact('product'));
    }

    public function create()
    {
        $data['brand'] = Brand::all();
        $data['category'] = Category::all();
        $data['product'] = Product::latest()->take('10')->get();
        $data['size'] = ModelsSize::all();
        $data['color'] = Color::all();
        // $data['productCode'] = $this->generateCode('Product', 'P');
        return view('admin.product.create', $data);
    }

    public function getSubcategory($id)
    {
        $subCategory = SubCategory::where('category_id', $id)->get();
        return response()->json($subCategory);
    }
 
    public function getSubsubcategory($id)
    {
        $subsubcategory = Subsubcategory::where('sub_category_id', $id)->get();
        return response()->json($subsubcategory);
    }
    public function getAnothercategory($id)
    {
        $anotherCategory = AnotherCategory::where('subsubcategory_id', $id)->get();
        return response()->json($anotherCategory);
    }

    public function store(Request $request)
    {
        // dd($request->all());
       
        $request->validate([
            'name' => 'required',
            'model' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'image' => 'max:4000|Image|mimes:jpg,png,jpeg,bmp',
            // 'sizeguide' => 'max:1000|Image|mimes:jpg,png,jpeg,bmp',
        ]);
        $slug = Str::slug($request->name . '-' . time());
        $i = 0;
        while (true) {
            if (Category::where('slug', '=', $slug)->exists()) {
                $i++;
                $slug .= '_' . $i;
                continue;
            }
            break;
        }

        if($request->simillar_porduct == ''){
            $simillarPporduct = '';
        }else{
            $simillarPporduct = join(',', $request->simillar_porduct);
        }

        if($request->size_id  == ''){
            $size_id = '';
        }else{
            $size_id = join(',', $request->size_id);
        }
        if($request->color_id == ''){
            $color_id = '';
        }else{
            $color_id = join(',', $request->color_id);
        }


        $image = $request->file('image');
        $mainImage  = 'main' . time() . uniqid() . $image->getClientOriginalName();
        $thumbImage = 'thumb-' . time() . uniqid() . $image->getClientOriginalName();
        $smallImage = 'small-' . time() . uniqid() . $image->getClientOriginalName();

        Image::make($image)->resize(600,800)->save('uploads/products/original/' . $mainImage);
        Image::make($image)->resize(243,334)->save('uploads/products/thumbnail/' . $thumbImage);
        Image::make($image)->resize(75,80)->save('uploads/products/small/' . $smallImage);

        $sizeGuide = $request->file('sizeguide');
        $SizeImage = 'sizeGuide-'.time().uniqid().$sizeGuide->getClientOriginalName();
        Image::make($sizeGuide)->save('uploads/products/sizeguide/' . $SizeImage);
        
       try {
            // DB::beginTransaction();
            // $productCode = $this->generateCode('Product', 'P');
            $product = new Product();
            $product->slug                = $slug;
            $product->product_code        = $request->product_code;
            $product->name                = $request->name;
            $product->model               = $request->model;
            $product->simillar_porduct    = $simillarPporduct;
            $product->similar_discount    = $request->similar_discount;
            $product->size_id             =  $size_id;
            $product->color_id            = $color_id;
            $product->price               = $request->price;
            $product->category_id         = $request->category_id;
            $product->sub_category_id     = $request->sub_category_id ?? NULL;
            $product->subsubcategory_id     = $request->subsubcategory_id ?? NULL;
            $product->another_category_id     = $request->another_category_id ?? NULL;
            $product->brand_id            = $request->brand_id;
            $product->discount            = $request->discount ?? NULL;
            $product->is_feature          = $request->is_feature ?? '';
            $product->is_collection_title_1   = $request->is_collection_title_1 ?? '';
            $product->is_collection_title_2   = $request->is_collection_title_2 ?? '';
            $product->is_trending         = $request->is_trending ?? '';
            $product->new_arrival         = $request->new_arrival ?? '';
            $product->is_deal             = $request->is_deal ??'';
            $product->is_tailoring        = $request->is_tailoring ?? '' ;
            $product->tailoring_charge    = $request->tailoring_charge ;
            $product->short_details       = $request->short_details ?? '';
            $product->deal_start          = $request->deal_start ?? NULL;
            $product->deal_end            = $request->deal_end ?? NULL;
            $product->description         = $request->description ?? '';
            $product->main_image          = $mainImage;
            $product->small_image         = $smallImage;
            $product->thumb_image         = $thumbImage;
            $product->sizeguide           = 'uploads/products/sizeguide/'.$SizeImage ?? NULL;
            $product->status              = '1';
            // $product->reward_point     = $request->reward_point;
            $product->save_by             = Auth::user()->id;
            $product->ip_address          = $request->ip();
            $product->save();

            if($request->hasFile('otherImage')){
                foreach ($request->file('otherImage') as $image) {
                    $otherMainImage  = 'main' . time() . uniqid() . $image->getClientOriginalName();
                    $otherThumbImage = 'thumb-' . time() . uniqid() . $image->getClientOriginalName();
                    $otherSmallImage = 'small-' . time() . uniqid() . $image->getClientOriginalName();
                    
                    Image::make($image)->resize(600,800)->save('uploads/products/others/original/' . $otherMainImage);
                    Image::make($image)->resize(243,334)->save('uploads/products/others/thumbnail/' . $otherThumbImage);
                    Image::make($image)->resize(75,80)->save('uploads/products/others/small/' . $otherSmallImage);
                  
                  
                    $productImage                       = new ProductImage();
                    $productImage->other_main_image     = $otherMainImage;
                    $productImage->other_mediam_image   = $otherThumbImage;
                    $productImage->other_small_image    = $otherSmallImage;
                    $productImage->product_id           = $product->id;
                    $productImage->save();

                }
             }
          
            return back()->with('success','Product Added Successfully');
           
         } 
         catch (Exception $e){
            DB::rollBack();
            Session::flash('faild', 'Product Added fail');
            return back();
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

    public function removeImage($id)
    {
        try {
            $removeImage = ProductImage::find($id);
            if (!empty($removeImage->other_main_image) && file_exists($removeImage->other_main_image)) {
                @unlink('uploads/products/others/original/'.$removeImage->other_main_image);
                @unlink('uploads/products/others/thumbnail/'.$removeImage->other_mediam_image);
                @unlink('uploads/products/others/small/'.$removeImage->other_small_image);
            }
            $removeImage->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $data['product_list'] = Product::all();
        $data['size'] = ModelsSize::all();
        $data['color'] = Color::all();
        $data['brand'] = Brand::all();
        $data['category'] = Category::all();
        $data['subCategory'] = SubCategory::all();
        $data['SubsubCategory'] = Subsubcategory::all();
          $data['anotherCategory'] = AnotherCategory::all();
        $data['products'] = Product::latest()->take('10')->get();
        $data['product'] = Product::with('productImage')->where('slug',$slug)->first();
        $data['otherImage'] = ProductImage::where('product_id', $data['product']->id)->get();
        return view('admin.product.edit', $data);
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
            'name' => 'required',
            'model' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'image' => 'max:4000|Image|mimes:jpg,png,jpeg,bmp',
            'sizeguide' => 'max:1000|Image|mimes:jpg,png,jpeg,bmp',
        ]);
       
          $product  = Product::find($id);
        if($request->file('image')){
            $image = $request->file('image');
            if($product->main_image){
                @unlink('uploads/products/original/'.$product->main_image);
            }
            if($product->thumb_image){
                @unlink('uploads/products/thumbnail/'.$product->thumb_image);
            }
            if($product->small_image){
                @unlink('uploads/products/small/'.$product->small_image);
            }
           
            $mainImage  = 'main' . time() . uniqid() . $image->getClientOriginalName();
            $thumbImage = 'thumb-' . time() . uniqid() . $image->getClientOriginalName();
            $smallImage = 'small-' . time() . uniqid() . $image->getClientOriginalName();
    
            Image::make($image)->save('uploads/products/original/' . $mainImage);
            Image::make($image)->resize(243,334)->save('uploads/products/thumbnail/' . $thumbImage);
            Image::make($image)->resize(100,75)->save('uploads/products/small/' . $smallImage);

        }

        
        else{
            $mainImage  = $product->main_image;
            $thumbImage = $product->thumb_image;
            $smallImage = $product->small_image;
        }

        if($request->simillar_porduct == ''){
            $simillarPporduct = '';
        }else{
            $simillarPporduct = join(',', $request->simillar_porduct);
        }

        if($request->size_id  == ''){
            $size_id = '';
        }else{
            $size_id = join(',', $request->size_id);
        }
        if($request->color_id == ''){
            $color_id = '';
        }else{
            $color_id = join(',', $request->color_id);

        }

        if($request->file('sizeguide')){
            $sizeGuide = $request->file('sizeguide');
            if($product->sizeguide){
                @unlink($product->sizeguide);
            }
          
            $SizeImage = 'sizeGuide-'.time().uniqid().$sizeGuide->getClientOriginalName();
            Image::make($sizeGuide)->save('uploads/products/sizeguide/' . $SizeImage);

            $SizeImage = 'uploads/products/sizeguide/'.$SizeImage;
        }else{
           $SizeImage = $product->sizeguide;
        }

        
       try {
          
            $product->name                = $request->name;
            $product->product_code        = $request->product_code;
            $product->model               = $request->model;
            $product->price               = $request->price;
            $product->simillar_porduct    = $simillarPporduct;
            $product->similar_discount    = $request->similar_discount;
            $product->size_id             =  $size_id;
            $product->color_id             = $color_id;
            $product->category_id         = $request->category_id;
            $product->sub_category_id     = $request->sub_category_id ?? NULL;
            $product->subsubcategory_id     = $request->subsubcategory_id ?? NULL;
            $product->another_category_id     = $request->another_category_id ?? NULL;
            $product->brand_id            = $request->brand_id;
            $product->discount            = $request->discount ;
            $product->is_feature          = $request->is_feature;
            $product->is_collection_title_1          = $request->is_collection_title_1;
            $product->is_collection_title_2          = $request->is_collection_title_2;
            $product->is_trending         = $request->is_trending;
            $product->new_arrival         = $request->new_arrival;
            $product->is_deal             = $request->is_deal ;
            $product->is_tailoring             = $request->is_tailoring ;
            $product->tailoring_charge             = $request->tailoring_charge ;
            $product->short_details       = $request->short_details;
            $product->deal_start          = $request->deal_start;
            $product->deal_end            = $request->deal_end;
            $product->description         = $request->description;
            $product->main_image          = $mainImage;
            $product->thumb_image         = $thumbImage;
            $product->small_image         = $smallImage;
            $product->sizeguide         = $SizeImage;
            $product->status              = '1';
            // $product->reward_point        = $request->reward_point;
            $product->save_by             = Auth::user()->id;
            $product->ip_address          = $request->ip();
            $product->save();

            
            if($request->hasFile('otherImage')){
                foreach ($request->file('otherImage') as $image) {
                    $otherMainImage  = 'main' . time() . uniqid() . $image->getClientOriginalName();
                    $otherThumbImage = 'thumb-' . time() . uniqid() . $image->getClientOriginalName();
                    $otherSmallImage = 'small-' . time() . uniqid() . $image->getClientOriginalName();
                    
                    Image::make($image)->save('uploads/products/others/original/' . $otherMainImage);
                    Image::make($image)->resize(243,334)->save('uploads/products/others/thumbnail/' . $otherThumbImage);
                    Image::make($image)->resize(100,75)->save('uploads/products/others/small/' . $otherSmallImage);
                  
                    $productImage                       = new ProductImage();
                    $productImage->other_main_image     = $otherMainImage;
                    $productImage->other_mediam_image   = $otherThumbImage;
                    $productImage->other_small_image    = $otherSmallImage;
                    $productImage->product_id           = $product->id;
                    $productImage->save();

                }
             }
          

            return redirect()->route('product.index')->with('success','Product updated Successfully');
         } 
         catch (Exception $e){
            DB::rollBack();
            Session::flash('faild', 'Product Added fail');
            return back();
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
         $product = Product::with('productImage')->where('id',$id)->first();

       
            if($product->main_image){
                
                @unlink('uploads/products/original/'.$product->main_image);
            }
            if($product->thumb_image){
                @unlink('uploads/products/thumbnail/'.$product->thumb_image);
            }
            if($product->small_image){
                @unlink('uploads/products/small/'.$product->small_image);
            }
      
       
       
        if($product->productImage == true){
            foreach($product->productImage as $item){
                @unlink('uploads/products/others/original/'.$item->other_main_image);
                @unlink('uploads/products/others/thumbnail/'.$item->other_mediam_image);
                @unlink('uploads/products/others/small/'.$item->other_small_image);
                $item->delete();
            }
        }
        $product->delete();
        
        return back()->with('success', 'product deleted successfully');
    }

    
}
