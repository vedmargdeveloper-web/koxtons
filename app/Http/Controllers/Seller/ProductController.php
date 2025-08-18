<?php

namespace App\Http\Controllers\Seller;

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
use App\model\Brand;
use App\model\BrandRelation;
use App\model\ProductUser;
use App\User;
use Image;
use Auth;
use Validator;
use Session;
use Input;

class ProductController extends Controller
{

    protected $thumb = [150, 150];
    protected $medium = [300, 300];

    public function __construct()
    {
        $this->middleware('auth');    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( !User::isSeller() )
            return redirect('/');

        if( Auth::user()->profile !== 'completed' )
                return redirect()->route('seller.setup', Auth::user()->uid);

        return view('seller.product.index')->with('title', 'Products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if( !User::isSeller() )
            return redirect('/');

        if( Auth::user()->profile !== 'completed' )
                return redirect()->route('seller.setup', Auth::user()->uid);

        return view('seller.product.create')->with('title', 'Add Product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

        if( !User::isSeller() )
            return redirect( url('/') );
        
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
        $product->excerpt = get_excerpt( $request->content, 30 );
        if( $request->is_feature )
            $product->type = 'featured';
        $product->tags = $request->tags;
        $product->brand = $request->brand ? implode(',', $request->brand) : null;
        $product->feature_image = $feature_image;
        $product->price = $request->price;
        $product->seller_price = $request->price;
        $product->mrp = $request->mrp;
        $product->price_range = $request->price_range;
        $product->shipping_charge = $request->shipping_charge;
        $product->discount = $request->discount;
        $product->quantity = $request->quantity;
        $product->available = $request->quantity;
        $product->buy_also = $request->buy_also;
        $product->gst = $request->gst;
        $product->payment_option = $request->payment_option ? implode(',', $request->payment_option) : null;
        $product->status = 'inactive';
        $product->save();

        if( !$product->id )
            return redirect()->back()->with('product_err', 'Product could not insert, please try again later!')->withInput();

        foreach ( $request->category as $value ) {
            CategoryProduct::create(['category_id' => $value, 'product_id' => $product->id]);   
        }

        $sizesArray = ['s', 'm', 'l', 'xl', 'xxl', 'xxxl', 'free-size', 'one-size'];
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

        $shoesizesArray = [5, 6, 7, 8, 9, 10,11];
        $attribute = ['product_id' => $product->id, 'attribute_name' => 'shoe_size'];
        $product_attribute_id = ProductAttribute::create($attribute)->id;
        if( $request->shoe_sizes && count( $request->shoe_sizes ) > 0 ) {
            foreach ( $request->shoe_sizes as $key => $s ) {
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

        $shoesizesArray = [28, 30, 32, 34, 36, 38, 40];
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

        $shoesizesArray = [28, 30, 32, 34, 36, 38, 40];
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

        if( $request->custom_size && count($request->custom_size) > 0 ) {
            $attribute = ['product_id' => $product->id, 'label' => $request->label, 'attribute_name' => 'custom_size'];
            $product_attribute_id = ProductAttribute::create($attribute)->id;
            foreach ($request->custom_size as $key => $s) {
                if( $s !== '' ) {
                    $custom_size = array(
                                    'product_id' => $product->id,
                                    'product_attribute_id' => $product_attribute_id,
                                    'type' => 'custom_size',
                                    'name' => strtolower($s),
                                    'value' => json_encode([
                                                'name' => strtolower($s),
                                                'price' => isset($request->custom_size_price[$key]) ? $request->custom_size_price[$key] : null,
                                                ])
                                );
                    ProductAttributeMeta::create($custom_size);
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
            Media::create(['product_id' => $product->id, 'type' => 'gallery', 'files' => $files]);
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

        if( $request->brand && count( $request->brand ) > 0 ) {
            foreach( $request->brand as $value) {
                BrandRelation::create(['brand_id' => $value, 'product_id' => $product->id]);
            }
        }

        ProductUser::create(['user_id' => Auth::id(), 'product_id' => $product->id]);

        return redirect(route('seller.product.edit',$product->id))->with('product_msg','Product inserted successfully ID'.$product_id);
    }


    public function upload( $image ) {
        $hashname = clean( $image->getClientOriginalName() ) . '-' . randomString(8);
        $filename = $hashname . '-' . $this->thumb[0] . 'x' . $this->thumb[1] . '.' . $image->getClientOriginalExtension();
        File::upload( $filename, $image, public_path( product_file() ), $this->thumb[0],$this->thumb[1] );

        $filename = $hashname . '-' . $this->medium[0] . 'x' . $this->medium[1] .
                    '.' . $image->getClientOriginalExtension();
        File::upload( $filename, $image, public_path( product_file() ), $this->medium[0], $this->medium[1] );

        $filename = $hashname . '.' . $image->getClientOriginalExtension();
        File::upload( $filename, $image, public_path( product_file() ) );

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
        if( !User::isSeller() )
            return redirect( url('/') );

        if( Auth::user()->profile !== 'completed' )
                return redirect()->route('seller.setup', Auth::user()->uid);

        $product = Product::where('id', $id)->with(['productMeta', 'product_attribute', 'product_attribute_meta', 'media', 'product_category'])->first();

        if( $product && $product->status === 'active' )
            return redirect()->route('seller.products');


        return view('seller.product.edit', ['title' => 'Edit product', 'product' => $product] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    public function update(ProductRequest $request, $product_id)
    {

        if( !User::isSeller() )
            return redirect( url('/') );
        
        $pro = Product::findOrFail( $product_id );
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
        if( $medias ) {
            $files = explode(',', $medias->files);
            if( $files && count( $files ) ) {
                foreach ($files as $file) {
                    $file.'<br>';
                    if( !$request->gallery || !in_array($file, $request->gallery) ) {
                        $extension = get_extension( $file );
                        $filename = get_filename( $file );
                        $filepath = public_path(product_file($filename.'-'.config('filesize.medium.0').'x'.config('filesize.medium.1').'.'.$extension));
                        File::delete( $filepath );
                    }
                }
            }
        }

        $files = $request->gallery ? $request->gallery : array();
        if( $request->hasFile('files') ) {
            foreach( $request->file('files') as $file ) {
                $files[] = $this->upload_gallery( $file );
            }
        }

        if( count( $files ) > 0 ) {
            $files = implode(',', $files);
            if( Media::where('product_id', $product_id)->first() )
                Media::where('product_id', $product_id)->update(['files' => $files]);
            else
                Media::create(['product_id' => $product_id, 'type' => 'gallery', 'files' => $files]);                
        }

        
        if( $id = Media::where(['product_id' => $product_id, 'type' => 'video'])->value('id') )
            Media::where('id', $id)->update(['files' => $request->video]);
        else if( $request->video )
            Media::create(['product_id' => $product_id, 'type' => 'video', 'files' => $request->video]);
        
            
        $array['category_id'] = $request->category[0];
        $array['title'] = $request->title;
        $array['slug'] = slug( $request->title );
        $array['content'] = $request->content;
        $array['excerpt'] = get_excerpt( $request->content, 30 );
        if( $request->is_feature )
            $array['type'] = 'featured';
        else
            $array['type'] = null;
        $array['tags'] = $request->tags;
        $array['price'] = $request->price;
        $array['seller_price'] = $request->price;
        $array['mrp'] = $request->mrp;
        $array['price_range'] = $request->price_range;
        $array['shipping_charge'] = $request->shipping_charge;
        $array['discount'] = $request->discount;
        $array['quantity'] = $request->quantity;
        $array['tax'] = $request->tax;
        $array['brand'] = $request->brand ? implode(',', $request->brand) : null;
        $array['available'] = $request->quantity;
        $array['buy_also'] = $request->buy_also;
        $array['gst'] = $request->gst;
        $array['payment_option'] = $request->payment_option ? implode(',', $request->payment_option) : null;
        
        if( $feature_image ) $array['feature_image'] = $feature_image;

        $pro->fill($array)->save();

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

        if( $request->custom_size && count($request->custom_size) > 0 ) {
            
            $attribute = ['product_id' => $product_id, 'label' => $request->label, 'attribute_name' => 'custom_size'];
            $product_attribute_id = ProductAttribute::create($attribute)->id;
            
            foreach ($request->custom_size as $key => $s) {
                if( $s && isset($request->custom_size_price[$key]) && $request->custom_size_price[$key] ) {
                    $custom_size = array(
                                    'product_id' => $product_id,
                                    'product_attribute_id' => $product_attribute_id,
                                    'type' => 'custom_size',
                                    'name' => strtolower($s),
                                    'value' => json_encode([
                                                'name' => strtolower($s),
                                                'price' => isset($request->custom_size_price[$key]) ? $request->custom_size_price[$key] : null,
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
        //
    }
}
