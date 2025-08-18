<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\Review;
use Validator;
use Auth;

class CommentController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function store( Request $request ) {

        $validator = Validator::make($request->all(), [
                            'name' => 'required|max:255',
                            'email' => 'required|email|max:255',
                            'message' => 'required|max:10000',
                            'star' => 'required|numeric|min:1|max:5',
                            'blog_id' => 'required|numeric|min:1|max:10000',
                        ],
                        [
                            'name.required' => 'Name is required *',
                            'name.max' => 'Name can have upto 255 characters!',

                            'email.required' => 'Email is required *',
                            'email.max' => 'Email can have upto 255 characters!',
                            'email.email' => 'Email must be valid!',

                            'star.required' => 'Please give us 5 star *',
                            'star.max' => 'Star must be valid!',
                            'star.min' => 'Star must be valid!',
                            'star.numeric' => 'Star must be valid!',

                            'message.required' => 'Message is required *',
                            'message.max' => 'Message can have upto 10000 characters!',
                        ]
                );

        if( $validator->fails() )
            return redirect()->back()->withErrors($validator)->withInput();
    
        $comment = new Review();
        $comment->review = $request->message;
        $comment->rating = $request->star;
        $comment->blog_id = $request->blog_id;
        $comment->user_id = Auth::check() ? Auth::id() : null;
        $comment->email = $request->email;
        $comment->name = $request->name;

        if( !$comment->save() )
            return redirect()->back()->with('comment_err', 'Something went wrong, try again later!')->withInput();

        return redirect()->back()->with('comment_msg', '');
    }
}
