<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileManager as File;
use App\model\PostCategory;
use App\model\Post;
use App\User;
use Auth;
use App\model\LogsModel;


class PostController extends Controller
{

    protected $thumb = [130, 140];
    protected $medium = [260, 200];
    protected $type = 'post';
    protected $status = 'publish';

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

        return view( _admin('posts.index'), ['title' => 'Posts', 'type' => 'post']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        $categories = PostCategory::get();
        return view(_admin('posts.create'), ['title' => 'Create post', 'type' => 'post', 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        if( $request->draft )
            $this->status = 'draft';

        if( $request->category && !PostCategory::find( $request->category ) )
            return redirect()->back()->with('cat_err', 'Category not found!')->withInput();

        $count = count( Post::where('title', $request->title)->get() );

        $post = new Post();
        $post->user_id = Auth::id();
        $post->category_id = $request->category;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->excerpt = get_excerpt( $request->content, 40 );
        $post->slug = $count >= 1 ? slug( $request->title ) . '-' . ++$count : slug( $request->title );
        $post->type = $request->type;
        $post->feature_image = $request->hasFile('feature_image') ? $this->upload( $request->file('feature_image') ) : null;
        $post->status = $this->status;
        $post->metakey = $request->metakey;
        $post->metatitle = $request->metatitle;
        $post->metadescription = $request->metadescription;
        $post->save();
        LogsModel::create(['user_id' => Auth::id(),'remark'=>'Create Post','status'=>'post', 'working_id' => $post->id]);

        if( !$post->id )
            return redirect()->back()->with('post_err', 'Post could not create, try again later!');

        if( $request->draft )
            return redirect()->route( 'post.edit', $post->id )->with('post_msg', 'Post saved successfully!');

        return redirect()->route( 'post.edit', $post->id )->with('post_msg', 'Post created successfully!');

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

        $array = array(
                    'title' => 'Edit post',
                    'categories' => PostCategory::get(),
                    'post' => Post::find( $id )
                );
        return view( _admin('posts.edit'), $array);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {

        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        $post = Post::findOrFail( $id );
        if( !$post )
            return redirect()->back()->with('post_err', 'Post not found!');

        if( $request->draft )
            $this->status = 'draft';

        if( $request->category && !PostCategory::find( $request->category ) )
            return redirect()->back()->with('cat_err', 'Category not found!')->withInput();

        $count = count( Post::where('title', $request->title)->get() );
        $oldData = $post->toArray();
        // save old post data in log model
        

        $array = array(
                        'user_id' => Auth::id(),
                        'category_id' => $request->category,
                        'title' => $request->title,
                        'content' => $request->content,
                        'excerpt' => get_excerpt( $request->content, 40 ),
                        'slug' => $count > 1 ? slug( $request->title ) . '-' . $count : slug( $request->title ),
                        'type' => $request->type,
                        'status' => $this->status,
                        'metakey' => $request->metakey,
                        'metatitle' => $request->metatitle,
                        'metadescription' => $request->metadescription,
                        // 'feature_image' => $request->hasFile('feature_image') ? $this->upload( $request->file('feature_image') ) : $request->filename
                        'feature_image' => $request->hasFile('feature_image') ? $this->upload( $request->file('feature_image') ) : $request->filename

                    );
        


        $post->fill($array)->save();

        $newData = $post->toArray();


        // Save new data in log model

        $array1 = array(
            'new_data' => json_encode(Post::where('id', $id)->first()->toArray()),
        );
        // $logs = LogsModel::findOrFail( $log->id );
        // $logs->fill($array1)->save();

         $log = LogsModel::create(['user_id' => Auth::id(),'remark'=>'Update Post','status'=>'post', 'working_id' => $id,'old_data'=>json_encode($oldData),'new_data'=> json_encode($newData)]);

        

        
        
        return redirect()->back()->with('post_msg', 'Post updated successfully!');
        
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

        if( Post::where('id', $id)->delete() )
            LogsModel::create(['user_id' => Auth::id(),'remark'=>'Delete Post','status'=>'post', 'working_id' => $id]);
            return redirect()->back()->with('post_msg', 'Post deleted successfully!');

        return redirect()->back()->with('post_err', 'Post could not delete!');
    }

    private function upload( $image ) {
        $hashname = clean( $image->getClientOriginalName() ) . '-' . randomString(8);
        $filename = $hashname . '-' . $this->thumb[0] . 'x' . $this->thumb[1] . '.' . $image->getClientOriginalExtension();
        File::upload( $filename, $image, public_path( post_file() ), $this->thumb[0],$this->thumb[1] );

        $filename = $hashname . '-' . $this->medium[0] . 'x' . $this->medium[1] .
                    '.' . $image->getClientOriginalExtension();
        File::upload( $filename, $image, public_path( post_file() ), $this->medium[0], $this->medium[1] );

        $filename = $hashname . '.' . $image->getClientOriginalExtension();
        File::upload( $filename, $image, public_path( post_file() ) );

        return $filename;
    }



}
