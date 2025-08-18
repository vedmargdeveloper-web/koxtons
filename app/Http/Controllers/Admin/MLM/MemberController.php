<?php

namespace App\Http\Controllers\Admin\MLM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\model\UserDetail;
use App\model\Document;
use App\model\Epin;
use App\model\Wallet;
use App\model\Avtar;
use App\model\Message;
use App\model\WalletRelation;
use App\model\Level;
use App\model\Membership;
use App\model\WalletHistory;
use App\model\Salary;
use App\model\Meta;
use App\User;
use Hash;
use Auth;
use Validator;
use Image;
use Storage;
use File;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $levels = ['l1', 'l2', 'l3', 'l4', 'l5', 'l6', 'l7', 'l8'];
    protected $interest = ['l1' => 8, 'l2' => 4, 'l3' => 2, 'l4' => 1, 'l5' => .5, 'l6' => .25, 'l7' => .10, 'l8' => .10];
    protected $initialAmount = 7000;
    protected $per_member_salary = 500;
    protected $membershipAmount = 3000;
    protected $amount = 7000;

    public function __construct() {

        $this->middleware('auth');
    }

    public function index()
    {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $users = User::with(['user_mobile'])->where('role', 'member')->orderby('id', 'DESC')->get();

        return view('gift.admin.mlm.member.index', ['title' => 'Members', 'users' => $users]);
    }


    public function direct()
    {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $users = User::where(['ref_id' => null, 'role' => 'member'])->orderby('id', 'DESC')->get();

        return view('gift.admin.mlm.member.index', ['title' => 'Direct Members', 'users' => $users]);
    }


    public function reference()
    {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $users = User::where('role', 'member')->where('ref_id', '!=', null)->orderby('id', 'DESC')->get();

        return view('gift.admin.mlm.member.index', ['title' => 'Reference Members', 'users' => $users]);
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

        return view('gift.admin.mlm.member.create', ['title' => 'Add Member']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(MemberRequest $request)
    {

        if( !User::isAdmin() )
            return redirect( url('/') );

        if( $user = User::where('email', $request->email)->first() ) {
            if( $user->role === 'member' ) {
                return redirect()->back()->withErrors(['email' => 'Member already exist with this email address.'])->withInput();
            }
        }


        switch ($request->step) {

            case 'create':
                
                if( $uid = $this->create_member( $request ) ) {
                    return redirect()->route('mlm.member.create', 'create?uid='.$uid.'&s=contact')->with("member_msg", 'Member created successfully!');
                }

                return redirect()->back()->withInput();

                break;

            case 'contact':
                
                if( $uid = $this->store_contact( $request ) ) {
                    return redirect()->route('mlm.member.create', 'create?uid='.$uid.'&s=document');
                }

                return redirect()->back()->with('member_err', 'Member could not create, please try again!')->withInput();
                break;

            case 'document':
                
                $username = $this->check_document( $request );
                if( !$username )
                    return redirect()->back()->withInput();

                return redirect()->route('mlm.members')->with("member_msg", 'Member created successfully, '.strtoupper($username));

                break;
            
            default:
                // code...
                break;
        }

        
    }



    private function create_member( $request ) {
        
        $uid = uniqueID(8);
        $username = generate_username();
        $array = [
                    'parent_id' => Auth::id(),
                    'ref_id' => $request->reference,
                    'epin_id' => $request->epin_id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make( $request->password ),
                    'uid' => $uid,
                    'username' => $username,
                    'role' => 'member'
                ];

        $epin = Epin::where('epin_id', $request->epin_id)->first();
        if( !$epin ){
            $request->session()->flash('member_err', 'Invalid Epin ID!');
            return false;
        }

        if( $epin->status !== 'accepted' ) {
            $request->session()->flash('member_err', 'Epin is in pending!');
            return false;
        }

        if( $epin->epins == $epin->used_epins ) {
            $request->session()->flash('member_err', 'Invalid Epin ID!');
            return false;
        }

        $ref_user = User::where('username', $request->reference)->first();
        $user = User::where('email', $request->email)->first();
        if( $user && $user->role === 'member' ) {
            $request->session()->flash('member_err', 'User already member with this email id!');
            return false;
        }
        $user_id = 0;
        if( $user ) {
            $user->fill($array)->save();
            $user_id = $user->id;
        }
        else {
            $user = User::create( $array );
            $user_id = $user->id;
        }

        if( !$user_id ) {
            $request->session()->flash('member_err', 'Member could not create!');
            return false;
        }

        if( $epin->used_epins ) {
            $epin->used_epins += 1;
            $epin->save();
        }
        else {
            $epin->used_epins = 1;
            $epin->save();
        }

        if( $ref_user ) {
            $level = Level::where('user_id', $ref_user->id)->value('level');
            $ref_amount = 0;
            $label = 'l1';
            if( $level ) {
                $key = array_search($level, $this->levels);
                if( isset( $this->levels[++$key] ) )
                    $label = $this->levels[$key];
            }

            $ref_amount = $this->initialAmount * $this->interest[$this->levels[0]] / 100;

            Level::create(['parent_id' => $ref_user->id, 'user_id' => $user_id, 'level' => $label]);
            $totalAmount = 0;
            if( $wallet = Wallet::where('user_id', $ref_user->id)->first() ) {
                $totalAmount = $wallet->amount ? $wallet->amount + $ref_amount : $ref_amount;
                $reference_amount = $wallet->reference_amount ? $wallet->reference_amount + $ref_amount : $ref_amount;
                Wallet::where('user_id', $ref_user->id)->update(['amount' => $totalAmount, 'reference_amount' => $reference_amount]);
                WalletRelation::create(['user_id' => $user_id, 'level' => $label, 'wallet_id' => $wallet->id, 'amount' => $ref_amount]);
            }
            else {
                $wallet_id = Wallet::create(['user_id' => $ref_user->id, 'amount' => $ref_amount, 'reference_amount' => $ref_amount])->id;
                WalletRelation::create(['user_id' => $user_id, 'level' => $label, 'wallet_id' => $wallet_id, 'amount' => $ref_amount]);
            }

            if( $ref_user->ref_id )  {
                $oldUser = User::where('username', $ref_user->ref_id)->first();
                $this->update_ref_amount( $oldUser, $user_id );
            }
        }

        Wallet::create(['user_id' => $user_id, 'joining_cashback' => $this->initialAmount, 'membership_amount' => $this->initialAmount])->id;
        UserDetail::create(['user_id' => $user_id, 'tnc' => $request->tnc]);
        Membership::create(['user_id' => $user_id, 'amount' => $this->membershipAmount]);
        if( $ref_user ) {
            $totalLevelMember = Level::where(['level' => 'l1', 'parent_id' => $ref_user->id])->count();
            if( $totalLevelMember && $level === 'li' ) {
                Salary::create(['user_id' => $user_id, 'member_id' => $ref_user->id, 'amount' => $this->per_member_salary]);
            }
            if( $totalLevelMember > 1 && $level === 'li' ) {
                Wallet::where('user_id', $ref_user->id)->update(['salary_amount' => $totalLevelMember * $this->per_member_salary]);
            }
        }

        $subject = 'Thank you for joining our membership - ' . config('app.name');
        $to = $user->email;
        $name = $user->first_name.' '.$user->last_name;
        $body = view('emails.member.member-creation')->with(['request' => $request, 'username' => $username]);

        $this->sendMail( $subject, $body, $to, $name );

        return $uid;
    }


    public function update_ref_amount( $ref_user, $user_id, $key = 1 ) {

        if( $key > 7 )
            return;

        if( $ref_user ) {

            $level = Level::where('user_id', $ref_user->id)->value('level');
            $ref_amount = 0;
            $label = $this->levels[$key];

            $ref_amount = $this->initialAmount * $this->interest[$this->levels[$key]] / 100;

            if( $label ) {

                $totalAmount = 0;

                if( $wallet = Wallet::where('user_id', $ref_user->id)->first() ) {
                    $totalAmount = $wallet->amount ? $wallet->amount + $ref_amount : $ref_amount;
                    $reference_amount = $wallet->reference_amount ? $wallet->reference_amount + $ref_amount : $ref_amount;
                    Wallet::where('user_id', $ref_user->id)->update(['amount' => $totalAmount, 'reference_amount' => $reference_amount]);
                    WalletRelation::create(['user_id' => $user_id, 'level' => $label, 'wallet_id' => $wallet->id, 'amount' => $ref_amount]);
                }
                else {
                    $wallet_id = Wallet::create(['user_id' => $ref_user->id, 'amount' => $ref_amount, 'reference_amount' => $ref_amount])->id;
                    WalletRelation::create(['user_id' => $user_id, 'level' => $label, 'wallet_id' => $wallet_id, 'amount' => $ref_amount]);
                }

                if( $ref_user->ref_id )  {

                    $oldUser = User::where('username', $ref_user->ref_id)->first();
                    $this->update_ref_amount( $oldUser, $user_id, ++$key );
                }
            }
        }
    }


    public function sendMail( $subject, $body, $to, $name ) {

        $mail = new PHPMailer(true);
        try {
            $noreply = Meta::where('meta_name', 'noreply')->value('meta_value');
            $noreply = $noreply ? $noreply : 'noreply@boomingmart.com';
            $mail->setFrom($noreply, config('app.name'));
            $mail->addAddress($to, $name);     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }


    private function store_contact( $request ) {
        
        $user = User::where('uid', $request->uid)->first();
        if( !$user )
            return false;

        if( $id = UserDetail::where('user_id', $user->id)->value('id') ) {
            UserDetail::where('id', $id)->update([
                                        'gender' => $request->gender,
                                        'phonecode' => $request->code,
                                        'mobile' => $request->mobile,
                                        'country' => $request->country,
                                        'state' => $request->state,
                                        'city' => $request->city,
                                        'address' => $request->address,
                                        'landmark' => $request->landmark,
                                        'pincode' => $request->pincode,
                                        'bank_name' => $request->bank_name,
                                        'account_no' => $request->account_no,
                                        'bank_ifsc' => $request->bank_ifsc,
                                        'bank_address' => $request->bank_address,
                                        'account_holder_name' => $request->account_holder_name,
                                ]);
        }
        else {
            UserDetail::create([
                            'user_id' => $user->id,
                            'gender' => $request->gender,
                            'phonecode' => $request->code,
                            'mobile' => $request->mobile,
                            'country' => $request->country,
                            'state' => $request->state,
                            'city' => $request->city,
                            'address' => $request->address,
                            'landmark' => $request->landmark,
                            'pincode' => $request->pincode,
                            'bank_name' => $request->bank_name,
                            'account_no' => $request->account_no,
                            'bank_ifsc' => $request->bank_ifsc,
                            'bank_address' => $request->bank_address,
                            'account_holder_name' => $request->account_holder_name,
                    ]);
        }

        return $user->uid;
    }


    private function check_document( $request ) {

        $error = true;
        $user = User::with('avtar')->where('uid', $request->uid)->first();
        if( !$user ) {
            $request->session()->flash('member_err', 'Something went wrong, please try again later!');
            $error = false;
        }

        if( !$user->avtar || !isset($user->avtar[0]->filename) ) {
            $request->session()->flash('avtar', 'Profile pic is required *');
            $error = false;
        }

        $docs = Document::where('user_id', $user->id)->get();

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
        if( !$docs->where('name', 'avtar')->first() )
            $error = false;
        if( $error ) {
            User::where('id', $user->id)->update(['profile' => 'completed']);
        }

        if( !$error )
            return $error;
        else
            return $user->username;
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

        if( !User::isAdmin() )
            return redirect( url('/') );

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
            return response()->json(['errors' => ['message' => 'OOPS! something went wrong.'], 'validation' => 'failed']);

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


 /*   public function store(MemberRequest $request)
    {

        $parent_id = User::where('ref_id', $request->reference)->value('id');
        if( !$parent_id )
            return redirect()->back()->with('member_err', 'Member not found!')->withInput();

        if( User::where(['ref_id' => $request->reference, 'side' => $request->side])->first() )
            return redirect()->back()->with('member_err', 'Member already exist this side!')->withInput();

        $uid = uniqueID(8);
        $username = $this->generate_username( $request );
        $array = [
                    'parent_id' => $parent_id,
                    'ref_id' => $request->reference,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make( $request->password ), 
                    'side' => $request->side,
                    'uid' => $uid,
                    'username' => $username,
                    'role' => 'member',
                    'status' => 'active',
                ];

        $user_id = User::create( $array )->id;

        if( !$user_id )
            return redirect()->back()->with('member_err', 'Member could not add!')->withInput();

        UserDetail::create([
                            'user_id' => $user_id,
                            'gender' => $request->gender,
                            'phonecode' => $request->code,
                            'mobile' => $request->mobile,
                            'country' => $request->country,
                            'state' => $request->state,
                            'city' => $request->city,
                            'address' => $request->address,
                            'landmark' => $request->landmark,
                            'pincode' => $request->pincode,
                            'bank_name' => $request->bank_name,
                            'account_no' => $request->account_no,
                            'bank_ifsc' => $request->bank_ifsc,
                            'bank_address' => $request->bank_address,
                            'account_holder_name' => $request->account_holder_name,
                    ]);

        return redirect()->back()->with('member_msg', 'Member successfully added! '.strtoupper($username));
    }


    public function generate_username( $request ) {

        $username_id = User::orderby('id', 'DESC')->limit(1)->value('id');
        $username_id = $username_id ? ++$username_id : '';

        $name = $request->first_name[0].$request->last_name[0].$username_id;       

        if( User::where('username', $name)->first() )
            $this->generate_username( $request );

        return strtolower($name);
    }*/

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

    public function view( $id ) {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $user = User::with(['userdetail', 'avtar', 'document'])->where('id', $id)->first();
        return view('gift.admin.mlm.member.view', ['title' => 'View Member', 'user' => $user]);
    }


    public function view_document( $id ) {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $docs = Document::where('user_id', $id)->get();
        return view('gift.admin.mlm.member.document', ['title' => 'Member Documents', 'docs' => $docs]);
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
        return view('gift.admin.mlm.member.edit', ['title' => 'Edit Member', 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MemberRequest $request, $id)
    {

        if( !User::isAdmin() )
            return redirect( url('/') );

        if( User::where('email', $request->email)->where('id', '!=', $id)->first() )
            return redirect()->back()->with('email_err', 'Email address already exist!')->withInput();

        $user = User::where(['id' => $id, 'uid' => $request->uid])->first();
        if( !$user )
            return redirect()->back()->with('member_err', 'Member could not update!')->withInput();

        $array = [
                    'ref_id' => $request->reference,
                    'epin_id' => $request->epin_id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make( $request->password ),
                ];
        if( $request->password )
            $array['password'] = Hash::make($request->password);
    
        User::where('id', $id)->update( $array );

        UserDetail::where('user_id', $id)->update([
                                    'gender' => $request->gender,
                                    'phonecode' => $request->code,
                                    'mobile' => $request->mobile,
                                    'country' => $request->country,
                                    'state' => $request->state,
                                    'city' => $request->city,
                                    'address' => $request->address,
                                    'landmark' => $request->landmark,
                                    'pincode' => $request->pincode,
                                    'bank_name' => $request->bank_name,
                                    'account_no' => $request->account_no,
                                    'bank_ifsc' => $request->bank_ifsc,
                                    'bank_address' => $request->bank_address,
                                    'account_holder_name' => $request->account_holder_name,
                            ]);

        return redirect()->back()->with('member_msg', 'Member details successfully updated!')->withInput();
    }


    public function status( Request $request, $id ) {

        if( !User::isAdmin() )
            return redirect( url('/') );

        if( !$request->status )
            return redirect()->back()->with('member_err', 'Status could not update!')->withInput();

        User::where(['role' => 'member', 'id' => $id])->update(['status' => $request->status]);
        $username = User::where(['role' => 'member', 'id' => $id])->value('username');

        return redirect()->back()->with('member_msg', 'Status updated ' . strtoupper($username));
    }


    public function document( Request $request ) {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $this->validate( $request, [
                            'doc_id' => 'required',
                            'user_id' => 'required',
                            'status' => 'required',
                            'remark' => 'nullable|max:255',
                    ]);

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

        if( $error && $request->status !== 'reject' )
            User::where('id', $request->user_id)->update(['doc_verify' => 'verified']);
        else 
            User::where('id', $request->user_id)->update(['doc_verify' => 'not_verified']);

        return redirect()->back();
    }



    public function messages( $id ) {
        if( !User::isAdmin() )
            return redirect( url('/') );

        $messages = Message::where('receiver_id', $id)->orderby('id', 'DESC')->get();

        return view('gift.admin.mlm.member.message', ['title' => 'Member Messages', 'messages' => $messages]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        UserDetail::where('user_id', $id)->delete();
        if( $wallet_id = Wallet::where('user_id', $id)->value('id') ) {
            WalletRelation::where('wallet_id', $wallet_id)->delete();
        }
        Wallet::where('user_id', $id)->delete();
        WalletHistory::where('user_id', $id)->delete();
        WalletRelation::where('user_id', $id)->delete();
        Membership::where('user_id', $id)->delete();
        Salary::where('user_id', $id)->delete();
        Level::where('user_id', $id)->delete();
        Epin::where('user_id', $id)->delete();
        $documents = Document::where('user_id', $id)->get();
        if( $documents && count( $documents ) > 0 ) {
            foreach ($documents as $file) {

                File::delete( storage_path('app/public/'.$file->file) );
            }
        }

        Document::where('user_id', $id)->delete();
        Avtar::where('user_id', $id)->delete();

        return redirect()->back()->with('member_msg', 'Member successfully deleted!');
    }
}
