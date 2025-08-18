<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\model\Meta;
use App\User;
use Image;
use Auth;

class MetaController extends Controller
{

    public function __construct() {
        $this->middleware('admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $param )
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        switch ( $param ) {
            
            case 'header':
                
                return view( _admin('meta.header'), ['title' => 'Header setting'] );
                break;

            case 'footer':
                
                return view( _admin('meta.footer'), ['title' => 'Footer setting'] );
                break;

            case 'contact':
                
                return view( _admin('meta.contact'), ['title' => 'Contact setting'] );
                break;

            case 'change-password':

                return view( _admin('change-password'), ['title' => 'Change password'] );
                break;
            
            default:
                # code...
                break;
        }
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
        
        foreach ($request->except(['_token', 'app_logo']) as $key => $value) {
            
            if( Meta::where('meta_name', $key)->first() )
                Meta::where('meta_name', $key)->update(['meta_value' => $value]);
            else
                Meta::create(['meta_name' => $key, 'meta_value' => $value]);
        }

        if( $request->file() ) :

            foreach( $request->file() as $key => $image ) :

                $this->upload_file( $image );
                
                if( Meta::where('meta_name', $key)->first() )
                    Meta::where('meta_name', $key)->update( ['meta_value' => $image->getClientOriginalName()] );
                else
                    Meta::create( ['meta_name' => $key, 'meta_value' => $image->getClientOriginalName()] );

            endforeach;

        endif;

        return redirect()->back()->with('meta_msg', 'Setting saved!');
    }

    private function upload_file( $image ) {

        $img_resize = Image::make( $image->getRealPath() )->encode($image->getClientOriginalExtension());
        $file = $image->getClientOriginalName();

        return $img_resize->save( public_path( public_file( $file ) ) ) ? $file : false;
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
