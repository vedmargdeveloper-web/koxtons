@extends( _app() )
@section('og-title', 'Koxtonsmart: Your Wishlist')

@section('content')

<!-- Page Content Wraper -->
<div class="page-content-wraper">
    <!-- Bread Crumb -->
    <section class="">
        <div class="container">
                <div class="row">
                    <div class="col-12 mt-10">
                      <nav class="breadcrumb-link" style="margin-left:15px; display: flex; align-items: center; flex-wrap: wrap; color: #555; font-size: 14px;">
                            <a href="{{ url('/') }}" style="color: #007bff; text-decoration: none;">Home</a>
                            <span style="margin: 0 5px;">&raquo;</span>
                            <span>Wishlist</span>
                        </nav>
                    </div>
                </div>
        </div>
    </section>
    <!-- Bread Crumb -->

    <!-- Page Content -->
    <section class="content-page">
        <div class="container">
                <div class="row">
                	<div class="col-sm-12">
                        <article class="post-8">


                            <?php $wishlist = Cookie::get('wishlistProduct'); $count = 0; ?>
                            @if( $wishlist )
                                <?php $wishlist = json_decode($wishlist); ?>

                                @if( $wishlist )

                                <div class="text-center">
                                    <h4 class="wish-list-item-title">Items in Your Wishlist</h4>
                                </div>

                                <div class="cart-product-table-wrap responsive-table">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-remove"></th>
                                                <th class="product-thumbnail"></th>
                                                <th class="product-name">Product</th>
                                                <th class="product-price">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        @foreach( $wishlist as $product_id )

                                        <?php $product = App\model\Product::where('product_id', $product_id)->first(); ?>

                                        @if( $product )

                                        <tr>
                                            <td class="product-remove">
                                                <a class="product-remove" data-id="{{ $product->id }}" data-value="{{ $product->product_id }}" href="javascript:void(0)">
                                                    {!! Form::button( '<i class="fa fa-trash fa-lg"></i>', ['type' => 'submit', 'class' => 'delete deleteProduct','id' => 'btnDeleteWishlistItem', 'data-value' => $product->product_id, 'data-id' => $product->id ] ) !!}
                                                </a>
                                            </td>
                                            <td class="product-thumbnail">
                                                <?php $cat = App\model\Category::where('id', $product->category_id)->value('slug'); ?>
                                                <a href="{{ route('product.view', [$cat, $product->slug, $product->product_id]) }}">
                                                    <img src="{{ asset( 'public/'. product_file( thumb( $product->feature_image, config('filesize.thumbnail.0'), config('filesize.thumbnail.1') ) ) ) }}" alt="{{ $product->title }}" />
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <a href="{{ route('product.view', [$cat, $product->slug, $product->product_id]) }}">{{ $product->title }}</a>
                                            </td>
                                            <td class="product-price">
                                                <?php $price = $product->price; ?>
                                                @if( $product->tax )
                                                    <?php $price = $price + ( $price * $product->tax / 100 ); ?>
                                                @endif
                                                @if( $product->discount )
                                                    <del><span class="fa fa-inr"></span> {{ $product->price }}</del>
                                                    <?php $price = $product->price - ( $product->price * $product->discount ) / 100; ?>
                                                @endif
                                                <span class="product-price-amount amount"><span class="currency-sign"><i class="fa fa-inr"></i></span> {{ round($price) }}</span>
                                                <input type="hidden" name="product_id[]" value="{{ $product->product_id }}">
                                                <input type="hidden" name="id[]" value="{{ $product->id }}">
                                            </td>
                                        </tr>

                                        @endif

                                        @endforeach 

                                        </tbody>
                                    </table>
                                </div>

                                @else

                                <div class="text-center">
                                    <h4 class="wish-list-item-title">0 Item in Your Wishlist</h4>
                                </div>

                                @endif
                            @else

                            <div class="text-center">
                                <h4 class="wish-list-item-title">0 Item in Your Wishlist</h4>
                            </div>

                            @endif

                        </article>

                    </div>

                </div>
        </div>
    </section>

</div>


@endsection