<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\FileManager as File;
use App\model\Slide;
use App\User;
use Image;
use Validator;
use Auth;
use App\model\Pincode;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\model\LogsModel;


class SliderController extends Controller
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

        return view( _admin('slide.index'), ['title' => 'Slides'] );
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
                            'see_more' => 'nullable|max:50',
                            'see_more_link' => 'nullable|max:255',
                            'position' => 'required',
                            'file' => 'nullable|mimes:jpg,jpeg,gif,png,mp4|max:10000'
                ],
                [
                        'title.required' => 'Title is required *',
                        'position.required' => 'position is required',
                        'title.max' => 'Title can have upto 255 characters!',
                        'see_mode.max' => 'Button name can have upto 50 characters!',
                        'see_mode_link.max' => 'Button link can have upto 255 characters!',
                        'file.mimes' => 'File must be jpg, jpeg, gif, png only!',
                        'file.max' => 'File must be less than 5MB!'
                ]);

        if( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        
        if($request->type =='video'){
            $file = $request->file('file');
            $filename = randomString(8).$file->getClientOriginalName();

            $path = public_path( public_file('video') );

            // echo $path; die();

            $file->move($path, $filename);


            $image = $filename;
        }else{
            $image = $request->hasFile('file') ? $this->upload( $request->file('file')) : null;
        }

        $slide = new Slide();
        $slide->user_id = Auth::id();
        $slide->title = $request->title;
        $slide->type = $request->type;
        $slide->see_more = $request->see_more;
        $slide->see_more_link = $request->see_more_link;
        $slide->image = $image;
        $slide->position = $request->position;
        $slide->description = $request->description;
        $slide->status = $request->submit ? 'active' : 'inactive';
        if( $slide->save() )

        LogsModel::create(['user_id' => Auth::id(),'remark'=>'Create '.$request->type,'status'=>$request->type, 'working_id' => $slide->id]);

            return redirect()->back()->with('slide_msg', 'Slide created successfully!');

        return redirect()->back()->with('slide_err', 'Slide could not create!');
    }


// video upload krne hai 

    private function upload( $image ) {
            $hashname = clean( $image->getClientOriginalName() ) . '-' . randomString(8);
            $filename = $hashname . '-' . $this->thumb[0] . 'x' . $this->thumb[1] . '.' . $image->getClientOriginalExtension();

            
                $filename = $hashname . '-' . $this->thumb[0] . 'x' . $this->thumb[1] . '.' . $image->getClientOriginalExtension();
                File::upload( $filename, $image, public_path( public_file() ), $this->thumb[0],$this->thumb[1] );
            
            
            $filename = $hashname . '.' .$image->getClientOriginalExtension();
            File::upload( $filename, $image, public_path( public_file() ) );


        return $filename;
    }


    public function pincode(){
        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        return view( _admin('slide.pincode'), ['title' => 'Pincodes'] );
    }



    public function upload_pincode(Request $request) {
        $file = $request->file('file');
        $filename = randomString(8).$file->getClientOriginalName();

        $path = public_path( public_file('video') );

        // echo $path; die();

        $file->move($path, $filename);
        
        // $inputFileName = base_path() . '/assets/Pincodes.csv';
        // $inputFileName = base_path() . '/assets/dd/domestic.xls';
        $inputFileName = public_path(public_file('video/'.$filename));

        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        foreach( $sheetData as $key => $row ) {
            if($key !==1){
                $pincode = new Pincode();
                $pincode->pincode = $row['A'];
                $pincode->delivery_time = $row['B'];
                $pincode->status = 'active';
                $pincode->save();

            }
        }
        // LogsModel::create(['user_id' => Auth::id(),'remark'=>'Add Pincode','status'=>'pincode', 'working_id' => '']);
        return redirect()->back()->with('slide_msg', 'Pincode updated successfully!');
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

        $slide = Slide::find( $id );
        return  view( _admin('slide.edit'), ['title' => 'Edit', 'slide' => $slide] );
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

        $slide = Slide::findOrFail( $id );
        if( !$slide )
            return redirect()->back()->with('slide_err', 'Slide not found!');

        $validator = Validator::make([
                            'title' => 'required|max:255',
                            'see_more' => 'nullable|max:50',
                            'see_more_link' => 'nullable|max:255',
                            'position' => 'required',
                            'file' => 'nullable|mimes:jpg,jpeg,gif,png|max:5000'
                ],
                [
                        'title.required' => 'Title is required *',
                        'title.max' => 'Title can have upto 255 characters!',
                        'position.required' => 'position is required',
                        'see_mode.max' => 'Button name can have upto 50 characters!',
                        'see_mode_link.max' => 'Button link can have upto 255 characters!',
                        'file.mimes' => 'File must be jpg, jpeg, gif, png only!',
                        'file.max' => 'File must be less than 5MB!'
                ]);

        if( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->type =='video'){
            if($request->hasFile('file')){
                $file = $request->file('file');
                $filename = randomString(8).$file->getClientOriginalName();
                $path = public_path( public_file('video') );
                $file->move($path, $filename);
                $image = $filename;
            }else{
                $image = $request->filename;
            }
           
        }else{
             $image = $request->hasFile('file') ? $this->upload( $request->file('file') ) : $request->filename;
        }

       

        $array['user_id'] = Auth::id();
        $array['title'] = $request->title;
        $array['type'] = $request->type;
        $array['see_more'] = $request->see_more;
        $array['see_more_link'] = $request->see_more_link;
        $array['position'] = $request->position;
        $array['description'] = $request->description;
        $array['image'] = $image;
        $array['status'] = $request->submit ? 'active' : 'inactive';
        if( $slide->fill($array)->save() )

        LogsModel::create(['user_id' => Auth::id(),'remark'=>'Update '.$request->type,'status'=>$request->type, 'working_id' => $id]);
            return redirect()->back()->with('slide_msg', 'Slide updated successfully!');

        return redirect()->back()->with('slide_err', 'Slide could not update!');
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

        $dd = Slide::where('id', $id)->first();
        LogsModel::create(['user_id' => Auth::id(),'remark'=>'Create '.$dd->type,'status'=>$dd->type, 'working_id' => $id]);
        if( Slide::where('id', $id)->delete() )

            return redirect()->back()->with('slide_msg', 'Slide deleted successfully!');

        return redirect()->back()->with('slide_err', 'Slide could not delete!');
    }
}
