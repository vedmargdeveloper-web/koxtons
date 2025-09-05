<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileManager as File;
use App\model\Category;
use App\model\Post;
use App\User;
use Auth;
use App\model\LogsModel;


class PageController extends Controller
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

        return view( _admin('posts.index'), ['title' => 'Pages', 'type' => 'page']);
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

        $categories = Category::where('parent', null)->get();
        return view(_admin('posts.create'), ['title' => 'Create page', 'type' => 'page', 'categories' => $categories]);
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

        $post = new Post();
        $post->user_id = Auth::id();
        $post->category_id = $request->category;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->excerpt = get_excerpt( $request->content, 40 );
        $post->slug = slug( $request->title );
        $post->type = $request->type;
        $post->feature_image = $request->hasFile('feature_image') ? $this->upload( $request->file('feature_image') ) : null;
        $post->feature_image_alt = $this->feature_image_alt;
        $post->status = $this->status;
        $post->metakey = $request->metakey;
        $post->metatitle = $request->metatitle;
        $post->metadescription = $request->metadescription;
        $post->save();

        LogsModel::create(['user_id' => Auth::id(),'remark'=>'Create Page','status'=>'page', 'working_id' => $post->id]);

        if( !$post->id )
            return redirect()->back()->with('post_err', 'Page could not create, try again later!');

        if( $request->draft )
            return redirect()->route( 'page.edit', $post->id )->with('post_msg', 'Page saved successfully!');

        return redirect()->route( 'page.edit', $post->id )->with('post_msg', 'Page created successfully!');

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
                    'title' => 'Edit page',
                    'type' => 'page',
                    'categories' => Category::where('parent', null)->get(),
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
            return redirect()->back()->with('post_err', 'Page not found!');

        if( $request->draft )
            $this->status = 'draft';

        /*$slug = 
        if( $count === 1 )
            $slug = slug( $request->title );
        elseif( $count > 1 )
            $slug = slug( $request->title ) . '-' . $count;*/

        $array = array(
                        'user_id' => Auth::id(),
                        'category_id' => $request->category,
                        'title' => $request->title,
                        'content' => $request->content,
                        'excerpt' => get_excerpt( $request->content, 40 ),
                        'slug' => slug( $request->title ),
                        'type' => $request->type,
                        'status' => $this->status,
                        'metakey' => $request->metakey,
                        'metatitle' => $request->metatitle,
                        'metadescription' => $request->metadescription,
                        'feature_image_alt'=>$request->feature_image_alt,
                        'feature_image' => $request->hasFile('feature_image') ? $this->upload( $request->file('feature_image') ) : $request->filename
                    );
        $post->fill($array)->save();

        LogsModel::create(['user_id' => Auth::id(),'remark'=>'Update Page','status'=>'page', 'working_id' => $id]);
        
        return redirect()->back()->with('post_msg', 'Page updated successfully!');
        
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
            LogsModel::create(['user_id' => Auth::id(),'remark'=>'Delete Page','status'=>'page', 'working_id' => $id]);
            return redirect()->back()->with('post_msg', 'Page deleted successfully!');

        return redirect()->back()->with('post_err', 'Page could not delete!');
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
