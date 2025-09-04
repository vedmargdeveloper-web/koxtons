<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\FileManager as File;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\model\Product;
use App\model\ProductMeta;
use App\model\ProductPriceQuantity;
use App\model\CategoryProduct;
use App\model\Category;
use App\model\Coupon;
use App\model\Meta;
use App\model\Pincode;
use App\model\Post;
use App\model\State;
use App\model\City;
use App\model\Order;
use App\model\Contact;
use App\model\Subscriber;
use App\model\OrderMeta;
use App\model\Brand;
use App\model\product_meta_colors;
use Image;
use Auth;
use Validator;
use Response;
use Cookie;
use Mail;
use PhpOffice\PhpSpreadsheet\IOFactory;
use URL;
use View;
use Input;


class MainController extends Controller
{


    protected $page = 1;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */





    public function index()
    {


        if (Input::has('s') || Input::has('cat')) {

            return $this->search();
        }

        //$this->update_user();
        //return view( _template('index') );
        return view(_template('new_index'));
    }

    public function search()
    {

        $cat_slug = Input::has('cat') ? Input::get('cat') : '';
        $query = Input::has('s') ? Input::get('s') : '';

        $category = $products = false;

        if ($cat_slug && $query) {
            if ($category = Category::where('slug', 'LIKE', '%' . slug($cat_slug) . '%')->where('status', 'active')->first()) {


                $products = $category->category_product()->where('title', 'LIKE', '%' . $query . '%')
                    ->orwhere('tags', 'LIKE', '%' . $query . '%')
                    ->orwhere('content', 'LIKE', '%' . $query . '%')
                    ->orderby('id', 'DESC')->where('status', 'active')
                    ->where('available', '>', 0)->paginate(12);
            } else {
                // $products = Product::whereHas('product_category', function($q){
                //                         $q->where('status', 'active');
                //                 })->where('title', 'LIKE', '%'. $query .'%')
                //             ->orwhere('tags', 'LIKE', '%' . $query . '%' )
                //             ->orwhere('content', 'LIKE', '%'. $query .'%')
                //             ->where('status', 'active')->where('available', '>', 0)->orderby('id', 'DESC')->paginate(12);

                $product = Product::whereHas('product_category', function ($q) use ($query) {
                    $q->where('name', 'LIKE', '%' . $query . '%');
                    $q->where('status', 'active');
                })->where('status', 'active')->where('available', '>', 0)->first();
                if ($product) {

                    // dd($product);
                    $products = Product::whereHas('product_category', function ($q) {
                        $q->where('status', 'active');
                    })->where('status', 'active')->where('available', '>', 0)
                        ->where('title', 'LIKE', '%' . $query . '%')
                        ->orwhere('tags', 'LIKE', '%' . $query . '%')
                        ->orwhere('content', 'LIKE', '%' . $query . '%')
                        ->orderby('id', 'DESC')->paginate(12);
                }
            }
        } else if ($cat_slug) {
            if ($category = Category::where('slug', 'LIKE', '%' . slug($cat_slug) . '%')->where('status', 'active')->first()) {
                $products = $category->category_product()->orderby('id', 'DESC')->where('status', 'active')->where('available', '>', 0)->paginate(12);
            } else if ($category = Category::where('name', 'LIKE', '%' . $cat_slug . '%')->where('status', 'active')->first()) {
                $products = $category->category_product()->orderby('id', 'DESC')->where('status', 'active')->where('available', '>', 0)->paginate(12);
            }
        } else if ($query) {


            $products = Product::with('product_category')->where('status', 'active')->where('available', '>', 0)
                        ->where(function($q) use($query) {
                            $q->where('title', 'LIKE', '%' . $query . '%');
                            //->orwhere('tags', 'LIKE', '%' . $query . '%');
                            //->orwhere('content', 'LIKE', '%' . $query . '%');
                        })
                        
                        ->orderby('id', 'DESC')->paginate(12);


            // if ($brand = Brand::where('name', 'LIKE', '%' . $query . '%')->first()) {
            //     $products = $brand->brand_product()->orderby('id', 'DESC')->where('status', 'active')->where('available', '>', 0)->paginate(12);
            // } else if ($brand = Brand::where('slug', 'LIKE', '%' . slug($query) . '%')->first()) {
            //     $products = $brand->brand_product()->orderby('id', 'DESC')->where('status', 'active')->where('available', '>', 0)->paginate(12);
            // } else if ($category = Category::where('name', 'LIKE', '%' . $query . '%')->where('status', 'active')->first()) {


            //     $products = $category->category_product()->orderby('id', 'DESC')->where('status', 'active')->where('available', '>', 0)->paginate(12);
            //     dd($products);
            // } else if ($category = Category::where('slug', 'LIKE', '%' . slug($query) . '%')->where('status', 'active')->first()) {
            //     $products = $category->category_product()->orderby('id', 'DESC')->where('status', 'active')->where('available', '>', 0)->paginate(12);
            // } else {
            //     $product = Product::whereHas('product_category', function ($q) use ($query) {
            //         $q->where('name', 'LIKE', '%' . $query . '%');
            //         $q->where('status', 'active');
            //     })->where('status', 'active')->where('available', '>', 0)->first();
            //     if ($product) {

            //         // dd($product);
            //         $products = Product::whereHas('product_category', function ($q) {
            //             $q->where('status', 'active');
            //         })->where('status', 'active')->where('available', '>', 0)
            //             ->where('title', 'LIKE', '%' . $query . '%')
            //             ->orwhere('tags', 'LIKE', '%' . $query . '%')
            //             ->orwhere('content', 'LIKE', '%' . $query . '%')
            //             ->orderby('id', 'DESC')->paginate(12);
            //     } else {

                    
            //     // dd($products);

            //     }


            //     // dd($products);
            // }
        } else {
            $products = Product::where('status', 'active')->where('available', '>', 0)->orderby('id', 'DESC')->paginate(12);
        }



        return view(_template('search'), ['products' => $products, 'category' => $category]);
    }

    public function update_user()
    {
        if (Auth::check()) {
            if (Order::where(['email' => Auth::user()->email, 'user_id' => null])->first())
                Order::where(['email' => Auth::user()->email, 'user_id' => null])->update(['user_id' => Auth::id()]);
        }
    }

    public function test()
    {
        $slug = 'personalised-gifts';

        $category = Category::where('slug', $slug)->first();
        if ($category) {
            $total = $category->product()->count();
            $products = $category->product()->orderby('id', 'DESC')->paginate(12);
        } else
            $products = false;


        $title = $category ? $category->name : 'Oops! content not found';
        return view(_template('category-test'), ['title' => $title, 'total' => $total, 'category' => $category, 'products' => $products]);
    }


    public function contact(Request $request)
    {

        if (!$request->ajax()) {
            return redirect(url('/'));
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|max:255|email',
                'subject' => 'required|max:255',
                'mobile' => 'required|min:10||max:10',
                'message' => 'required'
            ],
            [
                'name.required' => 'Name is required *',
                'name.max' => 'Name can have upto 255 characters!',

                'email.required' => 'Email address is required *',
                'email.max' => 'Email address can have upto 255 characters!',

                'subject.required' => 'Subject is required *',
                'subject.max' => 'Subject can have upto 255 characters!',
                'mobile.required' => 'mobile is required *',
                'mobile.max' => 'Enter valid mobile no!',
                'mobile.min' => 'Enter valid mobile no!',

                'message.required' => 'Message is required *'
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if (!Contact::create(['name' => $request->name, 'email' => $request->email, 'mobile' => $request->mobile, 'subject' => $request->subject, 'message' => $request->message]))
            return response()->json(['err' => 'Query could not sent, please try again!']);

        $subject = 'A New Query From Contact From';
        $to = Meta::where('meta_name', 'contact_email')->value('meta_Value');
        $body = View::make('emails.contact-query', ['request' => $request])->render();
        $body1 = View::make('emails.contact-query-revert', ['request' => $request])->render();
        $this->sendMail($subject, $body, $to, config('app.name'));

        $subject1 = 'Thanks for query ' . $request->name ?? '';
        $this->sendMailToUser($subject1, $body1, $to, config('app.name'), $request->email);

        return response()->json(['msg' => 'Query sent successfully!']);
    }


    protected function sendMailToAdmin($subject, $body, $to, $name)
    {

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Recipients
            $mail->setFrom('noreply@koxtonsmart.com', config('app.name'));
            $mail->addAddress('admin@koxtonsmart.com', $name);     // Add a recipient


            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    protected function sendMailToUser($subject, $body, $to, $name, $useremail)
    {

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Recipients
            $mail->setFrom('noreply@koxtonsmart.com', config('app.name'));
            $mail->addAddress($useremail, $name);     // Add a recipient


            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    protected function sendMail($subject, $body, $to, $name)
    {

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {

            /*$mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'surprisegeniegifts@gmail.com';                 // SMTP username
            $mail->Password = '*9634625229*';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to*/

            //Recipients
            $mail->setFrom('noreply@koxtonsmart.com', config('app.name'));
            $mail->addAddress('admin@koxtonsmart.com', $name);     // Add a recipient


            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    public function subscribe(Request $request)
    {

        if (!$request->ajax()) {
            return redirect(url('/'));
        }

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|max:255|email'
            ],
            [
                'email.required' => 'Email address is required *',
                'email.max' => 'Email address can have upto 255 characters!',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if ($id = Subscriber::where('email', $request->email)->value('id')) {
            Subscriber::where('id', $id)->update(['email' => $request->email]);
            return response()->json(['msg' => 'You have already subscribed us!']);
        }

        if (!Subscriber::create(['email' => $request->email]))
            return response()->json(['err' => 'Something went wrong, please try again later!']);

        return response()->json(['msg' => 'Thank you for subscribing us!']);
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
        //
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

    public function action(Request $request, $slug)
    {
         if (session()->has('original_slug')) {
        $slug = session('original_slug');
        session()->forget('original_slug'); // cleanup
    }

        if ($page = Post::where(['slug' => $slug, 'type' => 'page', 'status' => 'publish'])->first()) {

            if ($slug === 'contact-us') {
                $title = $page ? $page->title : 'Page not found!';
                return view(_template('contact'), ['title' => $title, 'page' => $page]);
            } else if ($slug === 'blogs') {
                // dd($slug);
                $blogs =  Post::where(['type' => 'post', 'status' => 'publish'])->paginate(9);
                return view(_template('blogs'), ['title' => 'Blogs', 'blogs' => $blogs]);
            } else {

                $title = $page ? $page->title : 'Page not found!';
                return view(_template('about'), ['title' => $title, 'page' => $page]);
            }
        // } else if ($slug === 'blogs') {

        //     $blogs =  Post::where(['type' => 'post', 'status' => 'publish'])->paginate(9);
        //     return view(_template('blogs'), ['title' => 'Blogs', 'blogs' => $blogs]);
        }else if ($slug === 'blogs') {
            $filter = $request->input('filter', 'latest'); // default filter is 'latest'

            $query = Post::where(['type' => 'post', 'status' => 'publish']);

            switch ($filter) {
                case 'popular':
                    $query->orderBy('views', 'DESC');
                    break;
                case 'all':
                    $query->inRandomOrder();
                    break;
                case '':
                default:
                    $query->orderBy('created_at', 'DESC');
                    break;
            }

            $blogs = $query->paginate(9)->appends(['filter' => $filter]);

            return view(_template('blogs'), [
                'title' => 'Blogs',
                'blogs' => $blogs,
                'filter' => $filter
            ]);
        

        } else if ($slug === 'contact-us') {

            $title = $page ? $page->title : 'contact-us!';
            return view(_template('contact'), ['title' => $title, 'page' => $page]);
        } else if ($slug === 'our-client') {

            $title = $page ? $page->title : 'Our Client';
            return view(_template('our_client'), ['title' => $title, 'page' => $page]);
        } else if ($slug === 'return') {
            return view(_template('return'), ['title' => 'Return & Refund']);
        } else {

            $category = Category::where('slug', $slug)->first();
            $parent = false;
            $sortby1 =  $category->order_by ?? 'latest';
            //$category = $parent ? Category::where(['slug' => $child, 'parent' => $parent->id])->first() : false;\
            $sortby = Input::has('sort-by') ? Input::get('sort-by') : $sortby1;

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


            $title = $category ? $category->name : 'Oops! page not found';
            return view(_template('product.index'), ['title' => $title, 'sortby' => $sortby, 'category' => $category, 'parent' => $parent, 'products' => $products]);


            /*$category = '';
            $products = '';
            $total = 0;*/

            /*if( isset( $_GET['sort-by'] ) && $_GET['sort-by'] === 'low_to_high' ) {
                
                if( $category ) {
                    $total = $category->category_product()->where('status', 'active')->count();
                    $products = $category->category_product()->where('status', 'active')->orderby('price', 'ASC')->paginate(12);
                }
                else
                    $products = false;
            }
            elseif( isset( $_GET['sort-by'] ) && $_GET['sort-by'] === 'high_to_low' ) {
                $category = Category::where('slug', $slug)->first();
                if( $category ) {
                    $total = $category->category_product()->where('status', 'active')->count();
                    $products = $category->category_product()->where('status', 'active')->orderby('price', 'DESC')->paginate(12);
                }
                else
                    $products = false;
            }
            else {
                $category = Category::where('slug', $slug)->first();
                if( $category ) {
                    $total = $category->category_product()->where('status', 'active')->count();
                    $products = $category->category_product()->where('status', 'active')->orderby('id', 'DESC')->paginate(12);
                    
                }
                else
                    $products = false;
            }*/

            /*switch ( $slug ) {
                case 'mens':
                    
                    $category = Category::where('slug', $slug)->first();
                    $title = $category ? $category->name : 'Oops! content not found';
                    return view( _template('product.index'), ['title' => $title, 'category' => $category]);

                    break;

                case 'womens':
                    
                    $category = Category::where('slug', $slug)->first();
                    $title = $category ? $category->name : 'Oops! content not found';
                    return view( _template('womens'), ['title' => $title, 'category' => $category]);
            
                    break;
                
                default:
                    // code...
                    break;
            }*/
        }
    }

    public function load(Request $request)
    {

        if (!$request->ajax()) {
            return redirect(url('/'));
        }

        $slug = false;
        if (isset($_GET['slug']))
            $slug = $_GET['slug'];
        if (isset($_GET['cat']))
            $slug = $_GET['cat'];

        $title = false;
        if (isset($_GET['s']))
            $title = $_GET['s'];

        /*if( !$slug ) {
            $data = ['products' => array()];
            return response()->json($data);
        }*/

        $sort_by = isset($_GET['sort_by']) && $_GET['sort_by'] ? $_GET['sort_by'] : 'latest';
        $type = isset($_GET['type']) && $_GET['type'] ? $_GET['type'] : '';

        $products = false;
        $per_page = 12;
        $category = Category::where('slug', $slug)->first();
        if ($category && $slug) {
            if ($sort_by === 'high_to_low')
                $products = $category->category_product()->where('status', 'active')->where('available', '>', 0)->orderby('price', 'DESC')->paginate($per_page);
            elseif ($sort_by === 'low_to_high')
                $products = $category->category_product()->where('status', 'active')->where('available', '>', 0)->orderby('price', 'ASC')->paginate($per_page);
            else
                $products = $category->category_product()->where('status', 'active')->where('available', '>', 0)->orderby('id', 'DESC')->paginate($per_page);
        } else if ($type === 'featured') {
            if ($sort_by === 'high_to_low')
                $products = Product::with('product_category')->where(['type' => 'featured', 'status' => 'active'])->where('available', '>', 0)->orderby('price', 'DESC')->paginate($per_page);
            elseif ($sort_by === 'low_to_high')
                $products = Product::with('product_category')->where(['type' => 'featured', 'status' => 'active'])->where('available', '>', 0)->orderby('price', 'ASC')->paginate($per_page);
            else
                $products = Product::with('product_category')->where(['type' => 'featured', 'status' => 'active'])->where('available', '>', 0)->orderby('id', 'DESC')->paginate($per_page);
        } else if ($type === 'new') {
            if ($sort_by === 'high_to_low')
                $products = Product::with('product_category')->where(['status' => 'active'])->where('available', '>', 0)->orderby('price', 'DESC')->paginate($per_page);
            elseif ($sort_by === 'low_to_high')
                $products = Product::with('product_category')->where(['status' => 'active'])->where('available', '>', 0)->orderby('price', 'ASC')->paginate($per_page);
            else
                $products = Product::with('product_category')->where(['status' => 'active'])->where('available', '>', 0)->orderby('id', 'DESC')->paginate($per_page);
        } else if ($title) {
            $products = Product::where('title', 'LIKE', '%' . $title . '%')
                ->orwhere('tags', 'LIKE', '%' . $title . '%')
                ->orwhere('content', 'LIKE', '%' . $title . '%')
                ->where('status', 'active')->where('available', '>', 0)->orderby('id', 'DESC')->paginate($per_page);
        } else {
            $products = Product::with('product_category')->where(['status' => 'active'])->where('available', '>', 0)->orderby('id', 'DESC')->paginate($per_page);
        }

        $array = array();
        $wishlist = Cookie::get('wishlistProduct');
        $wishListProduct = $wishlist ? json_decode($wishlist) : array();
        $url = URL::forceScheme('https');

        if ($category && $products && count($products)) {
            $page = ceil($products->total() / $per_page);
            $current = $products->currentPage();

            if ($current > $page) {
                $data = ['products' => false, 'msg' => 'No more products found!'];
                return response()->json($data);
            }

            foreach ($products as $row) {
                $price = $row->price;
                if ($row->discount)
                    $price = $row->price - ($row->price * $row->discount) / 100;
                if ($row->tax)
                    $price = $price + ($price * $row->tax) / 100;

                $array[] = array(
                    'id' => $row->id,
                    'product_id' => $row->product_id,
                    'cat_url' => $url . '/' . $category->slug . '/' . $row->slug . '/' . $row->product_id . '?source=category',
                    'img_url' => $url . 'public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1'))),
                    'title' => get_excerpt($row->title, 10),
                    'discount' => $row->discount,
                    'available' => $row->available,
                    'in_wishlist' => in_array($row->product_id, $wishListProduct) ? true : false,
                    'price' => $row->price,
                    'newPrice' => round($price)
                );
            }
        } else if ($products && count($products) > 0) {
            $page = ceil($products->total() / $per_page);
            $current = $products->currentPage();

            if ($current > $page) {
                $data = ['products' => false, 'msg' => 'No more products found!'];
                return response()->json($data);
            }

            foreach ($products as $row) {
                $price = $row->price;
                if ($row->discount)
                    $price = $row->price - ($row->price * $row->discount) / 100;
                if ($row->tax)
                    $price = $price + ($price * $row->tax) / 100;

                $array[] = array(
                    'id' => $row->id,
                    'product_id' => $row->product_id,
                    'cat_url' => $url . '/' . $row->product_category[0]->slug . '/' . $row->slug . '/' . $row->product_id . '?source=featured',
                    'img_url' => $url . 'public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1'))),
                    'title' => get_excerpt($row->title, 10),
                    'discount' => $row->discount,
                    'available' => $row->available,
                    'in_wishlist' => in_array($row->product_id, $wishListProduct) ? true : false,
                    'price' => $row->price,
                    'newPrice' => round($price)
                );
            }
        }

        $data = ['products' => $array];

        return response()->json($data);
    }



    public function more(Request $request)
    {

        if (!$request->ajax()) {
            return redirect(url('/'));
        }

        $per_page = 8;
        $products = Product::where('status', 'active')->orderby('updated_at', 'DESC')->paginate($per_page);

        $array = array();
        $wishlist = Cookie::get('wishlistProduct');
        $wishListProduct = $wishlist ? json_decode($wishlist) : array();
        $url = URL::forceScheme('https');

        if ($products && count($products)) {

            foreach ($products as $row) {
                $price = $row->price;
                if ($row->discount)
                    $price = $row->price - ($row->price * $row->discount) / 100;
                $slug = Category::where('id', $row->category_id)->value('slug');
                $array[] = array(
                    'id' => $row->id,
                    'product_id' => $row->product_id,
                    'cat_url' => $url . '/' . $slug . '/' . $row->slug . '/' . $row->product_id . '?source=home',
                    'img_url' => $url . 'public/' . product_file(thumb($row->feature_image, 200, 300)),
                    'title' => $row->title,
                    'discount' => $row->discount,
                    'available' => $row->available,
                    'in_wishlist' => in_array($row->product_id, $wishListProduct) ? true : false,
                    'price' => $row->price,
                    'newPrice' => round($price)
                );
            }
        }

        $data = ['products' => $array];

        return response()->json($data);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function check_availability(Request $request)
    {

        if (!$request->ajax()) {
            return redirect(url('/'));
        }

        $validator = Validator::make(
            $request->all(),
            ['pincode' => 'required|numeric|min:100000|max:999999'],
            [
                'pincode.required' => 'Enter pincode',
                'pincode.numeric' => 'Pincode must be valid!',
                'pincode.min' => 'Pincode must be valid!',
                'pincode.max' => 'Pincode must be valid!',
            ]
        );
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = '';
            if ($errors->has('pincode')) {
                $error = $errors->first('pincode');
            }
            return response()->json(['error' => $error, 200]);
        }

        if (Pincode::where(['pincode' => $request->pincode, 'status' => 'active'])->first()) {
            $pincode = Pincode::where(['pincode' => $request->pincode, 'status' => 'active'])->first();
            return response()->json(['msg' => 'Delivery available', 'pincode' => $pincode, 200]);
        }

        return response()->json(['error' => 'Please check another pincode!', 200]);
    }



    public function get_state(Request $request, $country_id)
    {
        if (!$request->ajax()) {
            return redirect(url('/'));
        }
        $states = State::where('country_id', $country_id)->get();
        return response()->json(['states' => $states, 200]);
    }

    public function get_city(Request $request, $state_id)
    {
        if (!$request->ajax()) {
            return redirect(url('/'));
        }

        $cities = City::where('state_id', $state_id)->get();
        return response()->json(['cities' => $cities, 200]);
    }



    public function validate_code(Request $request)
    {

        if (!$request->ajax())
            return;

        if (!$request->code)
            return response()->json(['code_err' => 'Enter coupon code *', 'valid' => false]);

        $coupon = Coupon::where(['code' => $request->code, 'status' => 'active'])
            ->orderby('id', 'DESC')->limit(1)->first(['id', 'usage_number', 'usage_amount', 'discount', 'start', 'end', 'discount_type']);
        if (!$coupon)
            return response()->json(['code_err' => 'Invalid coupon code *', 'valid' => false]);

        if ($coupon->start && $coupon->end) {

            $count = OrderMeta::where('coupon_id', $coupon->id)->get()->count();

            if ($coupon->usage_number && $count >= $coupon->usage_number) {
                return response()->json(['code_err' => 'Coupon has been expired!', 'valid' => false]);
            }

            $start = new \DateTime(date('Y-m-d H:i:s', strtotime($coupon->start)));
            $end = new \DateTime(date('Y-m-d H:i:s', strtotime($coupon->end)));
            $current = new \DateTime(date('Y-m-d H:i:s'));
            if ($start < $current && $end > $current) {

                $response = new Response(json_encode(['code_msg' => 'Coupon applied!', 'coupon' => $coupon, 'valid' => true]));

                if ($coupon->usage_amount) {
                    if ($coupon->usage_amount > $request->amount) {
                        return response()->json(['code_err' => 'This coupon can be applied when you shopping more than ' . $coupon->usage_amount, 'valid' => false]);
                    } else {
                        //return response()->json(['code_msg' => 'Coupon applied!', 'coupon' => $coupon, 'valid' => true]);
                        $json = json_encode(['coupon' => $coupon]);
                        $response->withCookie(cookie()->forever('customerUsedCoupon', $json));
                        return $response;
                    }
                } else
                    return response()->json(['code_msg' => 'Coupon applied!', 'coupon' => $coupon, 'valid' => true]);
            }

            return response()->json(['code_err' => 'Invalid coupon code *', 'valid' => false]);
        }

        return response()->json(['code_err' => 'Invalid coupon code *', 'valid' => false]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    // public function view_blog($slug)
    // {

    //     $blog = Post::where(['slug' => $slug, 'status' => 'publish', 'type' => 'post'])->first();
    //     $title = $blog ? $blog->title : 'Blog Not Found!';
    //     return view(_template('view-blog'), ['title' => $title, 'blog' => $blog]);
    // }
    public function view_blog($slug)
{
    $blog = Post::where([
        'slug' => $slug,
        'status' => 'publish',
        'type' => 'post'
    ])->first();

    if ($blog) {
        // Increment views count
        $blog->increment('views');
    }

    $title = $blog ? $blog->title : 'Blog Not Found!';

    return view(_template('view-blog'), [
        'title' => $title,
        'blog'  => $blog
    ]);
}


    public function get_product_color_variation(Request $request)
    {
        $data = product_meta_colors::where(['product_id' => $request->product_id, 'color' => $request->color_name])->first();
        return response()->json(['response' => $data]);
    }


    public function upload()
    {

        // $inputFileName = base_path() . '/assets/Pincodes.csv';
        $inputFileName = base_path() . '/assets/dd/domestic.xls';

        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        foreach ($sheetData as $key => $row) {
            // echo "<pre>";
            echo ($row['C']);
            // echo "</pre>";
            echo '<br>';
            if ($key !== 1) {
                $pincode = new Pincode();
                $pincode->pincode = $row['C'];
                $pincode->city = $row['E'];
                $pincode->state = $row['G'];
                $pincode->state_code = $row['T'];
                $pincode->status = 'active';
                $pincode->save();
            }

            // if( $key > 5 ) {



            //     break;
            // }

        }
    }
}
