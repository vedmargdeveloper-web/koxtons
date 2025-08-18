<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\FileManager as File;

use App\model\Category;
use App\User;
use Image;
use Auth;
use App\model\LogsModel;


class CategoryController extends Controller
{

    protected $thumb = [270, 225];
    protected $medium = [550, 360];

    public function __construct()
    {

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

        return view(_admin('category/index'), ['title' => 'All categories']);
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

        return view(_admin('category/create'), ['title' => 'Create category']);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {

        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        $filename = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $this->upload($image);
        }

        $array = array(
            'name' => $request->name,
            'slug' => slug($request->name),
            'parent' => $request->parent,
            'description' => $request->description,
            'order_by' => $request->order_by,
            'metakey' => $request->metakey,
            'metatitle' => $request->metatitle,
            'metadescription' => $request->metadescription,
            'postmeta' => $request->postmeta,
            'feature_image' => $filename
        );


        if ($category =  Category::create($array)) {
            LogsModel::create(['user_id' => Auth::id(), 'remark' => 'Create Category', 'status' => 'Category', 'working_id' => $category->id]);
            return redirect()->back()->with('cat_msg', 'Category created successfully!');
        }
        return redirect()->back()->with('cat_err', 'Category could not create!');
    }



    private function upload($image)
    {
        $hashname = md5($image->getClientOriginalName() . time());
        $filename = $hashname . '-' . config('filesize.thumbnail.0') . 'x' . config('filesize.thumbnail.1') . '.' . $image->getClientOriginalExtension();
        File::upload($filename, $image, public_path(public_file()), config('filesize.thumbnail.0'), config('filesize.thumbnail.1'));

        $filename = $hashname . '-' . config('filesize.medium.0') . 'x' . config('filesize.medium.1') .
            '.' . $image->getClientOriginalExtension();
        File::upload($filename, $image, public_path(public_file()), config('filesize.medium.0'), config('filesize.medium.1'));

        $filename = $hashname . '.' . $image->getClientOriginalExtension();
        File::upload($filename, $image, public_path(public_file()));

        return $filename;
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

        $category = Category::find($id);
        return view(_admin('category/edit'), ['title' => 'Edit category', 'category' => $category]);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        $filename = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $this->upload($image);
        } else {
            $filename = $request->filename;
        }
        $status = 'active';

        if (isset($request->save)) {
            $status = $request->save;
        }
        if (isset($request->draft)) {
            $status = $request->draft;
        }

        $array = array(
            'name' => $request->name,
            'slug' => $request->slug ? slug($request->slug) : slug($request->name),
            'parent' => $request->parent,
            'description' => $request->description,
            'feature_image' => $filename,
            'order_by' => $request->order_by,
            'product_priority_desktop' => $request->desktop_products_id,
            'product_priority_mobile' => $request->mobile_products_id,
            'status' => $status,
            'metakey' => $request->metakey,
            'metatitle' => $request->metatitle,
            'metadescription' => $request->metadescription,
            'postmeta' => $request->postmeta,
            'updated_at' => date('Y-m-d H:i:s')
        );

        // dd($array);

        if (Category::where('id', $id)->update($array)) {
            LogsModel::create(['user_id' => Auth::id(), 'remark' => 'Update Category', 'status' => 'Category', 'working_id' => $id]);
            return redirect()->back()->with('cat_msg', 'Category updated successfully!');
        }

        return redirect()->back()->with('cat_err', 'Category could not update!');
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

        if (Category::where('id', $id)->delete())
            return redirect()->back()->with('cat_msg', 'Category deleted successfully!');

        return redirect()->back()->with('cat_err', 'Category could not delete!');
    }
}
