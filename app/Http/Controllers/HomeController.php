<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AnotherCategory;
use App\Models\Area;
use App\Models\Blog;
use App\Models\Size;
use App\Models\Team;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Thana;
use App\Models\Banner;
use App\Models\Review;
use App\Models\Contact;
use App\Models\Message;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Service;
use App\Models\Upazila;
use App\Models\Category;
use App\Models\Question;
use App\Models\Management;
use App\Models\MonitorSize;
use App\Models\SubCategory;
use App\Models\CameraFormat;
use App\Models\DeliveryTime;
use App\Models\OrderDetails;
use App\Models\ProductImage;
use App\Models\VideoGallery;
use Illuminate\Http\Request;
use App\Models\RecordingMode;
use GuzzleHttp\Handler\Proxy;
use PharIo\Manifest\Manifest;
use PhpParser\Node\Expr\Cast;
use App\Models\CompanyProfile;
use App\Models\StoreLocation;
use App\Models\Subsubcategory;
use App\Models\Tracking;
use App\Models\Wrapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\returnSelf;

class HomeController extends Controller
{
    public function index()
    {
        $slider = Banner::latest()->get();
        $video = VideoGallery::latest()->take(4)->get();
        $bigcategory = Category::where('is_homepage', 1)->take(2)->get();
        $smallCategory = Category::where('is_homepage', 1)->skip(2)->take(3)->get();
        $product = Product::with('category')->where('is_deal', 1)->latest()->take(12)->get();
        $feature_product = Product::where('is_feature', 1)->latest()->take(12)->get();
        $new_arrival = Product::where('new_arrival', 1)->latest()->take(12)->get();
        $tranding_product = Product::where('is_trending', 1)->latest()->take(12)->get();
        $partner = Partner::all();
        $middleAdd = Ad::where('position', 2)->where('status', 'a')->first();
        $bigAdd = Ad::where('position', 1)->where('status', 'a')->first();
        $halfAdd = Ad::where('position', 3)->where('status', 'a')->first();
        return view('website.index', compact('bigcategory', 'smallCategory', 'slider', 'video', 'product', 'feature_product', 'new_arrival', 'tranding_product', 'partner', 'middleAdd', 'bigAdd','halfAdd'));
    }

    public function productList()
    {
    //    return $p = Product::where('price', '>=', 1333 )->where('price', '<=', 22445)->orderBy('price', 'asc')->get();
        $product = Product::with('category', 'productImage')->latest()->paginate(4);
        return view('website.product', compact('product'));
    }
    public function trendproductList()
    {
        $product = Product::with('category', 'productImage')->where('is_trending', 1)->latest()->paginate(12);
        return view('website.trendProduct', compact('product'));
    }

    public function newArrival()
    {
        $product = Product::with('category', 'productImage')->where('new_arrival', 1)->latest()->paginate(4);
        return view('website.newArrival', compact('product'));
    }
    public function dealProduct()
    {
        $product = Product::with('category', 'productImage')->where('is_deal', 1)->latest()->paginate(4);
        return view('website.deal', compact('product'));
    }

    // product filtring

    public function popularPorduct()
    {
        $popularPorduct =  DB::table('order_details')->select('product_id', DB::raw('count(*) as total'))
            ->groupBy('product_id')->get();
        if ($popularPorduct) {
            foreach ($popularPorduct as $pp) {
                $product[] = Product::where('id', $pp->product_id)->first();
            }
        }
        return view('website.popularProduct', compact('product'));
    }

    public function productFileter(Request $request)
    {
        // dd($request->all());
       
        $size_id = $request->size_id ? $request->size_id : '';
        $color_id = $request->color_id ? $request->color_id : '';
     
        $p = Product::with(['productImage', 'category']);

        if(isset($request->input_value) && $request->input_value != '') {
            if($request->input_value == '2'){
                $p = Product::with('productImage')->orderBy('price', 'asc');
            }elseif($request->input_value == '3'){
                $p = Product::with('productImage')->orderBy('price', 'desc'); 
            }elseif($request->input_value == '1'){
                $popular =  DB::table('order_details')->select('product_id', DB::raw('count(*) as total'))
                        ->groupBy('product_id')->get();
                    if ($popular) {
                        foreach ($popular as $pp) {
                            $p[] = Product::with('productImage')->where('id', $pp->product_id);
                        }
                    }
            }
        }

        if(isset($request->min_price) &&  $request->min_price != ''  && $request->max_price){
             $p->where('price', '>=', $request->min_price )->where('price', '<=', $request->max_price)->orderBy('price', 'asc');
        }
        if (isset($size_id) && $size_id != '') {
            $p->where('size_id', 'LIKE', "%{$size_id}%");  

        }
        if(isset($color_id) && $color_id != ''){
              $p->where('color_id', 'LIKE', "%{$color_id}%");
        }

        // if($request->input_value == '1') {
      
        //     $popular =  DB::table('order_details')->select('product_id', DB::raw('count(*) as total'))
        //         ->groupBy('product_id')->get();
        //     if ($popular) {
        //         foreach ($popular as $pp) {
        //             $p[] = Product::with('productImage')->where('id', $pp->product_id);
        //         }
        //     }
        // }
       
        // if($request->input_value == '3') {
        //     $p = Product::with('productImage')->orderBy('price', 'desc');
        // }

        return $p = $p->get();
    }

    public function collectionProductOne()
    {
        $product = Product::where('is_collection_title_1', 1)->with('category', 'productImage')->latest()->paginate(4);
        return view('website.collection_one', compact('product'));
    }
    public function collectionProductTwo()
    {
        $product = Product::where('is_collection_title_2', 1)->with('category', 'productImage')->latest()->paginate(4);
        return view('website.collection_two', compact('product'));
    }

    public function productDetails($slug)
    {
        $service = Service::latest()->take(4)->get();
        $product = Product::where('slug', $slug)->first();
        if($product->sub_category_id != null){
            $similerProduct = Product::where('category_id',  $product->category_id)->where('id','!=' , $product->id)->paginate(4);
        }else{
            $similerProduct = Product::where('sub_category_id',  $product->sub_category_id)->where('id','!=' , $product->id)->paginate(4);
        }
        $reviewList = Review::where('product_id', $product->id)->get();
        return view('website.productDetails', compact('product', 'similerProduct','reviewList','service'));
    }


    public function getMotherApiContent(Request $request){
        // echo $request->style;
        // exit;
        // $url = 'http://119.40.90.186/ForWeb/ShopWiseItem_Details';
        $url = 'http://119.40.90.186/ForWeb/ShopWiseItem_DetailsById?style='.$request->style;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        echo $response_json;

        //     $jsonDetails = json_encode($response_json);
        // $obje =  $jsonDetails->where('Product code', $code)->get();
        //    return $obje;
        // echo  $obje;
    }

    public function CategoryWiseProduct($slug)
    {
        $category_name = Category::where('slug', $slug)->first();
        $product = $category_name->product()->paginate(8);
        return view('website.category', compact('product', 'category_name'));
    }
    
    public function SubcateogryWiseProduct($slug)
    {
        $subcategory_name = SubCategory::where('slug', $slug)->first();
        $product = $subcategory_name->product()->paginate(8);
        return view('website.subcategory', compact('product', 'subcategory_name'));
    }
    public function SubsubcateogryWiseProduct($slug)
    {
        $subsubcategory_name = Subsubcategory::where('slug', $slug)->first();
        $product = $subsubcategory_name->product()->paginate(8);
        return view('website.subsubcategory', compact('product', 'subsubcategory_name'));
    }
    public function anotherCategoryWiseProduct($slug)
    {
        $anotherCategory_name = AnotherCategory::where('slug', $slug)->first();
        $product = $anotherCategory_name->product()->paginate(8);
        return view('website.anothercategory', compact('product', 'anotherCategory_name'));
    }

    public function otherImage($id)
    {
        $other = ProductImage::where('id', $id)->first();
        return $Image = asset('uploads/products/others/original/' . $other->other_main_image);
    }

    public function modalProduct($id)
    {
        $product = Product::with('category', 'productImage', 'size')->where('id', $id)->first();
        return response()->json($product);
    }

    public function modalPartner($id){
        $partner = Partner::where('id', $id)->first();
        return response()->json($partner);
    }
    
    public function cartList()
    {
        $wrapper = Wrapping::latest()->get();
        return view('website.cart_list', compact('wrapper'));
    }

    public function getSearchSuggestions(Request $request)
    {
        $keyword = $request->term;
        $str_arr = str_split($keyword);

        $product = Product::select('name');
        // $category = Category::select('name');
        // $subcategory = SubCategory::select('name');
        foreach($str_arr as $c){
            if($c != ' '){
                $product->where('name', 'like', "%$c%");
                // $category->where('name', 'like', "%$c%");
                // $subcategory->where('name', 'like', "%$c%");
            }
        }

        $product = $product->get()->toArray();
        // $category = $category->get()->toArray();
        // $subcategory = $subcategory->get()->toArray();

        // dd($product2, $product3);
        // $like = preg_replace('//', '%', $keyword);
        // // dd($like_city);
        // $product = Product::select('name')
        //     ->where('name', 'like', $like)
        //     ->get()->toArray();

        // // dd($product);

        // $category = Category::select('name as name')
        //     ->where('name', 'like', $like)
        //     ->get()->toArray();

        // $subcategory = SubCategory::select('name as name')
        //     ->where('name', 'like', $like)
        //     ->get()->toArray();

        // $mergedArray = array_merge($product, $category, $subcategory);

        $search_results = [];

        foreach ($product as $sr) {
            $search_results[] = $sr['name'];
        }

        return response()->json($search_results);
    }

    public function productSearch()
    {
        if (request()->query('q')) {
            $keyword = request()->query('q');
            $str_arr = str_split($keyword);

            $product = Product::where('status', 1);
            foreach($str_arr as $c){
                if($c != ' '){
                    $product->where('name', 'like', "%$c%");
                }
            }

            $product = $product->paginate(16);

            // $product = Product::Where('name', 'like', "%$keyword%")->paginate(16);
            return view('website.search', compact('product', 'keyword'));
        }

        return redirect()->back();
    }


    public function aboutUs()
    {
        return view('website.aboutUs');
    }
   public function storeList(){
       $store = StoreLocation::latest()->get();
       return view('website.storelist', compact('store'));
   } 

   public function management()
   {
    $management = Management::orderBy('rank', 'asc')->get();
    return view('website.management', compact('management'));
   }

   public function track(){
    $track = Tracking::latest()->get();
    return view('website.traking', compact('track'));
   }

    public function tramsCondition()
    {
        return view('website.trams');
    }
    public function missionVission()
    {
        return view('website.mission');
    }



    public function sizeGuide(){
        return view('website.sizeguide');
    }


    public function partnerPage($id){
        $partner = Partner::find($id);
        return  view('website.partner', compact('partner'));
    }

    public function contactUs(){
        return view('website.contactUs');
    }

    public function contactStore(Request $request){
        $request->validate([
            'name' => 'required|max:100',
            'subject' => 'required',
            'email' => 'required|email:rfc,dns',
        ]);

       try {
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->ip = $request->ip();
        $contact->save();
        return redirect()->back()->with('success',"Mesage Successfully Send");
       } catch (\Throwable $th) {
        return redirect()->back()->with('error',"Something went wrong");
       }
       
    }
}
