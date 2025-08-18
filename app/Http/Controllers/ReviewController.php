<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\ReviewRequest;
use App\Http\Controllers\FileManager;
use App\User;
use App\model\Review;
use App\model\Product;
use App\model\ProductReview;
use Cookie;
use Hash;
use View;
use Mail;
use Auth;
use Validator;
use Image;
use File;

class ReviewController extends Controller
{
    protected $thumb = [150, 150];
    protected $medium = [300, 300];

    public function __construct()
    {
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( !Auth::check() )
            return redirect()->route('login');

        return view('auth.passwords.change');
    }


    public function store( ReviewRequest $request ) {

        if( $request->ajax() )
            return;

        $product = Product::where('product_id', $request->product_id)->first();

        if( !$product )
            return redirect()->back()->with('review_err', 'Something went wrong, try again later!')->withInput();

        $review = new Review();
        $review->review = $request->review;
        
        $files = array();
        if( $request->hasFile('files') ) {
            foreach( $request->file('files') as $file ) {
                $files[] = $this->upload_gallery( $file );
            }
        }
        $dd = implode(',', $files);

        $review->rating = $request->star;
        $review->product_id = $request->product_id;
        $review->user_id = Auth::check() ? Auth::id() : null;
        $review->name = $request->name;
        $review->file = $dd;
        $review->email = $request->email;
        $review->save();

        ProductReview::create(['product_id' => $product->id, 'review_id' => $review->id, 'user_id' => Auth::check() ? Auth::id() : null]);

        return redirect()->back()->with('review_msg', '');

    }


    public function upload_gallery( $image ) {
        $hashname = clean( $image->getClientOriginalName() ) . '-' . randomString(8);
        $filename = $hashname . '-' . config('filesize.thumbnail.0') . 'x' . config('filesize.thumbnail.1') . '.' . $image->getClientOriginalExtension();
        FileManager::upload( $filename, $image, public_path( product_file() ), config('filesize.thumbnail.0'), config('filesize.thumbnail.1') );

        $filename = $hashname . '-' . config('filesize.large.0') . 'x' . config('filesize.large.1') .
                    '.' . $image->getClientOriginalExtension();
        FileManager::upload( $filename, $image, public_path( product_file() ), config('filesize.large.0'), config('filesize.large.1') );

        $filename = $hashname . '.' . $image->getClientOriginalExtension();
        FileManager::upload( $filename, $image, public_path( product_file() ) );

        return $filename;
    }




}