<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\MultiImg;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;





class IndexController extends Controller
{
    public function Index(){
        $skip_category_0 = Category::skip(0)->first();
        $skip_product_0 = Product::where('status',1)->where('category_id', $skip_category_0->id)->orderBy('id','desc')->limit(5)->get();


        $skip_category_2 = Category::skip(1)->first();
        $skip_product_2 = Product::where('status',1)->where('category_id', $skip_category_2->id)->orderBy('id','desc')->limit(5)->get();


        $skip_category_3 = Category::skip(2)->first();
        $skip_product_3 = Product::where('status',1)->where('category_id', $skip_category_3->id)->orderBy('id','desc')->limit(5)->get();

        $hot_deals = Product::where('hot_deals', 1 )->where('discount_price', '!=', null)->orderBy('id', 'desc')->limit(3)->get();

        $special_offer = Product::where('special_offer', 1 )->orderBy('id', 'desc')->limit(3)->get();

        $new = Product::where('status', 1)->orderBy('id', 'desc')->limit(3)->get();

        $special_deals = Product::where('special_deals',1)->orderBy('id','desc')->limit(3)->get();

        return view('frontend.index',compact('skip_category_0','skip_product_0', 'skip_category_2', 'skip_product_2',
            'skip_category_3','skip_product_3', 'hot_deals', 'special_offer', 'new', 'special_deals'));

    } // End Index




    public function ProductDetails($id,$slug){

        $product = Product::findOrFail($id);

        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);

        $multiImage = MultiImg::where('product_id',$id)->get();

        $cat_id = $product->category_id;
        $relatedProduct = Product::where('category_id',$cat_id)->where('id','!=',$id)->orderBy('id','DESC')->limit(4)->get();

        return view('frontend.product.product_details',compact('product','product_color','product_size','multiImage','relatedProduct'));

    } // End ProductDetails


    public function VendorDetails($id)
    {
        $vendor = User::findOrFail($id);
        $vproduct = Product::where('vendor_id',$id)->get();
        return view('frontend.vendor.vendor_details', compact('vendor', 'vproduct'));
    } // End VendorDetails

    public function VendorAll()
    {
        $vendors = User::where('status', 'active')->where('role', 'vendor')->orderBy('id', 'desc')->get();
        return view('frontend.vendor.vendor_all', compact('vendors'));

    } // End VendorAll


    public function CatWiseProduct(Request $request, $id, $slug)
    {
        $products = Product::where('status', 1)->where('category_id', $id)->orderBy('id', 'desc')->get();

        $categories = Category::orderBy('category_name', 'asc')->get();

        $breadcat = Category::where('id',$id)->first();

        $newProduct = Product::orderBy('id', 'desc')->limit(3)->get();
        return view('frontend.product.category_view', compact('products', 'categories', 'breadcat', 'newProduct'));

    } // End CatWiseProduct




}
