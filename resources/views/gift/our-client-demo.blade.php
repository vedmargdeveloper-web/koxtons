<?php $client = App\model\OurClient::all(); ?>

            <div class="box all-products client-section mt-50 section-bg-light-grey">
                <div class="container ">
                    <div class="mblog section mt-50">
                        <div class="box-content special">
                            <div class="page-title toggled">
                                <h3><span>Our Client</span></h3>
                            </div>
                            <div class="row">
                                <div id="blogcarousel" class="blogs-block blog-carousel clearfix" data-items="5">

                                    @if($client)
                                        @foreach($client as $key)
                                            <div class="product-layout pd-5 col-xs-12">
                                                <div class="item">
                                                    <div class="product-block blog-block transition">
                                                        <div class="blog-info">
                                                            <div class="image">
                                                                <div class="swiper-slide text-center Main-banner1">
                                                                    <img src="{{ asset( 'public/' . public_file( $key->image ) ) }}"  alt="{{ $key->image_alt ?? 'Client Logo' }}" class="img-responsive" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    <!--
                    // set slider
                    $(document).ready(function() {
                        setBlogCarousel();
                    });
                    function setBlogCarousel() {
                        const direc = $('html').attr('dir');

                        $('.blog-carousel').each(function () {
                            if ($(this).closest('#column-left').length == 0 && $(this).closest('#column-right').length == 0) {
                                $(this).addClass('owl-carousel owl-theme');
                                    const items = $(this).data('items') || 3;
                                    const sliderOptions = {
                                        loop: false,
                                        nav: true,
                                        autoplay: true,
                                        navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                                        dots: false,
                                        items: items,
                                        responsiveRefreshRate: 200,
                                        responsive: {
                                        0: { items: 2 },
                                        681: { items: 2 },
                                        992: { items: items }
                                    }
                                };
                                if (direc == 'rtl') sliderOptions['rtl'] = true;
                                $(this).owlCarousel(sliderOptions);
                            }
                        });
                    }

                    //-->
                </script>
            </div>