<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\FileManager;
use App\model\Product;
use App\model\ProductMeta;
use App\model\ProductPriceQuantity;
use App\model\CategoryProduct;
use App\model\Meta;
use App\model\Media;
use App\model\ProductAttribute;
use App\model\ProductAttributeMeta;
use App\model\product_meta_colors;
use App\model\Brand;
use App\model\BrandRelation;
use App\model\ProductUser;
use App\User;
use Image;
use Auth;
use Validator;
use Session;
use Input;
use File;
use App\model\LogsModel;


class ProductController extends Controller
{

    protected $thumb = [150, 150];
    protected $medium = [300, 300];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() {

        // $this->middleware('auth');
    }

    public function index()
    {
     
        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        return view( _admin('product/index'), ['title' => 'Products'] );
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

        return view( _admin('product/create'), ['title' => 'Add product'] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

        $product_id = Product::orderby('id', 'DESC')->limit(1)->value('product_id');
        if( $product_id )
            $product_id = $product_id + 1;
        else
            $product_id = Meta::where('meta_name', 'init_product_id')->value('meta_value');

        $feature_image = $this->upload_feature( $request->file('file') );

        $product = new Product();
        $product->product_id = $product_id;
        $product->user_id = Auth::id();
        $product->category_id = $request->category[0];
        $product->title = $request->title;
        $product->slug = slug( $request->title );
        $product->content = $request->content;
        $product->short_content = $request->short_content;
        $product->excerpt = get_excerpt( $request->content, 500 );
        if( $request->is_feature )
            $product->type = 'featured';
        $product->tags = $request->tags;
        $product->brand = $request->brand ? implode(',', $request->brand) : null;
        $product->feature_image = $feature_image;

        if($request->price == 0 OR $request->price == ''){
            $product->price = $request->mrp;
        }else{
            $product->price = $request->price;
        }
        $product->product_code = $request->product_code;
        $product->mrp = $request->mrp;
        $product->price_range = $request->price_range;
        $product->shipping_charge = $request->shipping_charge;
        $product->discount = $request->discount;
        $product->quantity = $request->quantity;
        $product->available = $request->quantity;
        $product->delivery_time = $request->delivery_time;
        $product->buy_also = $request->buy_also;
        $product->gst = $request->gst;
        $product->payment_option = $request->payment_option ? implode(',', $request->payment_option) : null;
        $product->status = $request->submit;

        $product->metakey = $request->metakey;
        $product->metatitle = $request->metatitle;
        $product->metadescription = $request->metadescription;
        $product->postmeta = $request->postmeta;
        $product->faq = $request->faq;
        $product->feature_image_alt = $request->feature_image_alt;
        $product->file_alt = $request->file_alt;
        


        $product->save();



        if( !$product->id )
            return redirect()->back()->with('product_err', 'Product could not insert, please try again later!')->withInput();

        foreach ( $request->category as $value ) {
            CategoryProduct::create(['category_id' => $value, 'product_id' => $product->id]);   
        }

        $__dd = Product::findOrFail( $product->id );
        LogsModel::create(['user_id' => Auth::id(),'remark'=>'Add Product','status'=>'product', 'working_id' => $product->id,'new_data'=> json_encode($__dd->toArray())]);


        $sizesArray = ['s', 'm', 'l', 'xl', 'xxl', 'xxxl'];
        $attribute = ['product_id' => $product->id, 'attribute_name' => 'size'];
        $product_attribute_id = ProductAttribute::create($attribute)->id;
        if( $request->sizes && count( $request->sizes ) > 0 ) {
            foreach ( $sizesArray as $key => $s ) {
                if( in_array($s, $request->sizes) ) {
                    $sizes = array(
                        'product_id' => $product->id,
                        'product_attribute_id' => $product_attribute_id,
                        'type' => 'size',
                        'name' => strtolower($s),
                        'value' => json_encode([
                            'name' => strtolower($s),
                            'stock' => isset($request->stock[$key]) ? $request->stock[$key] : null,
                            'price' => isset($request->rate[$key]) ? $request->rate[$key] : null,
                        ])
                    );
                    ProductAttributeMeta::create($sizes);
                }
            }
        }

        $shoesizesArray = ['5', '6', '7', '8', '9', '10', '11'];
        $attribute = ['product_id' => $product->id, 'attribute_name' => 'shoe_size'];
        $product_attribute_id = ProductAttribute::create($attribute)->id;
        if( $request->shoe_size && count( $request->shoe_size ) > 0 ) {
            foreach ( $request->shoe_size as $key => $s ) {
                $sizes = array(
                    'product_id' => $product->id,
                    'product_attribute_id' => $product_attribute_id,
                    'type' => 'shoe_size',
                    'name' => strtolower($s),
                    'value' => json_encode([
                        'name' => strtolower($s),
                        'stock' => isset($request->shoe_stock[$key]) ? $request->shoe_stock[$key] : null,
                        'price' => isset($request->shoe_rate[$key]) ? $request->shoe_rate[$key] : null,
                    ])
                );
                ProductAttributeMeta::create($sizes);
            }
        }

        $waistSizesArray = [28, 30, 32, 34, 36, 38, 40];
        $attribute = ['product_id' => $product->id, 'attribute_name' => 'waist_size'];
        $product_attribute_id = ProductAttribute::create($attribute)->id;
        if( $request->waist_size && count( $request->waist_size ) > 0 ) {
            foreach ( $request->waist_size as $key => $s ) {
                $sizes = array(
                    'product_id' => $product->id,
                    'product_attribute_id' => $product_attribute_id,
                    'type' => 'waist_size',
                    'name' => strtolower($s),
                    'value' => json_encode([
                        'name' => strtolower($s),
                        'stock' => isset($request->waist_stock[$key]) ? $request->waist_stock[$key] : null,
                        'price' => isset($request->waist_rate[$key]) ? $request->waist_rate[$key] : null,
                    ])
                );
                ProductAttributeMeta::create($sizes);
            }
        }

        $childSize = ['12-18 months', '18-24 months', '2-3 year', '3-4 year', '4-5 year', '5-6 year', '6-7 year', '7-8 year', '8-9 year', '9-10 year', '10-11 year', '11-12 year', '12-13 year', '13-14 year', '14-15 year', '15-16 year'];
        $attribute = ['product_id' => $product->id, 'attribute_name' => 'child_size'];
        $product_attribute_id = ProductAttribute::create($attribute)->id;
        if( $request->child_size && count( $request->child_size ) > 0 ) {
            foreach ( $request->child_size as $key => $s ) {
                $sizes = array(
                    'product_id' => $product->id,
                    'product_attribute_id' => $product_attribute_id,
                    'type' => 'child_size',
                    'name' => strtolower($s),
                    'value' => json_encode([
                        'name' => strtolower($s),
                        'stock' => isset($request->child_stock[$key]) ? $request->child_stock[$key] : null,
                        'price' => isset($request->child_rate[$key]) ? $request->child_rate[$key] : null,
                    ])
                );
                ProductAttributeMeta::create($sizes);
            }
        }

        if( $request->dimension_type && count($request->dimension_type) > 0 ) {
            $attribute = ['product_id' => $product->id, 'attribute_name' => 'dimension'];
            $product_attribute_id = ProductAttribute::create($attribute)->id;
            foreach ($request->dimension_type as $key => $s) {
                if( $s !== '' ) {
                    $dimension = array(
                        'product_id' => $product->id,
                        'product_attribute_id' => $product_attribute_id,
                        'type' => 'dimension',
                        'name' => strtolower($s),
                        'value' => json_encode([
                            'name' => strtolower($s),
                            'width' => isset($request->width[$key]) ? $request->width[$key] : null,
                            'height' => isset($request->height[$key]) ? $request->height[$key] : null,
                            'length' => isset($request->length[$key]) ? $request->length[$key] : null,
                            'weight' => isset($request->weight[$key]) ? $request->weight[$key] : null,
                            'price' => isset($request->dimension_price[$key]) ? $request->dimension_price[$key] : null,
                        ])
                    );
                    ProductAttributeMeta::create($dimension);
                }
            }
        }
        $files_size_color = array();
        if( $request->custom_size && count($request->custom_size) > 0 ) {
            
            $attribute = ['product_id' => $product_id, 'label' => $request->label, 'attribute_name' => 'custom_size'];
            $product_attribute_id = ProductAttribute::create($attribute)->id;
            
            foreach ($request->custom_size as $key => $s) {

                if( $s && isset($request->custom_size_price[$key]) && $request->custom_size_price[$key] ) {
                   
                    if($_FILES['custom_size_image']['name'][$key]){
                        $files_size_color[] = $this->upload_feature($request->file('custom_size_image')[$key]);
                    }else{
                        $files_size_color = array('');
                    }


                    $custom_size = array(
                        'product_id' => $product_id,
                        'product_attribute_id' => $product_attribute_id,
                        'type' => 'custom_size',
                        'name' => strtolower($s),
                        'value' => json_encode([
                            'name' => strtolower($s),
                            'price' => isset($request->custom_size_price[$key]) ? $request->custom_size_price[$key] : null,
                            'stock' => isset($request->custom_size_stock[$key]) ? $request->custom_size_stock[$key] : null,
                            'size_image' => isset($files_size_color) ? json_encode($files_size_color) : null,
                            'custom_size_image_alt' => isset($request->custom_size_image_alt[$key]) ? $request->custom_size_image_alt[$key] : null,
                        ])
                    );
                    ProductAttributeMeta::create($custom_size);
                    $files_size_color = array('');
                }
            }
        }


        
        $files = array();
        if( $request->hasFile('files') ) {
            foreach( $request->file('files') as $file ) {
                $files[] = $this->upload_gallery( $file );
            }
        }
        if( count( $files ) > 0 ) {
            $files = implode(',', $files);
            Media::create(['product_id' => $product->id, 'type' => 'gallery', 'files' => $files] );
        }

        if( $request->video ) {
            Media::create(['product_id' => $product->id, 'type' => 'video', 'files' => $request->video]);
        }
        
        $meta = [
            'product_id' => $product->id,
            'color' => $request->color ? implode(',', $request->color) : '',
            'size' => $request->sizes ? implode(',', $request->sizes) : ''
        ];

        ProductMeta::create( $meta );

        $files_color = array();
        if($request->color){
            foreach($request->color as $key1 => $value1):
                
                foreach($request->file('images') as $key => $value):
                    $files_color[] = $this->upload_feature($request->file('images')[$key]);
                endforeach;
                $color_images = json_encode($files_color);      
                
                $meta1 = [
                    'product_id' => $product->id,
                    'color' => $value1 ? $value1 : '',
                    'su_code'=> $request->su_code ? $_POST['su_code'][$key1] : '',
                    'images' => $color_images,
                     'color_image_alt' => $request->color_image_alt ?? '',
                ];
                product_meta_colors::create( $meta1 );
            endforeach;
        }


        if( $request->brand && count( $request->brand ) > 0 ) {
            foreach( $request->brand as $value) {
                BrandRelation::create(['brand_id' => $value, 'product_id' => $product->id]);
            }
        }



        ProductUser::create(['user_id' => Auth::id(), 'product_id' => $product->id]);

        /*$product_price_qty = new ProductPriceQuantity();
        $product_price_qty->product_id = $product->id;
        $product_price_qty->amount = $request->price;
        $product_price_qty->discount = $request->discount;
        $product_price_qty->quantity = $request->quantity;
        $product_price_qty->save();*/

        return redirect(route('product.edit', $product->id))->with('product_msg', 'Product inserted successfully ID'.$product_id);
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

        $product = Product::where('id', $id)->with(['productMeta', 'product_brand', 'product_attribute', 'product_attribute_meta', 'media', 'product_category'])->first();
        return view( _admin('product/edit'), ['title' => 'Edit product', 'product' => $product] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {

        // if( !User::isAdmin() )
        //     return redirect( url('/') );



        if($request->gallery && count($request->gallery) <= 0){
          Media::delete(['product_id' => $product_id, 'type' => 'gallery']);       
          return true;   
      }
      
      $pro = Product::findOrFail( $product_id );

      $oldData = $pro->toArray();

        // dd($pro);
      if( !$pro )
        return redirect()->back()->with('product_err', 'Product not found!');

    $feature_image = $request->hasFile('file') ? $this->upload_feature( $request->file('file') ) : '';
    if( !$feature_image ) {
        $validator = Validator::make( $request->all() , ['feature_image' => 'required'],
            ['feature_image.required' => 'Feature image is required *']);

        if( $validator->fails() )
            return redirect()->back()->withErrors($validator)->withInput();

        $feature_image = $request->feature_image;
    }

    if( $request->hasFile('file') ) {
        $extension = get_extension( $pro->feature_image );
        $filename = get_filename( $pro->feature_image );
        $filepath = public_path(product_file($filename.'-'.config('filesize.medium.0').'x'.config('filesize.medium.1').$extension));
        File::delete( $filepath );

        $filepath = public_path(product_file($filename.'-'.config('filesize.thumbnail.0').'x'.config('filesize.thumbnail.1').$extension));
        File::delete( $filepath );

        $filepath = public_path(product_file($filename.'-'.config('filesize.large.0').'x'.config('filesize.large.1').$extension));
        File::delete( $filepath );
        File::delete( public_path(product_file($pro->feature_image)) );
    }


    $medias = Media::where('product_id', $product_id)->first();
    $gallery = [];
    if( $medias ) {
        $files = explode(',', $medias->files);
            // var_dump($files);
            // echo "<br>";
        if( $files && count( $files ) ) {
            foreach ($files as $file) {
                $file.'<br>';
                if( !$request->gallery || !in_array($file, $request->gallery) ) {
                    $extension = get_extension( $file );
                    $filename = get_filename( $file );
                    $filepath = public_path(product_file($filename.'-'.config('filesize.medium.0').'x'.config('filesize.medium.1').'.'.$extension));
                    File::delete( $filepath );
                }
                else {
                    $gallery[] = $file;
                }
            }
        }
    }

    

        // var_dump($medias = Media::where('product_id', $product_id)->first()->files);
    

    
    if( $request->hasFile('files') ) {
        foreach( $request->file('files') as $file ) {

            $gallery[] = $this->upload_gallery( $file );
            
        }
    }

    if( count( $gallery ) > 0 ) {
        $gallery = implode(',', $gallery);
        if( Media::where('product_id', $product_id)->first() ){
            Media::where('product_id', $product_id)->update(['files' => $gallery]);
            
        }
        else{
            Media::create(['product_id' => $product_id, 'type' => 'gallery', 'files' => $gallery]);                
            echo "string";
        }
    }

    if( $request->video ) {
        
        if( $id = Media::where(['product_id' => $product_id, 'type' => 'video'])->value('id') )
            Media::where('id', $id)->update(['files' => $request->video]);
        else if( $request->video )
            Media::create(['product_id' => $product_id, 'type' => 'video', 'files' => $request->video]);
    }
   


if ($request->video) {
    if ($id = Media::where(['product_id' => $product_id, 'type' => 'video'])->value('id')) {
        Media::where('id', $id)->update([
            'files'    => $request->video,
            'file_alt' => $request->file_alt
        ]);
    } else {
        Media::create([
            'product_id' => $product_id,
            'type'       => 'video',
            'files'      => $request->video,
            'file_alt'   => $request->file_alt
        ]);
    }
}

    
    
    $array['category_id'] = $request->category[0];
    $array['title'] = $request->title;
    $array['slug'] = slug( $request->slug );
    $array['content'] = $request->content;
    $array['faq'] = $request->faq;
    $array['feature_image_alt'] = $request->feature_image_alt;
    $array['file_alt'] = $request->file_alt;
    $array['short_content'] = $request->short_content;
    $array['excerpt'] = get_excerpt( $request->content, 500 );
    if( $request->is_feature )
        $array['type'] = 'featured';
    else
        $array['type'] = null;
    $array['tags'] = $request->tags;

    if($request->price == 0 OR $request->price == ''){
        
        $array['price'] = $request->mrp;
    }else{
        $array['price'] = $request->price;
    }

    
    
    $array['product_code'] = $request->product_code;
    $array['gst'] = $request->gst;
    $array['mrp'] = $request->mrp;
    $array['price_range'] = $request->price_range;
    $array['shipping_charge'] = $request->shipping_charge;
    $array['discount'] = $request->discount;
    $array['quantity'] = $request->quantity;
    $array['tax'] = $request->tax;

    $array['metakey'] = $request->metakey;
    $array['metatitle'] = $request->metatitle;
    $array['metadescription'] = $request->metadescription;
    $array['postmeta'] = $request->postmeta;
    
    $array['brand'] = $request->brand ? implode(',', $request->brand) : null;
    $array['available'] = $request->quantity;
    $array['delivery_time'] = $request->delivery_time;
    $array['buy_also'] = $request->buy_also;
    $array['payment_option'] = $request->payment_option ? implode(',', $request->payment_option) : null;
    
    if( $feature_image ) $array['feature_image'] = $feature_image;


        // dd($array);

    $pro->fill($array)->update();

    $newData = $pro->toArray();

    LogsModel::create(['user_id' => Auth::id(),'remark'=>'Update Product','status'=>'product', 'working_id' => $product_id,'old_data'=> json_encode($oldData),'new_data' => json_encode($newData)]);

    CategoryProduct::where('product_id', $product_id)->delete();
    foreach ( $request->category as $value ) {
        CategoryProduct::create(['category_id' => $value, 'product_id' => $product_id]);   
    }


    ProductAttribute::where(['product_id' => $product_id, 'attribute_name' => 'size'])->delete();
    ProductAttributeMeta::where(['product_id' => $product_id, 'type' => 'size'])->delete();
    if( $request->sizes && count($request->sizes) > 0 ) {
        
        $attribute = ['product_id' => $product_id, 'attribute_name' => 'size'];
        $product_attribute_id = ProductAttribute::create($attribute)->id;

        
        foreach ($request->sizes as $key => $s) {
            if( $s !== '' ) {
                $sizes = array(
                    'product_id' => $product_id,
                    'product_attribute_id' => $product_attribute_id,
                    'type' => 'size',
                    'name' => strtolower($s),
                    'value' => json_encode([
                        'name' => strtolower($s),
                        'stock' => isset($request->stock[$key]) ? $request->stock[$key] : null,
                        'price' => isset($request->rate[$key]) ? $request->rate[$key] : null,
                    ])
                );
                ProductAttributeMeta::create($sizes);
            }
        }
    }


    ProductAttribute::where(['product_id' => $product_id, 'attribute_name' => 'shoe_size'])->delete();
    ProductAttributeMeta::where(['product_id' => $product_id, 'type' => 'shoe_size'])->delete();
    if( $request->shoe_size && count($request->shoe_size) > 0 ) {
        $attribute = ['product_id' => $product_id, 'attribute_name' => 'shoe_size'];
        $product_attribute_id = ProductAttribute::create($attribute)->id;
        foreach ($request->shoe_size as $key => $s) {
            $sizes = array(
                'product_id' => $product_id,
                'product_attribute_id' => $product_attribute_id,
                'type' => 'shoe_size',
                'name' => strtolower($s),
                'value' => json_encode([
                    'name' => strtolower($s),
                    'stock' => isset($request->shoe_stock[$key]) ? $request->shoe_stock[$key] : null,
                    'price' => isset($request->shoe_rate[$key]) ? $request->shoe_rate[$key] : null,
                ])
            );
            ProductAttributeMeta::create($sizes);
        }
    }

    ProductAttribute::where(['product_id' => $product_id, 'attribute_name' => 'waist_size'])->delete();
    ProductAttributeMeta::where(['product_id' => $product_id, 'type' => 'waist_size'])->delete();
    if( $request->waist_size && count($request->waist_size) > 0 ) {
        $attribute = ['product_id' => $product_id, 'attribute_name' => 'waist_size'];
        $product_attribute_id = ProductAttribute::create($attribute)->id;
        foreach ($request->waist_size as $key => $s) {
            $sizes = array(
                'product_id' => $product_id,
                'product_attribute_id' => $product_attribute_id,
                'type' => 'waist_size',
                'name' => strtolower($s),
                'value' => json_encode([
                    'name' => strtolower($s),
                    'stock' => isset($request->waist_stock[$key]) ? $request->waist_stock[$key] : null,
                    'price' => isset($request->waist_rate[$key]) ? $request->waist_rate[$key] : null,
                ])
            );
            ProductAttributeMeta::create($sizes);
        }
    }

    ProductAttribute::where(['product_id' => $product_id, 'attribute_name' => 'child_size'])->delete();
    ProductAttributeMeta::where(['product_id' => $product_id, 'type' => 'child_size'])->delete();
    if( $request->child_size && count($request->child_size) > 0 ) {
        $attribute = ['product_id' => $product_id, 'attribute_name' => 'child_size'];
        $product_attribute_id = ProductAttribute::create($attribute)->id;
        foreach ($request->child_size as $key => $s) {
            $sizes = array(
                'product_id' => $product_id,
                'product_attribute_id' => $product_attribute_id,
                'type' => 'child_size',
                'name' => strtolower($s),
                'value' => json_encode([
                    'name' => strtolower($s),
                    'stock' => isset($request->child_stock[$key]) ? $request->child_stock[$key] : null,
                    'price' => isset($request->child_rate[$key]) ? $request->child_rate[$key] : null,
                ])
            );
            ProductAttributeMeta::create($sizes);
        }
    }


    ProductAttribute::where(['product_id' => $product_id, 'attribute_name' => 'dimension'])->delete();
    ProductAttributeMeta::where(['product_id' => $product_id, 'type' => 'dimension'])->delete();

    if( $request->dimension_type && count($request->dimension_type) > 0 ) {
        
        $attribute = ['product_id' => $product_id, 'attribute_name' => 'dimension'];
        $product_attribute_id = ProductAttribute::create($attribute)->id;
        
        foreach ($request->dimension_type as $key => $s) {
            if( $s !== '' ) {
                $dimension = array(
                    'product_id' => $product_id,
                    'product_attribute_id' => $product_attribute_id,
                    'type' => 'dimension',
                    'name' => strtolower($s),
                    'value' => json_encode([
                        'type' => strtolower($s),
                        'width' => isset($request->width[$key]) ? $request->width[$key] : null,
                        'height' => isset($request->height[$key]) ? $request->height[$key] : null,
                        'length' => isset($request->length[$key]) ? $request->length[$key] : null,
                        'weight' => isset($request->weight[$key]) ? $request->weight[$key] : null,
                        'price' => isset($request->dimension_price[$key]) ? $request->dimension_price[$key] : null,
                    ])
                );
                ProductAttributeMeta::create($dimension);
            }
        }
    }

    ProductAttribute::where(['product_id' => $product_id, 'attribute_name' => 'custom_size'])->delete();
    ProductAttributeMeta::where(['product_id' => $product_id, 'type' => 'custom_size'])->delete();

    $files_size_color = array();
    if( $request->custom_size && count($request->custom_size) > 0 ) {
        
        $attribute = ['product_id' => $product_id, 'label' => $request->label, 'attribute_name' => 'custom_size'];
        $product_attribute_id = ProductAttribute::create($attribute)->id;
        
        foreach ($request->custom_size as $key => $s) {

            if( $s && isset($request->custom_size_price[$key]) && $request->custom_size_price[$key] ) {
               
                $files_size_color = null;

                if(isset($_FILES['custom_size_image']['name'][$key]) && $_FILES['custom_size_image']['name'][$key]) {
            // Upload the new image
                    $files_size_color = $this->upload_feature($request->file('custom_size_image')[$key]);
                } else if(isset($request->old_custom_size_image[$key]) && $request->old_custom_size_image[$key]) {
            // Use the existing image
                    $files_size_color = $request->old_custom_size_image[$key];
                }

                $custom_size = array(
                    'product_id' => $product_id,
                    'product_attribute_id' => $product_attribute_id,
                    'type' => 'custom_size',
                    'name' => strtolower($s),
                    'value' => json_encode([
                        'name' => strtolower($s),
                        'price' => isset($request->custom_size_price[$key]) ? $request->custom_size_price[$key] : null,
                        'stock' => isset($request->custom_size_stock[$key]) ? $request->custom_size_stock[$key] : null,
                        'size_image' => $files_size_color,
                        'custom_size_image_alt' => isset($request->custom_size_image_alt[$key]) ? $request->custom_size_image_alt[$key] : null,
                    ])
                );

                ProductAttributeMeta::create($custom_size);
            }
        }

    }

    $meta = [
        'product_id' => $product_id,
        'color' => $request->color ? implode(',',$request->color) : '',
        'size' => $request->sizes ? implode(',', $request->sizes) : ''
    ];

    if( ProductMeta::where('product_id', $product_id)->first() )
        ProductMeta::where('product_id', $product_id)->update($meta);
    else 
        ProductMeta::create($meta);


    BrandRelation::where('product_id', $product_id)->delete();
    if( $request->brand && count( $request->brand ) > 0 ) {
        foreach($request->brand as $value) {
            BrandRelation::create(['brand_id' => $value, 'product_id' => $product_id]);
        }
    }

    if( !ProductUser::where('product_id', $product_id)->value('id') )
        ProductUser::create(['user_id' => $pro->user_id, 'product_id' => $product_id]);


    $files_color = array();
    if( !empty($_FILES['images']['name']) AND $_FILES['images']['name'] !='' ){
        if($request->color){
            foreach($request->color as $key1 => $value1):
              
                foreach($request->file('images') as $key => $value):
                    $files_color[] = $this->upload_feature($request->file('images')[$key]);
                endforeach;
                $color_images = json_encode($files_color);

                $meta1 = [
                    'product_id' => $product_id,
                    'color' => $value1 ? $value1 : '',
                    'su_code'=> $request->su_code ? $_POST['su_code'][$key1] : '',
                    'images' => $color_images,
                    'color_image_alt' => $request->color_image_alt ?? '',
                ];
                product_meta_colors::create( $meta1 );
            endforeach;
        }
       

    }

    return redirect()->back()->with('product_msg', 'Product updated successfully ID'.$pro->product_id);
}

public function upload_feature( $image ) {
    $hashname = clean( $image->getClientOriginalName() ) . '-' . randomString(8);
    $filename = $hashname . '-' . config('filesize.thumbnail.0') . 'x' . config('filesize.thumbnail.1') . '.' . $image->getClientOriginalExtension();
    FileManager::upload( $filename, $image, public_path( product_file() ), config('filesize.thumbnail.0'), config('filesize.thumbnail.1') );

    $filename = $hashname . '-' . config('filesize.medium.0') . 'x' . config('filesize.medium.1') .
    '.' . $image->getClientOriginalExtension();
    FileManager::upload( $filename, $image, public_path( product_file() ), config('filesize.medium.0'), config('filesize.medium.1') );

    $filename = $hashname . '-' . config('filesize.large.0') . 'x' . config('filesize.large.1') .
    '.' . $image->getClientOriginalExtension();
    FileManager::upload( $filename, $image, public_path( product_file() ), config('filesize.large.0'), config('filesize.large.1') );

    $filename = $hashname . '.' . $image->getClientOriginalExtension();
    FileManager::upload( $filename, $image, public_path( product_file() ) );

    return $filename;
}

public function upload_gallery( $image ) {
    $hashname = clean( $image->getClientOriginalName() ) . '-' . randomString(8);
    $filename = $hashname . '-' . config('filesize.thumbnail.0') . 'x' . config('filesize.thumbnail.1') . '.' . $image->getClientOriginalExtension();
    FileManager::upload( $filename, $image, public_path( product_file() ), config('filesize.thumbnail.0'), config('filesize.thumbnail.1') );

    $filename = $hashname . '-' . config('filesize.large.0') . 'x' . config('filesize.large.1') .
    '.' . $image->getClientOriginalExtension();
    FileManager::upload( $filename, $image, public_path( product_file() ), config('filesize.large.0'), config('filesize.large.1') );

    $filename = $hashname . '.' . $image->getClientOriginalExtension();
    FileManager::upload( $filename, $image, public_path( product_file() ) );

    return $filename;
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
        
        $product = Product::where( 'id', $id )->first();

        if( !$product )
            return redirect()->back()->with('product_err', 'Something went wrong, product could not delete!');

        $extension = get_extension( $product->feature_image );
        $filename = get_filename( $product->feature_image );
        $filepath = public_path(product_file($filename.'-'.config('filesize.medium.0').'x'.config('filesize.medium.1').$extension));
        File::delete( $filepath );
        $filepath = public_path(product_file($filename.'-'.config('filesize.thumbnail.0').'x'.config('filesize.thumbnail.1').$extension));
        File::delete( $filepath );
        $filepath = public_path(product_file($filename.'-'.config('filesize.large.0').'x'.config('filesize.large.1').$extension));
        File::delete( $filepath );
        File::delete( public_path(product_file($product->feature_image)) );

        $medias = Media::where('product_id', $product->id)->first();
        if( $medias ) {
            $files = explode(',', $medias->files);
            if( $files && count( $files ) ) {
                foreach ($files as $file) {
                    $extension = get_extension( $file );
                    $filename = get_filename( $file );
                    $filepath = public_path(product_file($filename.'-'.config('filesize.medium.0').'x'.config('filesize.medium.1').'.'.$extension));
                    File::delete( $filepath );
                }
            }
        }

        Product::where( 'id', $id )->delete();
        Media::where('product_id', $id)->delete();
        ProductMeta::where('product_id', $id)->delete();
        ProductAttributeMeta::where('product_id', $id)->delete();
        ProductAttribute::where('product_id', $id)->delete();
        CategoryProduct::where('product_id', $id)->delete();

        ProductUser::where('product_id', $id)->delete();

        LogsModel::create(['user_id' => Auth::id(),'remark'=>'Delete Product','status'=>'product', 'working_id' => $product->id]);

        return redirect()->back()->with('product_msg', 'Product deleted!');
    }


    public function delete( Request $request ) {
        // if( !User::isAdmin() )
        //     return;

        if( !$request->ajax() )
            return;

        foreach ($request->ids as $id) {
            $product = Product::where( 'id', $id )->first();

            if( !$product )
                return response()->json(['message' => 'failed']);

            $extension = get_extension( $product->feature_image );
            $filename = get_filename( $product->feature_image );
            $filepath = public_path(product_file($filename.'-'.config('filesize.medium.0').'x'.config('filesize.medium.1').$extension));
            File::delete( $filepath );
            $filepath = public_path(product_file($filename.'-'.config('filesize.thumbnail.0').'x'.config('filesize.thumbnail.1').$extension));
            File::delete( $filepath );
            $filepath = public_path(product_file($filename.'-'.config('filesize.large.0').'x'.config('filesize.large.1').$extension));
            File::delete( $filepath );
            File::delete( public_path(product_file($product->feature_image)) );

            $medias = Media::where('product_id', $product->id)->first();
            if( $medias ) {
                $files = explode(',', $medias->files);
                if( $files && count( $files ) ) {
                    foreach ($files as $file) {
                        $extension = get_extension( $file );
                        $filename = get_filename( $file );
                        $filepath = public_path(product_file($filename.'-'.config('filesize.medium.0').'x'.config('filesize.medium.1').'.'.$extension));
                        File::delete( $filepath );
                    }
                }
            }

            Product::where( 'id', $id )->delete();
            Media::where('product_id', $id)->delete();
            ProductMeta::where('product_id', $id)->delete();
            ProductAttributeMeta::where('product_id', $id)->delete();
            ProductAttribute::where('product_id', $id)->delete();
            CategoryProduct::where('product_id', $id)->delete();
            ProductUser::where('product_id', $id)->delete();
            LogsModel::create(['user_id' => Auth::id(),'remark'=>'Delete Product','status'=>'product', 'working_id' => $id]);
        }
        return response()->json(['message' => 'success']);
    }


    public function update_status( Request $request ) {

        // if( !User::isAdmin() )
        //     return;
        
        if( !$request->ajax() )
            return;

        if( !$request->id || !$request->status )
            return;

        Product::where('id', $request->id)->update(['status' => $request->status, 'remark' => $request->remark]);

        LogsModel::create(['user_id' => Auth::id(),'remark'=>'Product Status Update','status'=>'product', 'working_id' => $request->id]);

        return response()->json(['message' => 'success']);
    }

    public function product_delete(){
        echo 'ddd';
    }

    public function remove_sucode_color(Request $request){
        
        $all = ProductMeta::where('product_id', $request->product_id)->first(); 
        $oldcolor = explode(',', $all->color);
        // Search
        $pos = array_search($request->color_name, $oldcolor);
        unset($oldcolor[$pos]);
        ProductMeta::where('product_id', $request->product_id)->update(['color' => implode(',',$oldcolor )]);    
        product_meta_colors::where('id',$request->rowid)->delete(); 

        LogsModel::create(['user_id' => Auth::id(),'remark'=>'Product Color Update','status'=>'product', 'working_id' => $request->product_id]);

        return response()->json(['message' => 'success']);

    }
}
