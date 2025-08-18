<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Http\Requests\VendorRequest;
use App\model\UserDetail;
use App\model\Document;
use App\model\Avtar;
use App\model\Product;

use App\User;
use Hash;
use Auth;
use Image;
use File;
use Validator;


class SellerController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
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

        return view( _admin('seller.index'), ['title' => 'Sellers'] );
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

        return view( _admin('seller.create'), ['title' => 'Create seller'] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store( Request $request ) {

        if( !User::isAdmin() )
            return redirect( url('/') );

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
        $user->parent_id = Auth::id();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->status = null;
        $user->uid = uniqueID(16);
        $user->password = Hash::make( $request->password );
        $user->username = generate_username($request);
        $user->save();

        UserDetail::create(['tnc' => $request->tnc, 'user_id' => $user->id]);

        return redirect()->route('admin.seller.setup', $user->uid);
    }


    public function setup( $uid ) {

        if( !User::isAdmin() )
            return redirect('/');

        $user = User::with('userdetail')->where('uid', $uid)->first();

        return view( _admin('seller.setup'), ['title' => 'Seller Profile Setup', 'user' => $user]);
    }


    public function store_setup( Request $request ) {

        if( !User::isAdmin() )
            return redirect('/');

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
        
        return redirect( admin_url('setup/'.$user->uid.'?s=document') );
    }



    public function store_document( Request $request ) {

        if( !User::isAdmin() )
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

        $user = User::where('uid', $request->uid)->first();
        if( !$user )
            return response()->json(['validation' => 'failed']);

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
        if( $error )
            User::where('id', $user->id)->update(['profile' => 'completed']);

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


    private function upload_file( $image, $user_id = '' ) {

        $user_id = $user_id;

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


    public function document( Request $request ) {

        if( !User::isAdmin() )
            return redirect( url('/') );
        
        $validator = Validator::make([], []);

        if( !$request->uid )
            return redirect()->back();

        $user = User::where('uid', $request->uid)->first();
        if( !$user )
            return redirect()->back();

        $avtar = Avtar::where('user_id', $user->id)->first();
        $error = false;

        $docs = Document::where('user_id', $user->id)->get();

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

        User::where('id', $user->id)->update(['profile' => 'completed']);
        return redirect()->route('seller.home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        $user = User::with('userdetail')->where('id', $id)->first();
        return view( _admin('seller.show'), ['title' => 'View seller', 'user' => $user] );

    }


    public function view_document( $id ) {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $docs = Document::where('user_id', $id)->get();
        return view( _admin('seller.document'), ['title' => 'View documents', 'docs' => $docs] );
    }


    public function document_status( Request $request ) {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $validator = Validator::make($request->all(),[
                            'doc_id' => 'required',
                            'user_id' => 'required',
                            'status' => 'required',
                            'remark' => 'nullable|max:255',
                    ]);
        if( $validator->fails() )
            return redirect()->back()->withErrors($validator)->withInput();

        Document::where(['user_id' => $request->user_id, 'id' => $request->doc_id])
                            ->update([
                                'status' => $request->status,
                                'remark' => $request->remark
                        ]);

        $docs = Document::where('user_id', $request->user_id)->get();
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
            User::where('id', $request->user_id)->update(['doc_verify' => 'verified']);

        return redirect()->back()->withInput();
    }


    public function update_status( Request $request, $id ) {

        if( !User::isAdmin() )
            return redirect( url('/') );

        if( !$request->status )
            return redirect()->back()->with('seller_err', 'Status could not update!')->withInput();

        User::where(['role' => 'seller', 'id' => $id])->update(['status' => $request->status]);
        $username = User::where(['role' => 'seller', 'id' => $id])->value('first_name');

        return redirect()->back()->with('seller_msg', 'Status updated ' . strtoupper($username));
    }


    public function products( $id ) {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $products = Product::where('user_id', $id)->get();
        return view( _admin('seller.products'), ['title' => 'Seller products', 'products' => $products] );
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

        $user = User::with('userdetail')->where('id', $id)->first();
        return view( _admin('seller.edit'), ['title' => 'Edit seller', 'user' => $user] );
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

        $user = User::findOrFail($id);
        if( !$user )
            return redirect()->back()->withErrors('seller_err', 'User not found!')->withInput();

        $this->validate($request, [
                            'first_name' => 'required|max:255',
                            'last_name' => 'required|max:255',
                            'email' => 'required|max:255|email|unique:users,email,'.$id,
                            'password' => 'nullable|min:8|max:255',
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

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        
        if( $request->password )
            $user->password = Hash::make( $request->password );

        $user->save();

        return redirect()->route('admin.seller.setup', $user->uid);
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
