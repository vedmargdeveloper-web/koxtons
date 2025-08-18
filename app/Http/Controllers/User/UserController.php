<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Avtar;
use App\model\UserDetail;
use App\model\Document;
use App\model\Message;


use Auth;
use Session;
use App\User;
use Validator;
use Hash;
use File;
use Image;
use Carbon\Carbon;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');    
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if( !User::isMember() )
            return redirect( url('/') );

        return view('gift.user.index', ['title' => 'Home']);
    }

    public function check_username( Request $request ) {

        if( !$request->ajax() )
            return;

        if( !Auth::check() )
            return;

        if( $user = User::where('username', $request->username)->first() )
            return response()->json(['message' => 'success', 'name' => ucwords($user->first_name.' '.$user->last_name)]);

        return response()->json(['message' => 'failed']);
    }


    public function change_password( Request $request ) {

        if( !User::isMember() )
            return redirect( url('/') );

        if( $request->method() === 'POST' ) {

            $validator = Validator::make( $request->all(), [
                                        'old_password' => 'required',
                                        'password' => 'required|max:255|min:8|confirmed',
                                        'password_confirmation' => 'required'
                            ]);

            $user = User::find(Auth::id());

            if( !Hash::check($request->old_password, $user->password) ) {
                $validator->errors()->add('old_password', 'Old password does not match!');
            }
            if( count($validator->errors()) < 1 ) {
                User::where('id', Auth::id())->update(['password' => Hash::make($request->password)]);
                $request->session()->flash('pass_msg', 'Password successfully updated!');
            }
            return view('gift.user.password', ['title' => 'Change Password'])->with('errors', $validator->errors());
        }

        return view('gift.user.password', ['title' => 'Change Password']);
    }


    public function edit_profile( Request $request ) {

        if( !User::isMember() )
            return redirect( url('/') );

        if( $request->method() === 'POST' ) {

            $validator = Validator::make( $request->all(), [
                                        'first_name' => 'required|max:255|string',
                                        'last_name' => 'required|max:255|string',
                                        'email' => 'required|email|unique:users,email,'.Auth::id()
                            ]);

            $user = User::find(Auth::id());
            if( count( $validator->errors() ) < 1 ) {

                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->save();

                $request->session()->flash('profile_msg', 'Profile successfully updated!');
                Auth::setUser($user);
            }

            $old = $request->flash();

            return view('gift.user.profile', ['title' => 'Edit Profile'])->with(['old' => $old, 'errors' => $validator->errors()]);
        }

        return view('gift.user.profile', ['title' => 'Edit Profile']);
    }


    public function document( Request $request ) {

        if( !User::isMember() )
            return redirect( url('/') );

        $user = User::with(['avtar', 'document'])->where('id', Auth::id())->first();

        if( $request->method() === 'POST' ) {

            $avtar = Avtar::where('user_id', Auth::id())->first();
            $error = true;
            if( !$avtar ) {
                $error = false;
                $request->session()->flash('avtar', 'Profile pic is required *');
            }

            $docs = Document::where('user_id', Auth::id())->get();

            if( !$docs->where('name', 'signature')->first() ) {
                $request->session()->flash('signature', 'Signature is required *');
                $error = false;
            }
            if( !$docs->where('name', 'pancard')->first() ) {
                $request->session()->flash('pancard', 'Pancard is required *');
                $error = false;
            }
            if( !$docs->where('name', 'aadhar')->first() ) {
                $request->session()->flash('aadhar', 'Aadhar is required *');
                $error = false;
            }
            if( !$docs->where('name', 'passbook')->first() ) {
                $request->session()->flash('passbook', 'Passbook is required *');
                $error = false;
            }

            return view('gift.user.document', ['title' => 'Upload Documents'])->with('user', $user);
        }

        return view('gift.user.document', ['title' => 'Upload Documents'])->with('user', $user);
    }


    public function contact( Request $request ) {

        if( !User::isMember() )
            return redirect( url('/') );

        if( $request->method() === 'POST' ) {

            $validator = Validator::make( $request->all(), [
                                        'gender' => 'required|max:10',
                                        'mobile' => 'required|numeric|max:9999999999',
                                        'country' => 'required|max:50',
                                        'state' => 'required|max:50',
                                        'city' => 'required|max:50',
                                        'address' => 'required|max:255',
                                        'landmark' => 'nullable|max:255',
                                        'pincode' => 'nullable|numeric|min:100000|max:999999'
                            ],[
                                        'gender.required' => 'Gender is required *',
                                        'gender.max' => 'Gender can have upto 255 characters!',

                                        'mobile.required' => 'Mobile no. is required *',
                                        'mobile.numeric' => 'Mobile no. must be 10 digit number!',
                                        'mobile.max' => 'Mobile no. must be 10 digit number!',

                                        'country.required' => 'Country is required *',
                                        'country.max' => 'Country name can have upto 50 characters!',
                                        'state.required' => 'State is required *',
                                        'state.max' => 'State name can have upto 50 characters!',
                                        'city.required' => 'City is required *',
                                        'city.max' => 'City name can have upto 50 characters!',

                                        'address.required' => 'Address is required *',
                                        'address.max' => 'Address can have upto 255 characters!',

                                        'landmark.required' => 'Landmark is required *',
                                        'landmark.max' => 'Landmark can have upto 255 characters!',

                                        'pincode.required' => 'Pincode is required *',
                                        'pincode.numeric' => 'Pincode must be valid 6 digit number!',
                                        'pincode.max' => 'Pincode must be valid 6 digit number!',
                                        'pincode.min' => 'Pincode must be valid 6 digit number!',
                            ]);



            
            $userdetail = UserDetail::where('user_id', Auth::id())->first();
            if( count( $validator->errors() ) < 1 ) {
                if( !$userdetail )
                    $userdetail = new UserDetail;

                    $userdetail->user_id = Auth::id();
                    $userdetail->gender = $request->gender;
                    $userdetail->mobile = $request->mobile;
                    $userdetail->country = $request->country;
                    $userdetail->state = $request->state;
                    $userdetail->city = $request->city;
                    $userdetail->address = $request->address;
                    $userdetail->landmark = $request->landmark;
                    $userdetail->pincode = $request->pincode;
                    $userdetail->save();

                $request->session()->flash('profile_msg', 'Details successfully updated!');
            }

            $old = $request->flash();

            return view('gift.user.contact', ['title' => 'Edit Contact Details'])->with(['old' => $old, 'errors' => $validator->errors()]);
        }

        return view('gift.user.contact', ['title' => 'Edit Contact Details']);
    }

    public function bank( Request $request ) {

        if( !User::isMember() )
            return redirect( url('/') );

        if( $request->method() === 'POST' ) {

            $validator = Validator::make( $request->all(), [
                                        'bank_name' => 'required|max:255',
                                        'account_holder_name' => 'required|max:255',
                                        'account_no' => 'required|max:50',
                                        'bank_ifsc' => 'required|max:20',
                                        'bank_address' => 'required|max:255',
                            ],[
                                        'bank_name.required' => 'Bank name is required *',
                                        'bank_name.max' => 'Bank name can have upto 255 characters!',

                                        'account_holder_name.required' => 'Acc holder name is required *',
                                        'account_holder_name.max' => 'Acc holder name can have upto 255 characters!',

                                        'account_no.required' => 'Account no. is required *',
                                        'account_no.max' => 'Account no. name can have upto 50 characters!',

                                        'bank_ifsc.required' => 'IFSC code is required *',
                                        'bank_ifsc.max' => 'IFSC code name can have upto 20 characters!',

                                        'bank_address.required' => 'Bank address is required *',
                                        'bank_address.max' => 'Bank address can have upto 255 characters!'
                            ]);



            
            $userdetail = UserDetail::where('user_id', Auth::id())->first();
            if( count( $validator->errors() ) < 1 ) {
                if( !$userdetail )
                    $userdetail = new UserDetail;

                    $userdetail->user_id = Auth::id();
                    $userdetail->bank_name = $request->bank_name;
                    $userdetail->bank_ifsc = $request->bank_ifsc;
                    $userdetail->account_no = $request->account_no;
                    $userdetail->account_holder_name = $request->account_holder_name;
                    $userdetail->bank_address = $request->bank_address;
                    $userdetail->save();

                $request->session()->flash('profile_msg', 'Bank details successfully updated!');
            }

            $old = $request->flash();

            return view('gift.user.bank', ['title' => 'Edit Bank Details'])->with(['old' => $old, 'errors' => $validator->errors()]);
        }

        return view('gift.user.bank', ['title' => 'Edit Bank Details']);
    }


    public function store_avtar( Request $request ) {

        if( !User::isMember() )
            return;

        if( !Auth::check() )
            return;

        $validator = Validator::make( $request->all(), [
                                        'image' => 'required|mimes:jpg,png,jpeg|max:1024'
                            ]);
        if( $validator->fails() )
            return response()->json(['errors' => $validator->errors(), 'validation' => 'failed']);

        if( !$request->hasFile('image') ) return false;

        $image = $request->file('image');
        
        return response()->json(['file_url' => $this->upload_file( $image ) , 'validation' => 'success']);
    }

    private function upload_file( $image, $user_id = '' ) {

        $user_id = $user_id ? $user_id : Auth::id();

        $hashFileName = md5( $image->getClientOriginalName() . time() );

        $width = 120;
        $height = 120;
        $img_resize = Image::make( $image->getRealPath() )->resize( $width, $height )->encode($image->getClientOriginalExtension());
        $filename = $hashFileName .'-' . $width . 'x' . $height . '.' . $image->getClientOriginalExtension();
        $img_resize->save( public_path( 'images/avtars/' . $filename ) );

        $width = 40;
        $height = 40;
        $img_resize = Image::make( $image->getRealPath() )->resize( $width, $height )->encode($image->getClientOriginalExtension());
        $filename = $hashFileName .'-' . $width . 'x' . $height . '.' . $image->getClientOriginalExtension();
        $img_resize->save( public_path( 'images/avtars/' . $filename ) );

        $img_resize = Image::make( $image->getRealPath() )->encode($image->getClientOriginalExtension());
        $filename = $hashFileName .'.' . $image->getClientOriginalExtension();
        $img_resize->save( public_path( 'images/avtars/' . $filename ) );

        $file_url = asset('public/images/avtars/' . $hashFileName .'-120x120.' . $image->getClientOriginalExtension() );

        if( $avtar = Avtar::where('user_id', $user_id)->first() ) {
            if( is_file( public_path('images/avtars/'.$avtar->filename) ) ) {
                File::delete( public_path('images/avtars/'.$avtar->filename) );
            }
            if(is_file(public_path('images/avtars/'.get_filename($avtar->filename).'-120x120.'.get_extension($avtar->filename)))){
                File::delete(public_path('images/avtars/'.get_filename($avtar->filename).'-120x120.'.get_extension($avtar->filename)));
            }
            if(is_file(public_path('images/avtars/'.get_filename($avtar->filename).'-40x40.'.get_extension($avtar->filename)))){
                File::delete(public_path('images/avtars/'.get_filename($avtar->filename).'-40x40.'.get_extension($avtar->filename)));
            }

            Avtar::where('id', $avtar->id)->update(['filename' => $filename]);
        }
        else
            Avtar::create(['user_id' => $user_id, 'filename' => $filename]);

        return $file_url;
    }


    public function store_document( Request $request ) {

        if( !User::isMember() && !User::isSeller() )
            return;

        if( !Auth::check() )
            return;

        $validator = Validator::make( $request->all(), [
                                        'uid' => 'required',
                                        'avtar' => 'nullable|mimes:jpg,png,jpeg|max:1024',
                                        'signature' => 'nullable|mimes:jpg,png,jpeg|max:1024',
                                        'pancard' => 'nullable|mimes:jpg,png,jpeg|max:1024',
                                        'aadhar' => 'nullable|mimes:jpg,png,jpeg|max:1024',
                                        'passbook' => 'nullable|mimes:jpg,png,jpeg|max:1024',
                            ],[
                                        'avtar.mimes' => 'Image must be jpg, png or jpeg only!',
                                        'signature.mimes' => 'Signature must be jpg, png or jpeg only!',
                                        'pancard.mimes' => 'PAN card must be jpg, png or jpeg only!',
                                        'aadhar.mimes' => 'Aadhar must be jpg, png or jpeg only!',
                                        'passbook.mimes' => 'Passbook must be jpg, png or jpeg only!',

                                        'avtar.max' => 'Image size must be less than 1MB!',
                                        'signature.max' => 'Signature size must be less than 1MB!',
                                        'pancard.max' => 'PAN card size must be less than 1MB!',
                                        'aadhar.max' => 'Aadhar size must be less than 1MB!',
                                        'passbook.max' => 'Passbook size must be less than 1MB!',
                                        'uid.required' => 'OOPS! something went wrong.',
                            ]);
        if( $validator->fails() )
            return response()->json(['errors' => $validator->errors(), 'validation' => 'failed']);

        $user = User::where('uid', $request->uid)->first();
        if( !$user )
            return response()->json(['errors' => ['message' => 'OOPS! something went wrong.'], 'validation' => 'failed']);

        $path = false;
        $name = '';
        if( $request->avtar ) {
            $name = 'avtar';
            $path = $request->file('avtar')->store('files', 'public');

            $image = $request->file('avtar');
            $this->upload_file($image, $user->id);
        }
        if( $request->signature ) {
            $name = 'signature';
            $path = $request->file('signature')->store('files', 'public');
        }
        if( $request->pancard ) {
            $name = 'pancard';
            $path = $request->file('pancard')->store('files', 'public');
        }
        if( $request->aadhar ) {
            $name = 'aadhar';
            $path = $request->file('aadhar')->store('files', 'public');
        }
        if( $request->passbook ) {
            $name = 'passbook';
            $path = $request->file('passbook')->store('files', 'public');
        }

        if( $path ) {

            $docs = Document::where('user_id', $user->id)->get();
            $error = true;
            if( !$docs->where('name', 'signature')->first() )
                $error = false;
            if( !$docs->where('name', 'pancard')->first() )
                $error = false;
            if( !$docs->where('name', 'aadhar')->first() )
                $error = false;
            if( !$docs->where('name', 'passbook')->first() )
                $error = false;
            if( !$docs->where('name', 'avtar')->first() )
                $error = false;
            if( $error ) {
                User::where('id', Auth::id())->update(['profile' => 'completed']);
            }

            if ( $doc = Document::where(['name' => $name, 'user_id' => $user->id])->first() ) {
                $doc->filename = $path;
                $doc->status = null;
                $doc->save();
            }
            else
                Document::create(['user_id' => $user->id, 'status' => null, 'name' => $name, 'filename' => $path]);
            
            return response()->json(['file_url' => asset('storage/app/public/'  .$path) , 'validation' => 'success']);
        }

        return response()->json(['validation' => 'failed']);
    }




    public function messages()
    {
        if( !User::isMember() )
            return redirect( url('/') );

        return view('seller.message', ['title' => 'Messages']);
    }

    public function set_read( Request $request ) {
        
        if( !$request->ajax() )
            return;

        if( !User::isMember() )
            return;

        if( !$request->id )
            return;

        $message = Message::find($request->id);

        if( !$message )
            return;

        if( $message->receiver_id != Auth::id() )
            return;

        $message->seen = 1;
        $message->save();

        return response()->json(['message' => 'success']);
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


    public function logout() {

        Auth::logout();
        Session::flush();
        return redirect( route('login') );
    }
}
