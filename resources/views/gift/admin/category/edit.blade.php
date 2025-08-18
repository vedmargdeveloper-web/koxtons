@extends(admin_app())

<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css" />
@section('content')

    <style type="text/css">
        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
            box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
        }

        .panel-default {
            border-color: #ddd;
        }

        .panel-default>.panel-heading {
            color: #333;
            background-color: #f5f5f5;
            border-color: #ddd;
        }

        .panel-heading {
            padding: 10px 15px;
            border-bottom: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }

        .panel-title {
            margin-top: 0;
            margin-bottom: 0;
            font-size: 16px;
            color: inherit;
        }

        .box-container {
            height: 200px;
            overflow-y: scroll;
        }

        .panel-body {
            padding: 15px;
        }

        .box-item {
            width: 100%;
            z-index: 1000;
        }

        .btn-default {
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .box-container .drag-drop-btn {
            color: #333;
            background-color: #fff;
            border-color: #ccc;
            text-align: left;
            font-size: 12px;
            margin-bottom: 5px;
        }
    </style>

    <div class="card">
        <div class="card-header">
            <h4>{{ isset($title) ? $title : '' }}</h4>
            <a href="{{ route('category.index') }}"><i class="material-icons">arrow_back_ios</i></a>
            <a class="ml-3" href="{{ route('category.create') }}">
                <i class="material-icons">add_box</i></a>
        </div>
        <div class="card-block pt-4">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 62px;">
                @if ($category)

                    {{ Form::open(['url' => route('category.update', $category->id), 'files' => true]) }}

                    {{ method_field('PATCH') }}

                    <div class="form-horizontal">
                        <div class="col-lg-6 col-md-6 float-left">
                            @if (Session::has('cat_err'))
                                <span class="label-warning">{{ Session::get('cat_err') }}</span>
                            @endif

                            @if (Session::has('cat_msg'))
                                <span class="label-success">{{ Session::get('cat_msg') }}</span>
                            @endif


                            <div class="form-group">
                                <label>Category name</label>
                                <input type="text" value="{{ old('name') ? old('name') : $category->name }}"
                                    name="name" class="form-control" placeholder="">
                                @if ($errors->has('name'))
                                    <span class="label-warning">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" value="{{ old('slug') ? old('slug') : $category->slug }}"
                                    name="slug" class="form-control" placeholder="">
                                @if ($errors->has('slug'))
                                    <span class="label-warning">{{ $errors->first('slug') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Parent</label>

                                <?php $parent = '';
                                if (old('parent')) {
                                    $parent = old('parent');
                                } elseif ($category->parent) {
                                    $parent = $category->parent;
                                }
                                ?>

                                @if ($parent)
                                    <?php $c = $parent; ?>
                                    <script type="text/javascript">
                                        $(document).ready(function(e) {
                                            v = "<?php echo $c; ?>";
                                            $('.chosen').val(v).trigger('chosen:updated');
                                        })
                                    </script>
                                @endif

                                <select class="form-control chosen" name="parent" data-placeholder="Select">
                                    <option value=""></option>
                                    <?php $categories = App\model\Category::all(); ?>
                                    @if ($categories)
                                        @foreach ($categories as $row)
                                            @if (!$row->parent)
                                                <option class="optionParent" value="{{ $row->id }}">
                                                    {{ ucfirst($row->name) }}</option>
                                                @foreach ($categories as $child)
                                                    @if ($row->id == $child->parent)
                                                        <option class="optionChild" value="{{ $child->id }}">
                                                            {{ ucfirst($child->name) }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                </select>

                                @if ($errors->has('parent'))
                                    <span class="label-warning">{{ $errors->first('parent') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control tinyeditor" name="description" rows="5" placeholder="">{{ old('description') ? old('description') : $category->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="label-warning">{{ $errors->first('description') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Meta Title</label>
                                <textarea rows="8" placeholder="Meta Title" name="metatitle" class="form-control">{{ old('metatitle') ? old('metatitle') : $category->metatitle }}</textarea>
                                @if ($errors->has('metatitle'))
                                    <span class="label-warning">{{ $errors->first('metatitle') }}</span>
                                @endif
                            </div>


                            <div class="form-group">
                                <label>Meta Key</label>
                                <textarea rows="8" placeholder="Meta Keys" name="metakey" class="form-control">{{ old('metakey') ? old('metakey') : $category->metakey }}</textarea>
                                @if ($errors->has('metakey'))
                                    <span class="label-warning">{{ $errors->first('metakey') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Meta Description</label>
                                <textarea rows="8" placeholder="Meta Description" name="metadescription" class="form-control">{{ old('metadescription') ? old('metadescription') : $category->metadescription }}</textarea>
                                @if ($errors->has('metadescription'))
                                    <span class="label-warning">{{ $errors->first('metadescription') }}</span>
                                @endif
                            </div>


                        </div>

                        <div class="col-lg-6 col-md-6 float-left">

                            <div class="form-group mb-4">
                                <button class="btn btn-primary mr-4" name="save" value="active">Update</button>
                                <button class="btn btn-primary" name="draft" value="inactive">Draft</button>
                            </div>

                            <div class="form-group">
                                <label>Feature image</label>
                                <input type="file" name="image" class="form-control">

                                @if ($category->feature_image)
                                    <div class="figure-img mt-3">
                                        <input type="hidden" name="filename" value="{{ $category->feature_image }}">
                                        <img class="img-thumbnail"
                                            src="{{ asset('public/' . public_file(thumb($category->feature_image, config('filesize.thumbnail.0'), config('filesize.thumbnail.1')))) }}">
                                        <a role="button" id="img-remove"><span class="material-icons">clear</span></a>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Select Order</label>
                                <select class="form-control" name="order_by" data-placeholder="Select">
                                    <option value="latest" <?php if ($category->order_by == 'latest') {
                                        echo 'selected';
                                    } ?>>Latest</option>
                                    <option value="low_to_high" <?php if ($category->order_by == 'low_to_high') {
                                        echo 'selected';
                                    } ?>>Low to High</option>
                                    <option value="high_to_low" <?php if ($category->order_by == 'high_to_low') {
                                        echo 'selected';
                                    } ?>>High to Low</option>
                                </select>
                            </div>


                            <?php $flag = 0;
                            $product_ids = App\model\CategoryProduct::select('product_id')
                                ->where('category_id', $category->id)
                                ->get()
                                ->toArray(); ?>
                            <?php $products = App\model\Product::where(['status' => 'active'])
                                ->where('discount', '=', null)
                                ->where('available', '>', 0)
                                ->whereIn('id', $product_ids)
                                ->get();
                            
                            // dd($product_ids);
                            
                            ?>

                        </div>

                        <textarea name="postmeta" style="display: none">{{ old('postmeta') ? old('postmeta') : $category->postmeta }}</textarea>
                        {{-- complaint check for  --}}



                        <div class="col-lg-121">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h1 class="panel-title">Mobile Product List</h1>
                                        </div>
                                        <div id="container1" class="panel-body box-container">
                                            @if ($products)
                                                {{-- {{ dd($products) }} --}}
                                                @foreach ($products as $row => $key)
                                                    <div itemid="{{ $key->id }}" value="{{ $key->id }}"
                                                        class="btn btn-default drag-drop-btn box-item">{{ $key->title }}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h1 class="panel-title">Set Mobile Product Priority</h1>
                                        </div>
                                        <?php
                                        
                                        $store_mobile_products = explode(',', $category->product_priority_mobile);
                                        $store_mobile_products = $store_mobile_products ?? '';
                                        
                                        ?>

                                        <?php $new_mobile_products = App\model\Product::whereIn('id', $store_mobile_products)->get();
                                        // var_dump($new_mobile_products);
                                        ?>

                                        <div id="container2" class="panel-body box-container">
                                            @if ($store_mobile_products)
                                                @foreach ($store_mobile_products as $id)
                                                    <?php $key = $new_mobile_products->where('id', $id)->first(); ?>
                                                    <?php if($key): ?>
                                                    <div itemid1="{{ $key->id }}" value="{{ $key->id }}"
                                                        class="btn btn-default drag-drop-btn box-item">{{ $key->title }}
                                                    </div>
                                                    <?php endif;?>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" class="form-control input-mobile-products_id"
                                        name="mobile_products_id">
                                    <input type="button" name="Done" class="btn btn-primary btn-done-order-mobile"
                                        value="Click Here">
                                </div>
                            </div>
                        </div>

                        <br />
                        <br />

                        <div class="col-lg-121">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h1 class="panel-title">Desktop Product List</h1>
                                        </div>
                                        <div id="container11" class="panel-body box-container">
                                            @if ($products)
                                                @foreach ($products as $row => $key)
                                                    <div itemid1="{{ $key->id }}" value="{{ $key->id }}"
                                                        class="btn btn-default drag-drop-btn box-item">{{ $key->title }}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h1 class="panel-title">Set Desktop Product Priority</h1>
                                        </div>
                                        <?php $store_desktop_products = explode(',', $category->product_priority_desktop); ?>
                                        <?php $store_desktop_products = $store_desktop_products ?? ''; ?>
                                        <?php $new_desktop_products = App\model\Product::whereIn('id', $store_desktop_products)->get(); ?>
                                        <div id="container22" class="panel-body box-container">
                                            @if ($store_desktop_products)
                                                @foreach ($store_desktop_products as $id)
                                                    <?php $key = $new_desktop_products->where('id', $id)->first(); ?>
                                                    <?php if($key): ?>
                                                    <div itemid1="{{ $key->id }}" value="{{ $key->id }}"
                                                        class="btn btn-default drag-drop-btn box-item">{{ $key->title }}
                                                    </div>
                                                    <?php endif; ?>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" class="form-control input-desktop-products_id"
                                        name="desktop_products_id">
                                    <input type="button" name="Done" class="btn btn-primary btn-done-order-desktop"
                                        value="Click here">
                                </div>
                            </div>
                        </div>


                    </div>



                    {{ Form::close() }}
                @else
                    <h3>404! Category not found</h3>

                @endif

            </div>
        </div>
    </div>


@endsection
