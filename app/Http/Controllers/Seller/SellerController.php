<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\model\UserDetail;
use App\model\Avtar;
use App\model\Document;
use App\model\Message;
use Auth;
use App\User;
use Validator;
use Hash;
use Image;
use File;

class SellerController extends Controller
{

    /*public function __construct()
    {
        $this->middleware('auth');    
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if( Auth::check() ) {
            if( User::isSeller() )
                return redirect()->route('seller.home');

            return redirect('/');
        }

        return view('seller.login', ['title' => 'Seller Login']);
    }

    public function register()
    {

        if( Auth::check() ) {
            if( User::isSeller() )
                return redirect()->route('seller.home');

            return redirect('/');
        }

        return view('seller.register', ['title' => 'Seller Signup']);
    }


    public function login( Request $request ) {

        if( Auth::check() ) {
            if( User::isSeller() )
                return redirect()->route('seller.home');

            return redirect('/');
        }

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ],
        [
            'email.required' => 'Username is required *',
            'password.required' => 'Password is required *',
        ]);

        //$field = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        //$request->merge([$field => $request->input('username')]);

        if( User::where(['email' => $request->email, 'status' => 'inactive'])->value('email') )
            return redirect()->route('seller')->with('message', 'Your account is not active, please contact to admin');

        if( !User::where(['role' => 'seller', 'email' => $request->email])->value('email') )
            return redirect()->route('seller')->with('message', 'Invalid username or password!');

        if (Auth::attempt($request->only('email', 'password')))
        {

            if( Auth::user()->profile !== 'completed' )
                return redirect()->route('seller.setup', Auth::user()->uid);

            return redirect()->route('seller.home');
        }

        return redirect()->route('seller')->with([
                'message' => 'Invalid username or password!',
        ]);
    }


    public function signup( Request $request ) {

        if( Auth::check() ) {
            if( User::isSeller() )
                return redirect()->route('seller.home');

            return redirect('/');
        }

        $this->validate($request, [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|max:255|email|unique:users',
                'password' => 'required|min:8|max:255',
                'tnc' => 'required'
        ],
        [
                'first_name.required' => 'First name is required *',
                'first_name.max' => 'First name can have upto 255 characters!',
                'last_name.required' => 'Last name is required *',
                'last_name.max' => 'First name can have upto 255 characters!',
                'email.required' => 'Email is required *',
                'email.max' => 'Email can have upto 255 characters!',
                'email.email' => 'Email must be valid!',
                'email.unique' => 'Email already exist!',
                'password.required' => 'Password is required *',
                'password.max' => 'Password can have upto 255 characters!',
                'password.min' => 'Password must have atleast 8 characters!',
                'password.confirmed' => 'Password & confirmed password does not match!',

                'tnc.required' => 'Please accept the terms & conditions!',
        ]);

        $user = new User();
        $user->role = 'seller';
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->status = null;
        $user->uid = uniqueID(16);
        $user->password = Hash::make( $request->password );
        $user->username = generate_username($request);
        $user->save();

        UserDetail::create(['tnc' => $request->tnc, 'user_id' => $user->id]);
        
        Auth::login($user);

        return redirect()->route('seller.setup', $user->uid);
    }


    public function setup( $uid ) {

        if( !User::isSeller() )
            return redirect('/');

        $user = User::with('userdetail')->where('uid', $uid)->first();

        return view('seller.setup', ['title' => 'Seller Profile Setup', 'user' => $user]);
    }


    public function store_setup( Request $request ) {

        if( !User::isSeller() )
            return redirect('/');

        if( Auth::user()->uid !== $request->uid )
            return redirect()->back()->with('setup_err', 'Something went wrong, please try again later!')->withInput();

        $this->validate($request, [
                        'phone' => 'required|max:20',
                        'alternate' => 'nullable|max:20',
                        'country' => 'required|max:50',
                        'state' => 'required|max:50',
                        'city' => 'required|max:50',
                        'address' => 'required|max:255',
                        'landmark' => 'nullable|max:255',
                        'pincode' => 'required|numeric|min:111111|max:999999',
                        'gst' => 'nullable|max:255',
                        'account_holder_name' => 'required|max:255',
                        'account_no' => 'required|max:255',
                        'bank_name' => 'required|max:255',
                        'bank_ifsc' => 'required|max:255',
                        'bank_address' => 'required|max:255',
                        'uid' => 'required',
                ],
                [
                        'phone.required' => 'Phone no. is required *',
                        'phone.max' => 'Phone no. can have upto 20 characters!',
                        'alternate.max' => 'Alternate no. can have upto 20 characters!',
                        'country.required' => 'Country is required *',
                        'country.max' => 'Country name can have upto 50 characters!',
                        'state.required' => 'State is required *',
                        'state.max' => 'State name can have upto 50 characters!',
                        'city.required' => 'City is required *',
                        'city.max' => 'City name can have upto 50 characters!',

                        'address.required' => 'Address is required *',
                        'address.max' => 'Address can have upto 255 characters!',
                        'landmark.max' => 'Landmark can have upto 255 characters!',
                        'pincode.required' => 'Pincode is required *',
                        'pincode.max' => 'Pincode must be valid!',
                        'pincode.min' => 'Pincode must be valid!',
                        'pincode.numeric' => 'Pincode must be valid!',

                        'account_holder_name.required' => 'Account holder name is required *',
                        'account_holder_name.max' => 'Account holder name can have upto 255 characters!',
                        'bank_name.required' => 'Bank name is required *',
                        'bank_name.max' => 'Bank name can have upto 255 characters!',
                        'account_no.required' => 'Account no. is required *',
                        'account_no.max' => 'Account no. can have upto 255 characters!',
                        'bank_ifsc.required' => 'Bank IFSC is required *',
                        'bank_ifsc.max' => 'Bank IFSC code must be valid!',
                        'bank_address.required' => 'Bank address is required *',
                        'bank_address.max' => 'Bank address can have upto 255 characters!',

                        'uid.required' => 'Oops! Something went wrong.',
                ]);

        $user = User::where('uid', $request->uid)->first();
        if( !$user )
            return redirect()->back()->with('setup_err', 'OOPS! Something went wrong, please try again later!')->withInput();

        $id = UserDetail::where('user_id', $user->id)->value('id');

        if( !$id )
            return redirect()->back()->with('setup_err', 'Something went wrong, please try again later!')->withInput();

        UserDetail::where('id', $id)->update([
                            'mobile' => $request->phone,
                            'alternate' => $request->alternate,
                            'country' => $request->country,
                            'state' => $request->state,
                            'city' => $request->city,
                            'address' => $request->address,
                            'landmark' => $request->landmark,
                            'pincode' => $request->pincode,
                            'gst' => $request->gst,
                            'bank_name' => $request->bank_name,
                            'account_no' => $request->account_no,
                            'bank_ifsc' => $request->bank_ifsc,
                            'bank_address' => $request->bank_address,
                            'account_holder_name' => $request->account_holder_name,
            ]);
        
        return redirect( url('seller/setup/'.$user->uid.'?s=document') );
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

        if( !User::isSeller() )
            return;

        if( !$request->ajax() )
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

        if( Auth::user()->uid !== $request->uid )
            return response()->json(['errors' => ['message' => 'OOPS! something went wrong.'], 'validation' => 'failed']);

        $docs = Document::where('user_id', Auth::id())->get();
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
        if( $error )
            User::where('id', Auth::id())->update(['profile' => 'completed']);

        $path = false;
        $name = '';
        if( $request->avtar ) {
            $name = 'avtar';
            $path = $request->file('avtar')->store('files', 'public');

            $image = $request->file('avtar');
            $this->upload_file($image, Auth::id());
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
            if ( $doc = Document::where(['name' => $name, 'user_id' => Auth::id()])->first() ) {
                $doc->filename = $path;
                $doc->status = null;
                $doc->save();
            }
            else
                Document::create(['user_id' => Auth::id(), 'status' => null, 'name' => $name, 'filename' => $path]);
            
            return response()->json(['file_url' => asset('storage/app/public/'  .$path) , 'validation' => 'success']);
        }

        return response()->json(['validation' => 'failed']);
    }


    public function document( Request $request ) {

        if( !User::isSeller() )
            return redirect( url('/') );
        
        $validator = Validator::make([], []);

        $avtar = Avtar::where('user_id', Auth::id())->first();
        $error = false;

        $docs = Document::where('user_id', Auth::id())->get();

        if( !$docs || count( $docs ) < 1 ) 
            return redirect()->back()->with('setup_err', 'All documents are required *')->withInput();

        if( !$avtar ) {
            $validator->errors()->add('avtar', 'Avtar is required *');
            $error = true;
        }
        if( !$docs->where('name', 'signature')->first() ) {
            $error = true;
            $validator->errors()->add('signature', 'Signature is required *');
        }
        if( !$docs->where('name', 'pancard')->first() ) {
            $validator->errors()->add('pancard', 'Pancard is required *');
            $error = true;
        }
        if( !$docs->where('name', 'aadhar')->first() ) {
            $validator->errors()->add('aadhar', 'Aadhar is required *');
            $error = true;
        }
        if( !$docs->where('name', 'passbook')->first() ) {
            $validator->errors()->add('passbook', 'Passbook is required *');
            $error = true;
        }

        if( $error )
            return redirect()->back()->withErrors($validator)->withInput();

        User::where('id', Auth::id())->update(['profile' => 'completed']);
        return redirect()->route('seller.home');
    }


    public function update_document( Request $request ) {

        if( !User::isSeller() )
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

            return view('seller.document', ['title' => 'Upload Documents'])->with('user', $user);
        }

        return view('seller.document', ['title' => 'Upload Documents'])->with('user', $user);
    }



    public function home() {

        if( !User::isSeller() )
            return redirect('/');

        if( Auth::user()->profile !== 'completed' )
                return redirect()->route('seller.setup', Auth::user()->uid);

        return view('seller.home', ['title' => 'Home']);
    }



    public function change_password( Request $request ) {

        if( !User::isSeller() )
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
            return view('seller.password', ['title' => 'Change Password'])->with('errors', $validator->errors());
        }

        return view('seller.password', ['title' => 'Change Password']);
    }


    public function edit_profile( Request $request ) {

        if( !User::isSeller() )
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

            return view('seller.profile', ['title' => 'Edit Profile'])->with(['old' => $old, 'errors' => $validator->errors()]);
        }

        return view('seller.profile', ['title' => 'Edit Profile']);
    }


    
    public function contact( Request $request ) {

        if( !User::isSeller() )
            return redirect( url('/') );

        if( $request->method() === 'POST' ) {

            $validator = Validator::make( $request->all(), [
                                        'alternate' => 'nullable|max:10',
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
                    $userdetail->alternate = $request->alternate;
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

            return view('seller.contact', ['title' => 'Edit Contact Details'])->with(['old' => $old, 'errors' => $validator->errors()]);
        }

        return view('seller.contact', ['title' => 'Edit Contact Details']);
    }

    public function bank( Request $request ) {

        if( !User::isSeller() )
            return redirect( url('/') );

        if( $request->method() === 'POST' ) {

            $validator = Validator::make( $request->all(), [
                                        'bank_name' => 'required|max:255',
                                        'account_holder_name' => 'required|max:255',
                                        'account_no' => 'required|max:50',
                                        'bank_ifsc' => 'required|max:20',
                                        'bank_address' => 'required|max:255',
                                        'gst' => 'nullable|max:255',
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
                    $userdetail->gst = $request->gst;
                    $userdetail->save();

                $request->session()->flash('profile_msg', 'Bank details successfully updated!');
            }

            $old = $request->flash();

            return view('seller.bank', ['title' => 'Edit Bank Details'])->with(['old' => $old, 'errors' => $validator->errors()]);
        }

        return view('seller.bank', ['title' => 'Edit Bank Details']);
    }


    public function logout( Request $request ) {
        
        Auth::logout();
        $request->session()->flush();
        return redirect( route('seller') );
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function message()
    {
        if( !User::isSeller() )
            return redirect( url('/') );

        return view('seller.message', ['title' => 'Messages']);
    }

    public function set_read( Request $request ) {
        
        if( !$request->ajax() )
            return;

        if( !User::isSeller() && !User::isMember() )
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
}
