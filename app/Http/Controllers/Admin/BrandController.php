<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\FileManager as File;

use App\model\Brand;
use App\User;
use Image;
use Auth;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $thumb = [270, 225];
    protected $medium = [550, 360];

    public function __construct() {

        $this->middleware('auth');
    }


    public function index()
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        return view( _admin('brand/index'), ['title' => 'Brands'] );
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

        if( !User::isAdmin() )
            return redirect( url('/') );

        $this->validate( $request, [
                            'name' => 'required|max:255|unique:brands',
                            'icon' => 'nullable|max:255',
                            'description' => 'nullable',
                            'file' => 'nullable|mimes:jpg,jpeg,png|max:1024',

            ]);

        $filename = null;
        if( $request->hasFile( 'file' ) ) {
            $image = $request->file('file');
            $filename = $this->upload( $image );
        }

        $array = array(
                        'user_id' => Auth::id(),
                        'name' => $request->name,
                        'slug' => slug($request->name),
                        'icon' => $request->icon,
                        'description' => $request->description,
                        'feature_image' => $filename
                    );

        if( Brand::create( $array ) )
            return redirect()->back()->with('brand_msg', 'Brand name successfully created!');

        return redirect()->back()->withErrors('brand_err', 'Brand name could not create!');
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
        if( !User::isAdmin() )
            return redirect( url('/') );

        $brand = Brand::find($id);

        return view( _admin('brand/edit'), ['title' => 'Edit Brand', 'brand' => $brand] );
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
        if( !User::isAdmin() )
            return redirect( url('/') );

        $brand = Brand::findOrFail( $id );

        $this->validate( $request, [
                            'name' => 'required|max:255|unique:brands,name,'.$id,
                            'icon' => 'nullable|max:255',
                            'description' => 'nullable',
                            'file' => 'nullable|mimes:jpg,jpeg,png|max:1024',

            ]);

        $filename = null;
        if( $request->hasFile( 'file' ) ) {
            $image = $request->file('file');
            $filename = $this->upload( $image );
        }

        $array = array(
                        'name' => $request->name,
                        'slug' => $request->slug ? slug($request->slug) : slug($request->name),
                        'icon' => $request->icon,
                        'description' => $request->description,
                        'feature_image' => $filename
                    );

        $brand->fill($array)->save();
        return redirect()->back()->with('brand_msg', 'Brand name successfully updated!');
    }


    private function upload( $image ) {
        $hashname = md5($image->getClientOriginalName().time());
        $filename = $hashname . '-' . $this->thumb[0] . 'x' . $this->thumb[1] . '.' . $image->getClientOriginalExtension();
        File::upload($filename, $image, public_path(public_file()), $this->thumb[0],$this->thumb[1]);

        $filename = $hashname . '-' . $this->medium[0] . 'x' . $this->medium[1] .
                    '.' . $image->getClientOriginalExtension();
        File::upload( $filename, $image, public_path( public_file() ), $this->medium[0], $this->medium[1] );

        $filename = $hashname . '.' . $image->getClientOriginalExtension();
        File::upload( $filename, $image, public_path( public_file() ) );

        return $filename;
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
