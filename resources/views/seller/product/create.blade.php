@extends('seller.app')

@section('title', $title)

@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12">
            <div class="breadcrumb">
                <h1>{{ $title }}</h1>
            </div>
            <a href="{{ route('seller.products') }}">Go back</a> | 
            <a href="{{ route('seller.product.create') }}" title="Add Product">Add <span class="fa fa-plus"></span></a>

            <div class="separator-breadcrumb border-top"></div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12 col-lg-12 col-xs-12">
            
            @if( Session::has('product_err') )
                <span class="text-warning">{{ Session::get('product_err') }}</span>
            @endif

            @if( Session::has('product_msg') )
                <span class="label-success">{{ Session::get('product_msg') }}</span>
            @endif


            {{ Form::open(['url' => route('seller.product.store'), 'files' => true]) }}

            <div class="form-container pb-3">
                
                <div class="row mb-2">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Title</label>
                            <span>(Give a title of your service/product)</span>
                            <input type="text" value="{{ old('title') }}" name="title" placeholder="Title" class="form-control" placeholder="">
                            @if( $errors->has('title') )
                                <span class="text-warning">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group mb-3">
                            <button class="btn btn-primary" name="submit" value="inactive">Submit</button>
                        </div>
                    </div>
                </div>

                <div class="row" style="border-bottom: 1px solid #f2f2f2;">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Content</label>
                            <span>(Give a brief description about your service/product)</span>
                            <textarea class="form-control texteditor" name="content" rows="5" placeholder="Description">{{ old('content') }}</textarea>
                            @if( $errors->has('content') )
                                <span class="text-warning">{{ $errors->first('content') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                        <div class="form-group">
                            <label>Category</label>
                            <span>(You can select multiple categories)</span>
                            <?php $category = App\model\Category::all(); ?>
                            @if( old('category') )
                                <?php $c = implode(',', old('category')); ?>
                                <script type="text/javascript">
                                    $(document).ready(function(e){
                                        v = "<?php echo $c; ?>";
                                        v = v.split(',');
                                        $('.multi-selector.category').val(v).trigger('chosen:updated');
                                    })
                                </script>
                            @endif
                            <select class="form-control multi-selector category" data-placeholder="Select Category" name="category[]" multiple>
                                @if( $category )
                                    @foreach( $category as $row )
                                        @if( !$row->parent )
                                            <option style="font-weight: bold;" value="{{ $row->id }}">{{ ucfirst($row->name) }}</option>
                                            @foreach( $category as $child )
                                                @if( $row->id == $child->parent )
                                                    <option style="padding-left: 15px;" value="{{ $child->id }}">{{ ucfirst($child->name) }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            
                            @if( $errors->has('category.*') )
                                <span class="text-warning">{{ $errors->first('category.*') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Brand</label>
                            <span>(You can select multiple brand)</span>
                            <?php $brand = App\model\Brand::orderby('name', 'ASC')->get(); ?>
                            @if( old('brand') )
                                <?php $c = implode(',', old('brand')); ?>
                                <script type="text/javascript">
                                    $(document).ready(function(e){
                                        v = "<?php echo $c; ?>";
                                        v = v.split(',');
                                        $('.multi-selector.brand').val(v).trigger('chosen:updated');
                                    })
                                </script>
                            @endif
                            <select class="form-control multi-selector brand" data-placeholder="Select Brand" name="brand[]" multiple>
                                @if( $brand )
                                    @foreach( $brand as $row )
                                        <option value="{{ $row->id }}">{{ ucfirst($row->name) }}</option>
                                    @endforeach
                                @endif
                            </select>
                            
                            @if( $errors->has('brand.*') )
                                <span class="label-warning">{{ $errors->first('brand.*') }}</span>
                            @endif
                        </div>

                        <div class="form-group mb-3" style="display: none;">
                            <label>Tags</label>
                            <span>(Add tags, separate by comma )</span>
                            <input type="text" value="{{ old('tags') }}" placeholder="Example: Hair Saloon" name="tags" data-role="tagsinput" class="form-control" />
                            @if( $errors->has('tags') )
                                <span class="text-warning">{{ $errors->first('tags') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Feature image (File size must be less than 1MB)</label>
                            <p><a href="https://techdost.org/icompress" target="_blank">Compress Image</a></p>
                            <input type="file" name="file" class="">
                            @if( $errors->has('file') )
                                <span class="text-warning">{{ $errors->first('file') }}</span>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- <div class="col-lg-4 col-md-4 float-left">
                
                    <div class="form-group mb-3">
                        
                        <button class="btn btn-primary" name="draft" value="inactive">Draft</button>
                    </div>
                
                    
                </div> -->
            </div>


            <div class="form-container col-lg-12 col-md-12">

                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 bhoechie-tab-menu">
                      <div class="list-group">
                        <a href="#" class="list-group-item active">
                          <span>Product Price<span>
                        </a>
                        <a href="#" class="list-group-item">
                          <span>Color</span>
                        </a>
                        <a href="#" class="list-group-item" style="">
                          <span>Size</span>
                        </a>
                        <a href="#" class="list-group-item" style="">
                          <span>Dimentions</span>
                        </a>
                        <a href="#" class="list-group-item">
                          <span>Images</span>
                        </a>
                        <a href="#" class="list-group-item">
                          <span>Buy Also Product</span>
                        </a>
                        <a href="#" class="list-group-item {{ $errors->has('payment_option.*') ? 'active' : '' }}">
                          <span>Payment Option</span>
                        </a>
                      </div>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-9 bhoechie-tab">
                        
                        <div class="bhoechie-tab-content active">
                            
                            <div class="form-group">
                                <label>Product Price (Must be a numeric value)</label>
                                <input type="number" min="0" value="{{ old('price') }}" name="price" placeholder="Price" class="form-control">
                                @if( $errors->has('price') )
                                    <span class="text-warning">{{ $errors->first('price') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Price Range</label>
                                <input type="text" value="{{ old('price_range') }}" name="price_range" placeholder="100 - 500" class="form-control">
                                @if( $errors->has('price_range') )
                                    <span class="text-warning">{{ $errors->first('price_range') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Product MRP</label>
                                <input type="number" min="0" value="{{ old('mrp') }}" name="mrp" placeholder="MRP" class="form-control">
                                @if( $errors->has('mrp') )
                                    <span class="text-warning">{{ $errors->first('mrp') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Product Shipping Charge (Must be numeric value)</label>
                                <input type="number" min="0" value="{{ old('shipping_charge') }}" name="shipping_charge" placeholder="Shipping charge" class="form-control">
                                @if( $errors->has('shipping_charge') )
                                    <span class="text-warning">{{ $errors->first('shipping_charge') }}</span>
                                @endif
                            </div>

                            <div class="form-group" style="display: none;">
                                <label>Product Tax (Tax must be numeric value between 1 - 100%)</label>
                                <input type="number" min="0" value="{{ old('tax') }}" name="tax" placeholder="Tax in % (numeric value)" class="form-control">
                                @if( $errors->has('tax') )
                                    <span class="text-warning">{{ $errors->first('tax') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>GST (GST must be numeric value between 1 - 100%)</label>
                                <input type="number" min="0" value="{{ old('gst') }}" name="gst" placeholder="GST in % (numeric value)" class="form-control">
                                @if( $errors->has('gst') )
                                    <span class="label-warning">{{ $errors->first('gst') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Product Discount (Discount must be between 1 - 100%, it will be calculated in %)</label>
                                <input type="number" min="0" max="100" value="{{ old('discount') }}" name="discount" placeholder="Discount" class="form-control">
                                @if( $errors->has('discount') )
                                    <span class="text-warning">{{ $errors->first('discount') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Product Quantity (Must be a numeric value)</label>
                                <input type="number" min="1" max="1000" value="{{ old('quantity') }}" name="quantity" placeholder="Quantity" class="form-control">
                                @if( $errors->has('quantity') )
                                    <span class="text-warning">{{ $errors->first('quantity') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="bhoechie-tab-content" id="colorQty">
                            <label>Select colors</label>
                            @if( old('color') )
                                <?php $color = implode(',', old('color')); ?>
                                <script type="text/javascript">
                                    $(document).ready(function(e){
                                        v = "<?php echo $color; ?>";
                                        v = v.split(',');
                                        $('.multi-selector.color').val(v).trigger('chosen:updated');
                                    })
                                </script>
                            @endif

                            <?php $colors = ['AliceBlue', 'AntiqueWhite', 'Aqua', 'Aquamarine', 'Azure', 'Beige', 'Bisque', 'Black', 'BlanchedAlmond', 'Blue', 'BlueViolet', 'Brown', 'BurlyWood', 'CadetBlue', 'Chartreuse', 'Chocolate', 'Coral', 'CornflowerBlue', 'Cornsilk', 'Crimson', 'Cyan', 'DarkBlue', 'DarkCyan', 'DarkGoldenRod', 'DarkGray', 'DarkGrey', 'DarkGreen', 'DarkKhaki', 'DarkMagenta', 'DarkOliveGreen', 'DarkOrange', 'DarkOrchid', 'DarkRed', 'DarkSalmon', 'DarkSeaGreen', 'DarkSlateBlue', 'DarkSlateGray', 'DarkSlateGrey', 'DarkTurquoise', 'DarkViolet', 'DeepPink', 'DeepSkyBlue', 'DimGray', 'DimGrey', 'DodgerBlue', 'FireBrick', 'FloralWhite', 'ForestGreen', 'Fuchsia', 'Gainsboro', 'GhostWhite', 'Gold', 'GoldenRod', 'Gray', 'Grey', 'Green', 'GreenYellow', 'HoneyDew', 'HotPink', 'IndianRed', 'Indigo', 'Ivory', 'Khaki', 'Lavender', 'LavenderBlush', 'LawnGreen', 'LemonChiffon', 'LightBlue', 'LightCoral', 'LightCyan', 'LightGoldenRodYellow', 'LightGray', 'LightGrey', 'LightGreen', 'LightPink', 'LightSalmon', 'LightSeaGreen', 'LightSkyBlue', 'LightSlateGray', 'LightSlateGrey', 'LightSteelBlue', 'LightYellow', 'Lime', 'LimeGreen', 'Linen', 'Magenta', 'Maroon', 'MediumAquaMarine', 'MediumBlue', 'MediumOrchid', 'MediumPurple', 'MediumSeaGreen', 'MediumSlateBlue', 'MediumSpringGreen', 'MediumTurquoise', 'MediumVioletRed', 'MidnightBlue', 'MintCream', 'MistyRose', 'Moccasin', 'NavajoWhite', 'Navy', 'OldLace', 'Olive', 'OliveDrab', 'Orange', 'OrangeRed', 'Orchid', 'PaleGoldenRod', 'PaleGreen', 'PaleTurquoise', 'PaleVioletRed', 'PapayaWhip', 'PeachPuff', 'Peru', 'Pink', 'Plum', 'PowderBlue', 'Purple', 'RebeccaPurple', 'Red', 'RosyBrown', 'RoyalBlue', 'SaddleBrown', 'Salmon', 'SandyBrown', 'SeaGreen', 'SeaShell', 'Sienna', 'Silver', 'SkyBlue', 'SlateBlue', 'SlateGray', 'SlateGrey', 'Snow', 'SpringGreen', 'SteelBlue', 'Tan', 'Teal', 'Thistle', 'Tomato', 'Turquoise', 'Violet', 'Wheat', 'White', 'WhiteSmoke', 'Yellow', 'YellowGreen'];
                            ?>

                            <select data-placeholder="Select color" class="form-control multi-selector color" name="color[]" multiple="">
                                @foreach( $colors as $color )
                                    <option value="{{ strtolower($color) }}">{{ $color }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('color') )
                                <span class="text-warning">{{ $errors->first('color') }}</span>
                            @endif
                            <div id="tag-holder"></div>
                        </div>
                        
                        <div class="bhoechie-tab-content" style="">


                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label>Select Sizes</label>                           

                                    <?php $sizesArray = ['s', 'm', 'l', 'xl', 'xxl',' xxxl', 'free-size', 'one-size']; ?>

                                    @if( old('sizes') && count( old('sizes') ) > 0 )

                                        @foreach(old('sizes') as $key => $s )

                                            <?php $key = array_search(strtolower($s), $sizesArray);
                                                        unset( $sizesArray[$key] ); ?>

                                            <div class="form-group mt-3">
                                                <label>{{ strtoupper($s) }}</label>
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="checkbox" checked value="{{ strtolower($s) }}" name="sizes[]" class="">
                                                    </span>
                                                  </div>
                                                  <input type="numeric" placeholder="Stock" value="{{ isset(old('stock')[$key]) ? old('stock')[$key] : '' }}" name="stock[]" class="form-control">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="number" value="{{ isset(old('rate')[$key]) ? old('rate')[$key] : '' }}" placeholder="Price" name="rate[]" class="form-control">
                                                    </span>
                                                  </div>
                                                </div>
                                            </div>

                                        @endforeach


                                        @foreach( $sizesArray as $key => $s )

                                            <div class="form-group mt-3">
                                                <label>{{ strtoupper($s) }}</label>
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="checkbox" value="{{ strtolower($s) }}" name="sizes[]" class="">
                                                    </span>
                                                  </div>
                                                  <input type="numeric" placeholder="Stock" value="" name="stock[]" class="form-control">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="number" value="" placeholder="Price" name="rate[]" class="form-control">
                                                    </span>
                                                  </div>
                                                </div>
                                            </div>

                                        @endforeach

                                    @else

                                        @foreach( $sizesArray as $key => $s )

                                            <div class="form-group mt-3">
                                                <label>{{ strtoupper($s) }}</label>
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="checkbox" value="{{ strtolower($s) }}" name="sizes[]" class="">
                                                    </span>
                                                  </div>
                                                  <input type="numeric" placeholder="Stock" value="" name="stock[]" class="form-control">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="number" value="" placeholder="Price" name="rate[]" class="form-control">
                                                    </span>
                                                  </div>
                                                </div>
                                            </div>

                                        @endforeach

                                    @endif

                                    @if( $errors->has('sizes.*') )
                                        <span class="text-warning">{{ $errors->first('sizes.*') }}</span>
                                    @endif

                                    @if( $errors->has('stock.*') )
                                        <span class="text-warning">{{ $errors->first('stock.*') }}</span>
                                    @endif

                                    @if( $errors->has('rate.*') )
                                        <span class="text-warning">{{ $errors->first('rate.*') }}</span>
                                    @endif
                                </div>

                                <div class="col-lg-3 col-md-3">
                                    <label>Waist Sizes</label>
                                    <?php $shoesizesArray = [28, 30, 32, 34, 36, 38, 40]; ?>

                                    @if( old('waist_size') && count( old('waist_size') ) > 0 )

                                        @foreach(old('waist_size') as $key => $s )

                                            <?php $key = array_search(strtolower($s), $shoesizesArray);
                                                        unset($shoesizesArray[$key]); ?>

                                            <div class="form-group mt-3">
                                                <label>{{ strtoupper($s) }}</label>
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="checkbox" checked value="{{ strtolower($s) }}" name="waist_size[]" class="">
                                                    </span>
                                                  </div>
                                                  <input type="numeric" placeholder="Stock" value="{{ isset(old('waist_stock')[$key]) ? old('waist_stock')[$key] : '' }}" name="waist_stock[]" class="form-control">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="number" value="{{ isset(old('waist_rate')[$key]) ? old('waist_rate')[$key] : '' }}" placeholder="Price" name="waist_rate[]" class="">
                                                    </span>
                                                  </div>
                                                </div>
                                            </div>

                                        @endforeach


                                        @foreach( $shoesizesArray as $key => $s )

                                            <div class="form-group mt-3">
                                                <label>{{ strtoupper($s) }}</label>
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="checkbox" value="{{ strtolower($s) }}" name="waist_size[]" class="">
                                                    </span>
                                                  </div>
                                                  <input type="numeric" placeholder="Stock" value="" name="waist_stock[]" class="form-control">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="number" value="" placeholder="Price" name="waist_rate[]" class="">
                                                    </span>
                                                  </div>
                                                </div>
                                            </div>

                                        @endforeach

                                    @else

                                        @foreach( $shoesizesArray as $key => $s )

                                            <div class="form-group mt-3">
                                                <label>{{ strtoupper($s) }}</label>
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="checkbox" value="{{ strtolower($s) }}" name="waist_size[]" class="">
                                                    </span>
                                                  </div>
                                                  <input type="numeric" placeholder="Stock" value="" name="waist_stock[]" class="form-control">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="number" value="" placeholder="Price" name="waist_rate[]" class="">
                                                    </span>
                                                  </div>
                                                </div>
                                            </div>

                                        @endforeach

                                    @endif


                                    @if( $errors->has('waist_size.*') )
                                        <span class="label-warning">{{ $errors->first('waist_size.*') }}</span>
                                    @endif

                                    @if( $errors->has('waist_stock.*') )
                                        <span class="label-warning">{{ $errors->first('waist_stock.*') }}</span>
                                    @endif

                                    @if( $errors->has('waist_rate.*') )
                                        <span class="label-warning">{{ $errors->first('waist_rate.*') }}</span>
                                    @endif
                                </div>

                                <div class="col-lg-3 col-md-3">
                                    <label>Footwear Sizes</label>

                                    <?php $shoesizesArray = [5, 6, 7, 8, 9, 10, 11]; ?>

                                    @if( old('shoe_size') && count( old('shoe_size') ) > 0 )

                                        @foreach(old('shoe_size') as $key => $s )

                                            <?php $key = array_search(strtolower($s), $shoesizesArray);
                                                        unset($shoesizesArray[$key]); ?>

                                            <div class="form-group mt-3">
                                                <label>{{ strtoupper($s) }}</label>
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="checkbox" checked value="{{ strtolower($s) }}" name="shoe_size[]" class="">
                                                    </span>
                                                  </div>
                                                  <input type="numeric" placeholder="Stock" value="{{ isset(old('shoe_stock')[$key]) ? old('shoe_stock')[$key] : '' }}" name="shoe_stock[]" class="form-control">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="number" value="{{ isset(old('shoe_rate')[$key]) ? old('shoe_rate')[$key] : '' }}" placeholder="Price" name="shoe_rate[]" class="">
                                                    </span>
                                                  </div>
                                                </div>
                                            </div>

                                        @endforeach


                                        @foreach( $shoesizesArray as $key => $s )

                                            <div class="form-group mt-3">
                                                <label>{{ strtoupper($s) }}</label>
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="checkbox" value="{{ strtolower($s) }}" name="shoe_size[]" class="">
                                                    </span>
                                                  </div>
                                                  <input type="numeric" placeholder="Stock" value="" name="shoe_stock[]" class="form-control">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="number" value="" placeholder="Price" name="shoe_rate[]" class="">
                                                    </span>
                                                  </div>
                                                </div>
                                            </div>

                                        @endforeach

                                    @else

                                        @foreach( $shoesizesArray as $key => $s )

                                            <div class="form-group mt-3">
                                                <label>{{ strtoupper($s) }}</label>
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="checkbox" value="{{ strtolower($s) }}" name="shoe_size[]" class="">
                                                    </span>
                                                  </div>
                                                  <input type="numeric" placeholder="Stock" value="" name="shoe_stock[]" class="form-control">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="number" value="" placeholder="Price" name="shoe_rate[]" class="">
                                                    </span>
                                                  </div>
                                                </div>
                                            </div>

                                        @endforeach

                                    @endif

                                    @if( $errors->has('shoe_size.*') )
                                        <span class="label-warning">{{ $errors->first('shoe_size.*') }}</span>
                                    @endif

                                    @if( $errors->has('shoe_stock.*') )
                                        <span class="label-warning">{{ $errors->first('shoe_stock.*') }}</span>
                                    @endif

                                    @if( $errors->has('shoe_rate.*') )
                                        <span class="label-warning">{{ $errors->first('shoe_rate.*') }}</span>
                                    @endif
                                </div>

                                <div class="col-lg-3 col-md-3">
                                    <label>Childrens Size</label>

                                    <?php $shoesizesArray = ['12-18 months', '18-24 months', '2-3 year', '3-4 year', '4-5 year', '5-6 year', '6-7 year', '7-8 year', '8-9 year', '9-10 year', '10-11 year', '11-12 year', '12-13 year', '13-14 year', '14-15 year', '15-16 year']; ?>

                                    @if( old('child_size') && count( old('child_size') ) > 0 )

                                        @foreach(old('child_size') as $key => $s )

                                            <?php $key = array_search(strtolower($s), $shoesizesArray);
                                                        unset($shoesizesArray[$key]); ?>

                                            <div class="form-group mt-3">
                                                <label>{{ strtoupper($s) }}</label>
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="checkbox" checked value="{{ strtolower($s) }}" name="child_size[]" class="">
                                                    </span>
                                                  </div>
                                                  <input type="numeric" placeholder="Stock" value="{{ isset(old('child_stock')[$key]) ? old('child_stock')[$key] : '' }}" name="child_stock[]" class="form-control">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="number" value="{{ isset(old('child_rate')[$key]) ? old('child_rate')[$key] : '' }}" placeholder="Price" name="child_rate[]" class="">
                                                    </span>
                                                  </div>
                                                </div>
                                            </div>

                                        @endforeach


                                        @foreach( $shoesizesArray as $key => $s )

                                            <div class="form-group mt-3">
                                                <label>{{ strtoupper($s) }}</label>
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="checkbox" value="{{ strtolower($s) }}" name="child_size[]" class="">
                                                    </span>
                                                  </div>
                                                  <input type="numeric" placeholder="Stock" value="" name="child_stock[]" class="form-control">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="number" value="" placeholder="Price" name="child_rate[]" class="">
                                                    </span>
                                                  </div>
                                                </div>
                                            </div>

                                        @endforeach

                                    @else

                                        @foreach( $shoesizesArray as $key => $s )

                                            <div class="form-group mt-3">
                                                <label>{{ strtoupper($s) }}</label>
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="checkbox" value="{{ strtolower($s) }}" name="child_size[]" class="">
                                                    </span>
                                                  </div>
                                                  <input type="numeric" placeholder="Stock" value="" name="child_stock[]" class="form-control">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <input type="number" value="" placeholder="Price" name="child_rate[]" class="">
                                                    </span>
                                                  </div>
                                                </div>
                                            </div>

                                        @endforeach

                                    @endif


                                    @if( $errors->has('child_size.*') )
                                        <span class="label-warning">{{ $errors->first('child_size.*') }}</span>
                                    @endif

                                    @if( $errors->has('child_stock.*') )
                                        <span class="label-warning">{{ $errors->first('child_stock.*') }}</span>
                                    @endif

                                    @if( $errors->has('child_rate.*') )
                                        <span class="label-warning">{{ $errors->first('child_rate.*') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bhoechie-tab-content" style="">
                            <div class="row" style="display: none;">
                                @if( $errors->has('dimension_type.*') )
                                    <p class="text-warning">{{ $errors->first('dimension_type.*') }}</p>
                                @endif
                                @if( $errors->has('weight.*') )
                                    <p class="text-warning">{{ $errors->first('weight.*') }}</p>
                                @endif
                                @if( $errors->has('width.*') )
                                    <p class="text-warning">{{ $errors->first('width.*') }}</p>
                                @endif
                                @if( $errors->has('height.*') )
                                    <p class="text-warning">{{ $errors->first('height.*') }}</p>
                                @endif
                                @if( $errors->has('length.*') )
                                    <p class="text-warning">{{ $errors->first('length.*') }}</p>
                                @endif
                                @if( $errors->has('dimension_price.*') )
                                    <p class="text-warning">{{ $errors->first('dimension_price.*') }}</p>
                                @endif
                                <table class="table table-bordered table-dimensions">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Weight</th>
                                            <th>Width</th>
                                            <th>Height</th>
                                            <th>Length</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if( old('dimension_type') )
                                        @foreach( old('dimension_type') as $key => $t )
                                        <tr>
                                            <td>
                                                <select class="form-control" name="dimension_type[]">
                                                    <option {{ $t == 'cm' ? 'selected' : '' }} value="cm">CM</option>
                                                    <option {{ $t == 'inch' ? 'selected' : '' }} value="inch">Inch</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" value="{{ isset(old('weight')[$key]) ? old('weight')[$key] : '' }}" name="weight[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" value="{{ isset(old('width')[$key]) ? old('width')[$key] : '' }}" name="width[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" value="{{ isset(old('height')[$key]) ? old('height')[$key] : '' }}" name="height[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" value="{{ isset(old('length')[$key]) ? old('length')[$key] : '' }}" name="length[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" min="1" value="{{ isset(old('dimension_price')[$key]) ? old('dimension_price')[$key] : '' }}" name="dimension_price[]" class="form-control">
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                <select class="form-control" name="dimension_type[]">
                                                    <option value="cm">CM</option>
                                                    <option value="inch">Inch</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" value="" name="weight[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" value="" name="width[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" value="" name="height[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" value="" name="length[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" value=""  min="1" name="dimension_price[]" class="form-control">
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <button class="btn btn-primary add-more-dimension">Add More</button>
                            </div>

                            <div class="row mt-4">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Custom Fields</label>
                                    </div>

                                    @if( $errors->has('custom_size.*') )
                                        <p class="text-warning">{{ $errors->first('custom_size.*') }}</p>
                                    @endif

                                    @if( $errors->has('custom_size_price.*') )
                                        <p class="text-warning">{{ $errors->first('custom_size_price.*') }}</p>
                                    @endif

                                    @if( old('custom_size') )

                                        @foreach( old('custom_size') as $key => $s )

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Name" name="label" value="{{ old('label') }}" class="form-control">
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Size" value="{{ $s }}" name="custom_size[]" class="mb-1 form-control">
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Price" value="{{ isset(old('custom_size_price')[$key]) ? old('custom_size_price')[$key] : '' }}" name="custom_size_price[]" class="mb-1 form-control">
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <input type="text" name="label" placeholder="Name" value="" class="form-control">
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Size" name="custom_size[]" class="mb-1 form-control">
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Price" min="1" name="custom_size_price[]" class="mb-1 form-control">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <button class="btn btn-primary add-more-size-field">Add More</button>
                                </div>
                            </div>
                        </div>

                        <div class="bhoechie-tab-content" id="">
                            <div class="form-group">
                                <label>Gallery image (Select mustiple images using ctrl key, you can select upto 6 pics, each file size must be less than 1MB)</label>
                                <input type="file" name="files[]" class="" multiple>
                                @if( $errors->has('files') )
                                    <span class="text-warning">{{ $errors->first('files') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Video Link</label>
                                <input type="text" name="video" value="{{ old('video') }}" class="form-control">
                                @if( $errors->has('video') )
                                    <span class="text-warning">{{ $errors->first('video') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="bhoechie-tab-content" id="">
                            <div class="form-group">
                                <label>Buy Also product</label>
                                <?php $products = App\model\Product::where(['user_id' => Auth::id(), 'status' => 'active'])->orderby('id', 'DESC')->get(); ?>
                                <select name="buy_also" data-placeholder="Select Product" id="" class="form-control multi-selector">
                                    <option value=""></option>
                                    @if( $products && count( $products ) > 0 )
                                        @foreach( $products as $p )
                                            <option {{ old('buy_also') == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if( $errors->has('files') )
                                    <span class="text-warning">{{ $errors->first('files') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="bhoechie-tab-content {{ $errors->has('payment_option.*') ? 'active' : '' }}" id="">
                            <?php $payment_option = [];
                                if( old('payment_option') )
                                    $payment_option = old('payment_option');
                            ?>
                            <div class="form-group">
                                <div class="simple-checkbox" style="display:inline-block;padding-right:20px;">
                                    <input type="checkbox" {{ in_array('cod', $payment_option) ? 'checked' : '' }} name="payment_option[]" value="cod" id="cod">
                                    <label style="display:inline-block;padding:0" class="checkbox" for="cod">COD</label>
                                </div>
                                <div class="simple-checkbox" style="display:inline-block;padding-right:20px;">
                                    <input type="checkbox" {{ in_array('ccavenue', $payment_option) ? 'checked' : '' }} id="ccavenue" name="payment_option[]" value="ccavenue">
                                    <label style="display:inline-block;padding:0" class="checkbox" for="ccavenue">CCAvenue</label>
                                </div>
                                <div class="simple-checkbox" style="display: inline-block;">
                                    <input type="checkbox" {{ in_array('wallet', $payment_option) ? 'checked' : '' }} id="wallet" name="payment_option[]" value="wallet">
                                    <label style="display:inline-block;padding:0" class="checkbox" for="wallet">Wallet</label>
                                </div>
                            </div>
                            @if( $errors->has('payment_option.*') )
                                <span class="text-warning">{{ $errors->get('payment_option.*') }}</span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            {{ Form::close() }}

        </div>

    </div>

@endsection