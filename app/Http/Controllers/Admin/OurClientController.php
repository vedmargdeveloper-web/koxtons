<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\FileManager as File;
use App\model\Slide;
use App\model\OurClient;
use App\User;
use Image;
use Validator;
use Auth;
use App\model\LogsModel;

class OurClientController extends Controller
{
    protected $thumb = [130, 140];

    public function __construct() {

        // $this->middleware('admin');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        return view( _admin('ourclient.index'), ['title' => 'Our client'] );
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

        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        $validator = Validator::make([
                            'title' => 'required|max:255',
                            'file' => 'nullable|mimes:jpg,jpeg,gif,png|max:5000'
                ],
                [
                        'title.required' => 'Title is required *',
                        'title.max' => 'Title can have upto 255 characters!',
                        'file.mimes' => 'File must be jpg, jpeg, gif, png only!',
                        'file.max' => 'File must be less than 5MB!'
                ]);

        if( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $image = $request->hasFile('file') ? $this->upload( $request->file('file') ) : null;

        $slide = new OurClient();
        $slide->user_id = Auth::id();
        $slide->title = $request->title;
        $slide->content = '';
        $slide->image = $image;
        $slide->image_alt = $request->image_alt;
        $slide->status = $request->submit ? 'active' : 'inactive';
        if( $slide->save() ){
            LogsModel::create(['user_id' => Auth::id(),'remark'=>'Update OurClient','status'=>'OurClient', 'working_id' => $slide->id]);
            return redirect()->back()->with('slide_msg', 'Client created successfully!');
        }

        return redirect()->back()->with('slide_err', 'Client could not create!');
    }

    private function upload( $image ) {
        
        $hashname = clean( $image->getClientOriginalName() ) . '-' . randomString(8);
        $filename = $hashname . '-' . $this->thumb[0] . 'x' . $this->thumb[1] . '.' . $image->getClientOriginalExtension();
        File::upload( $filename, $image, public_path( public_file() ), $this->thumb[0],$this->thumb[1] );
        
        $filename = $hashname . '.' .$image->getClientOriginalExtension();
        File::upload( $filename, $image, public_path( public_file() ) );

        return $filename;
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
        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        $slide = OurClient::find( $id );
        return  view( _admin('ourclient.edit'), ['title' => 'Edit', 'slide' => $slide] );
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

        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        $slide = OurClient::findOrFail( $id );
        if( !$slide )
            return redirect()->back()->with('slide_err', 'Slide not found!');

        $validator = Validator::make([
                            'title' => 'required|max:255',
                            'file' => 'nullable|mimes:jpg,jpeg,gif,png|max:5000'
                ],
                [
                        'title.required' => 'Title is required *',
                        'title.max' => 'Title can have upto 255 characters!',
                        'file.mimes' => 'File must be jpg, jpeg, gif, png only!',
                        'file.max' => 'File must be less than 5MB!'
                ]);

        if( $validator->fails() ) {

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $image = $request->hasFile('file') ? $this->upload( $request->file('file') ) : $request->filename;

        $array['user_id'] = Auth::id();
        $array['title'] = $request->title;
        $array['content'] = '';
        $array['image'] = $image;
        $array['image_alt'] = $request->image_alt;
        $array['status'] = $request->submit ? 'active' : 'inactive';
        if( $slide->fill($array)->save() )

            LogsModel::create(['user_id' => Auth::id(),'remark'=>'Update OurClient','status'=>'OurClient', 'working_id' => $id]);
            return redirect()->back()->with('slide_msg', 'Client updated successfully!');

        return redirect()->back()->with('slide_err', 'Client could not update!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if( !User::isAdmin() )
        //     return redirect( url('/') );
        
        if( OurClient::where('id', $id)->delete() )
            return redirect()->back()->with('slide_msg', 'Client deleted successfully!');

        return redirect()->back()->with('slide_err', 'Client could not delete!');
    }
}
