<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\model\Message;
use App\User;
use Auth;

class MessageController extends Controller
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
        //
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
                            'message' => 'required'
                    ]);

        if( $request->all ) {
            $members = User::where(['role' => 'member', 'status' => 'active'])->get();
            if( $members && count($members) > 0 ) {
                foreach ($members as $user) {

                        Message::create([
                                    'sender_id' => Auth::id(),
                                    'receiver_id' => $user->id,
                                    'message' => $request->message
                            ]);
                }
            }
            else
                return redirect()->back()->with('message_msg', 'Active member not found!');
        }
        else {
            $this->validate( $request, [
                            'user_ids' => 'required|array'
                    ]);
            foreach ($request->user_ids as $user_id) {
                    Message::create([
                                'sender_id' => Auth::id(),
                                'receiver_id' => $user_id,
                                'message' => $request->message
                        ]);
            }
        }

        return redirect()->back()->with('message_msg', 'Message successfully sent!');
    }

    public function seller_message( $id ) {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $messages = Message::where('receiver_id', $id)->orderby('id', 'DESC')->get();

        return view( _admin('seller.message'), ['title' => 'Seller messages', 'messages' => $messages]);
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
