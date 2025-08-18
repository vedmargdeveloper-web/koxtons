<?php

namespace App\Http\Controllers\User;

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

    protected $levels = ['l1', 'l2', 'l3', 'l4', 'l5', 'l6', 'l7', 'l8'];
    protected $interest = ['l1' => 8, 'l2' => 4, 'l3' => 2, 'l4' => 1, 'l5' => .5, 'l6' => .25, 'l7' => .10, 'l8' => .10];
    protected $initialAmount = 7000;
    protected $per_member_salary = 500;
    protected $membershipAmount = 3000;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');    
    }


    public function index()
    {

        if( !User::isMember() )
            return redirect( url('/') );

        return view('gift.user.member.index', ['title' => 'Members']);
    }

    public function users( $username )
    {

        if( !User::isMember() )
            return redirect( url('/') );

        $users = User::where('ref_id', $username)->get();
        return view('gift.user.member.users', ['title' => 'Members', 'users' => $users]);
    }

    public function level( $level )
    {

        if( !User::isMember() )
            return redirect( url('/') );

        return view('gift.user.member.level', ['level' => $level, 'title' => 'Level '.str_replace('l', '', $level)]);
    }

    public function profiles()
    {

        if( !User::isMember() )
            return redirect( url('/') );

        return view('gift.user.member.index', ['title' => 'Profiles']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if( !User::isMember() )
            return redirect( url('/') );

        return view('gift.user.member.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberRequest $request)
    {

        if( !User::isMember() )
            return redirect( url('/') );


        if( $user = User::where('email', $request->email)->first() ) {
            if( $user->role === 'member' ) {
                return redirect()->back()->withErrors(['email' => 'Member already exist with this email address.'])->withInput();
            }
        }

        switch ($request->step) {
            case 'create':
                
                if( $uid = $this->create_member( $request ) ) {
                    return redirect()->route('member.create', 'create?uid='.$uid.'&s=contact')->with("member_msg", 'Member created successfully!');
                }

                return redirect()->back()->withInput();
                break;

            case 'contact':
                
                if( $uid = $this->store_contact( $request ) ) {
                    return redirect()->route('member.create', 'create?uid='.$uid.'&s=document')->with("member_msg", 'Member contact details successfully updated!');
                }

                return redirect()->back()->with('member_err', 'Member could not create, please try again!')->withInput();
                break;

            case 'document':
                
                $username = $this->check_document( $request );
                if( !$username )
                    return redirect()->back()->withInput();

                return redirect()->route('member.network')->with("member_msg", 'Member successfully created!, '.strtoupper($username));

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
        if( !$ref_user ){
            $request->session()->flash('member_err', 'Invalid reference ID!');
            return false;
        }

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
            if( $level && Auth::user()->username !== $ref_user->reference ) {
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

    public function view($id)
    {

        if( !User::isMember() )
            return redirect( url('/') );

        $user = User::with(['userdetail', 'document'])->where('id', $id)->first();
        return view('gift.user.member.view')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if( !User::isMember() )
            return redirect( url('/') );

        $user = User::with(['userdetail', 'document'])->where('id', $id)->first();
        return view('gift.user.member.edit')->with('user', $user);
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

        if( !User::isMember() )
            return redirect( url('/') );

        if( User::where('email', $request->email)->where('id', '!=', $id)->first() ) {
            return redirect()->back()->with('email_err', 'Email address already exist!')->withInput();
        }

        $user = User::where(['id' => $id, 'uid' => $request->uid])->first();
        if( !$user )
            return redirect()->back()->with('member_err', 'Member could not update!')->withInput();


        if( !$this->check_document( $request ) )
            return redirect()->back()->withInput();


        $array = [
                    'parent_id' => Auth::id(),
                    'ref_id' => $request->reference,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make( $request->password ), 
                ];

        $user = User::where('username', $request->reference)->first();

        if( $user->member_level ) {
            $key = array_search($user->member_level, $this->levels);
            if( isset( $this->levels[++$key] ) ) {
                $array['member_level'] = $this->levels[$key];
            }
        }
        else {
            $array['member_level'] = $this->levels[0];
        }


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
