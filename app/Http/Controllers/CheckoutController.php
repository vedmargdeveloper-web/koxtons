<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\model\Product;
use App\model\Category;
use Cookie;
use Session;
use Validator;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('gift/checkout/index', ['title' => 'Checkout']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**/
    }

    public function test() {
        return view('gift/checkout/test', ['title' => 'Checkout']);
    }

}