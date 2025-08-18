<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Post;
use App\User;
use Auth;

class MenuController extends Controller
{

    public function __construct() {
        $this->middleware('admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( !User::isAdmin() )
            return redirect( url('/') );
        
        $param = isset( $_GET['menu_name'] ) ? $_GET['menu_name'] : '';
        return view( _admin('menu.create'), ['title' => 'Menus', 'param' => $param] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if( !User::isAdmin() )
            return redirect( url('/') );
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if( !User::isAdmin() )
            return redirect( url('/') );

        if( !$request->menu_name || !$request->menu )
            return redirect()->back()->with('menu_err', 'Menu name is required*')->withInput();

        $array = array(
                        'user_id' => Auth::id(),
                        'title' => $request->menu_name,
                        'slug' => $request->menu_name,
                        'content' => $request->menu,
                        'type' => 'menu',
                        'status' => 'publish'
                    );
        if( Post::where('title', $request->menu_name)->first() ) {
            if( !Post::where('title', $request->menu_name)->update( $array ) )
                return redirect()->back()->with('menu_err', 'Menu could not update!')->withInput();

            return redirect()->back()->with('menu_msg', 'Menu updated successfully!');
        }
        if( !Post::create( $array ) )
            return redirect()->back()->with('menu_err', 'Menu could not create!')->withInput();

        return redirect()->back()->with('menu_msg', 'Menu created successfully!');
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
}
