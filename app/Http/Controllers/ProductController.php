<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\Product;
use App\model\ProductMeta;
use App\model\ProductPriceQuantity;
use App\model\CategoryProduct;
use App\model\Category;
use App\model\Order;
use App\model\Brand;
use Image;
use Auth;
use Validator;
use Response;
use Cookie;
use URL;
use View;
use Input;


class ProductController extends Controller
{


    protected $page = 1;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($parent, $child)
    {



        $parent = Category::where('slug', $parent)->first();
        $category = $parent ? Category::where(['slug' => $child, 'parent' => $parent->id])->first() : false;
        /*$parent = Category::where('slug', $parent)->first();
        
        $total = 0;*/
        $sortby1 =  $category->order_by ?? 'latest';
        $sortby = Input::has('sort-by') ? Input::get('sort-by') : $sortby1;
        /*$orderby = ['id', 'DESC'];
        
        if( $sortby === 'low_to_high' ) {
            $orderby = ['price', 'ASC'];
        }
        elseif( $sortby === 'high_to_low' ) {
            $orderby = ['price', 'DESC'];
        }*/

        $products = false;
        if ($sortby === 'low_to_high' && $category) {
            $products = $category->category_product()->where(function ($query) {

                $minPrice = Input::has('min') ? Input::get('min') : '';
                $maxPrice = Input::has('max') ? Input::get('max') : '';
                $brand = Input::has('brand') ? Brand::where('slug', Input::get('brand'))->value('id') : '';
                if ($minPrice) {
                    $query->where('price', '>=', $minPrice);
                }
                if ($maxPrice) {
                    $query->where('price', '<=', $maxPrice);
                }
                if ($brand) {
                    $query->where('brand', $brand);
                }
            })->orderby('price', 'ASC')->where('status', 'active')->where('available', '>', 0)->paginate(12);
        } else if ($sortby === 'high_to_low' && $category) {
            $products = $category->category_product()->where(function ($query) {

                $minPrice = Input::has('min') ? Input::get('min') : '';
                $maxPrice = Input::has('max') ? Input::get('max') : '';
                $brand = Input::has('brand') ? Brand::where('slug', Input::get('brand'))->value('id') : '';
                if ($minPrice) {
                    $query->where('price', '>=', $minPrice);
                }
                if ($maxPrice) {
                    $query->where('price', '<=', $maxPrice);
                }
                if ($brand) {
                    $query->where('brand', $brand);
                }
            })->orderby('price', 'DESC')->where('status', 'active')->where('available', '>', 0)->paginate(12);
        } else {
            if ($category) {
                $products = $category->category_product()->where(function ($query) {

                    $minPrice = Input::has('min') ? Input::get('min') : '';
                    $maxPrice = Input::has('max') ? Input::get('max') : '';
                    $brand = Input::has('brand') ? Brand::where('slug', Input::get('brand'))->value('id') : '';
                    if ($minPrice) {
                        $query->where('price', '>=', $minPrice);
                    }
                    if ($maxPrice) {
                        $query->where('price', '<=', $maxPrice);
                    }
                    if ($brand) {
                        $query->where('brand', $brand);
                    }
                })->orderby('id', 'DESC')->where('status', 'active')->where('available', '>', 0)->paginate(12);
            }
        }


        /*if( isset( $_GET['sort-by'] ) && $_GET['sort-by'] === 'low_to_high' ) {
            if( $category ) {
                $total = $category->category_product()->where('status', 'active')->count();
                $products = $category->category_product()->where('status', 'active')->orderby('price', 'ASC')->paginate(12);
            }
            else
                $products = false;
        }
        if( isset( $_GET['sort-by'] ) && $_GET['sort-by'] === 'high_to_low' ) {
            if( $category ) {
                $total = $category->category_product()->where('status', 'active')->count();
                $products = $category->category_product()->where('status', 'active')->orderby('price', 'DESC')->paginate(12);
            }
            else
                $products = false;
        }
        else {
            if( $category ) {
                $total = $category->category_product()->where('status', 'active')->count();
                $products = $category->category_product()->where('status', 'active')->orderby('id', 'DESC')->paginate(12);
            }
            else
                $products = false;
        }*/

        $title = $category ? $category->name : 'Oops! page not found';
        return view(_template('product.index'), ['title' => $title, 'category' => $category, 'sortby' => $sortby, 'parent' => $parent, 'products' => $products]);
    }

    public function view($category, $slug, $product_id)
    {

        $product = Product::where('product_id', $product_id)->where('available', '>', 0)->with(['product_meta', 'product_brand', 'product_attribute_meta', 'productMeta', 'media', 'product_category'])->first();

        $title = $product ? $product->title : 'Oops! page not found';
        return view(_template('product.view'), ['title' => $title, 'product' => $product]);
    }


    public function hotdeals()
    {




        /*if( isset( $_GET['sort-by'] ) && $_GET['sort-by'] === 'low_to_high' ) {
            if( $category ) {
                $total = $category->category_product()->where('status', 'active')->count();
                $products = $category->category_product()->where('status', 'active')->orderby('price', 'ASC')->paginate(12);
            }
            else
                $products = false;
        }
        if( isset( $_GET['sort-by'] ) && $_GET['sort-by'] === 'high_to_low' ) {
            if( $category ) {
                $total = $category->category_product()->where('status', 'active')->count();
                $products = $category->category_product()->where('status', 'active')->orderby('price', 'DESC')->paginate(12);
            }
            else
                $products = false;
        }
        else {
            if( $category ) {
                $total = $category->category_product()->where('status', 'active')->count();
                $products = $category->category_product()->where('status', 'active')->orderby('id', 'DESC')->paginate(12);
            }
            else
                $products = false;
        }*/

        $products = Product::with('product_category')->limit(10)->where('discount', '!=', null)->where('available', '>', 0)->where('status', 'active')->orderby('discount', 'DESC')->paginate(12);

        return view(_template('product.hot-deals'), ['title' => 'Hot Deals', 'parent' => 'Offers', 'products' => $products]);
    }


    public function featured()
    {

        $products = Product::with('product_category')->where(['type' => 'featured', 'status' => 'active'])
            ->where('available', '>', 0)->orderby('id', 'DESC')->paginate(12);

        return view(_template('product.featured'), ['title' => 'Featured Collection', 'parent' => 'Products', 'products' => $products]);
    }


    public function new()
    {

        $products = Product::with('product_category')->where('status', 'active')->where('available', '>', 0)->orderby('id', 'DESC')->paginate(12);

        return view(_template('product.new'), ['title' => 'New Arrivals', 'parent' => 'Products', 'products' => $products]);
    }
}
