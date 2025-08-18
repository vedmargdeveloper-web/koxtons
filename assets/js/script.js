$(document).ready(function() {
    var scale = 3;
    var base_url = $('base').attr('href');
    var _token = $('meta[name="_token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': _token
        }
    });

    $(".subs-overlay").delay(10000).fadeIn();

    $('body').on('click', '.close-popup', function(event) {
        event.preventDefault();
        $(".subs-overlay").fadeOut();
    });

    $(document).ajaxStart(function() {});
    $(document).ajaxComplete(function(event, xhr, settings) {});
    $('.zoom-img').on('mouseover', function() {
        $(this).children('.photo').css({
            'transform': 'scale(' + scale + ')'
        })
    }).on('mouseout', function() {
        $(this).children('.photo').css({
            'transform': 'scale(1)'
        })
    }).on('mousemove', function(e) {
        $(this).children('.photo').css({
            'transform-origin': ((e.pageX - $(this).offset().left) / $(this).width()) * 100 + '% ' + ((e.pageY - $(this).offset().top) / $(this).height()) * 100 + '%'
        })
    }).each(function() {
        $(this).append('<div class="photo"></div>').children('.photo').css({
            'background-image': 'url(' + $(this).attr('data-image') + ')'
        })
    });
    $('body').on('change', 'select#product-short-by', function(event) {
        event.preventDefault();
        $('option:selected', this).val();
        $('form#sorting-form')[0].submit()
    });
    $('body').on('click', 'a#addToWishlist', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        $('.loader').css('display', 'block');
        var $this = $(this);
        var id = $this.attr('data-id');
        var product_id = $this.attr('data-value');
        if (!id || !product_id)
            return !1;
        $.ajax({
            url: base_url + '/add/wishlist',
            type: 'POST',
            data: {
                id: id,
                product_id: product_id
            },
            cache: !1,
            success: function(data) {
                if ($this.children('.fa').hasClass('fa-heart-o')) {
                    $this.children('.fa').removeClass('fa-heart-o');
                    $this.children('.fa').addClass('fa-heart');
                    $('#countTip').text(parseInt($('#countTip').text()) + 1)
                } else if ($this.children('.fa').hasClass('fa-heart')) {
                    $this.children('.fa').removeClass('fa-heart');
                    $this.children('.fa').addClass('fa-heart-o');
                    $('#countTip').text(parseInt($('#countTip').text()) - 1)
                }
                $('.loader').css('display', 'none')
            },
            error: function(xhr, ajaxOpt, thrownError) {
                $('.loader').css('display', 'none')
            }
        })
    });
    $('body').on('click', 'button#btnDeleteWishlistItem', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        $('.loader').css('display', 'block');
        var $this = $(this);
        var id = $this.attr('data-id');
        var product_id = $this.attr('data-value');
        if (!id || !product_id)
            return !1;
        $.ajax({
            url: base_url + '/add/wishlist',
            type: 'POST',
            data: {
                id: id,
                product_id: product_id
            },
            cache: !1,
        }).done(function(data) {
            $('#countTip').text(parseInt($('#countTip').text()) - 1);
            $this.parent('a').parent('td').parent('tr').remove()
        }).fail(function() {}).always(function() {;
            $('.loader').css('display', 'none')
        })
    });
    var carTotalAmount = $('span#cartTotalPrice');
    var cartProductItemList = $('ul#cartProductItemList');
    var cartCounter = $('span#cartCounter');

    $('body').on('submit', '.product-add-to-cart-form', function(event) {
        event.preventDefault();
        /* Act on the event */
        $('.loader').css('display', 'block');
        var form = $(this).serialize();
        $('._error', this).remove();

        var color = $('.filters-color .color-selector .color.active').attr('data-value');
        var size = $('.filters-size .size-attribute-selector.size.active').attr('data-value');

        if( color !== '' && color !== undefined )
            form = form+'&color='+color;
        if( size !== '' && size !== undefined )
            form = form+'&size='+size;
        
        var $this = $(this);
        var id = $this.attr('data-id');
        var product_id = $this.attr('data-product');
        
        if (!id || !product_id)
            return !1;

        form = form+'&id='+id+'&product_id='+product_id;

        carTotalAmount.text(0);
        $.ajax({
            url: base_url + '/cart/store',
            type: 'POST',
            data: form
        }).done(function(data) {
            if( data.response !== true ) {
                if( data.quantity === false ) {
                    $('<span class="_error text-warning">'+data.message+'</span>').insertAfter( $('#addToCartProduct').parent('.single-variation-wrap') );
                }
            }
            getCartProduct()
            $('.loader').css('display', 'none');
        }).fail(function(error) {
            
            $('.loader').css('display', 'none')
        }).always(function() {})

    });
    $('body').on('click', 'a#addToCartProduct', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        $('.loader').css('display', 'block');

        var $this = $(this);
        var id = $this.attr('data-id');
        var product_id = $this.attr('data-value');
        var quantity = $('input#itemQuantity').val();
        if (!id || !product_id)
            return !1;
        carTotalAmount.text(0);
        $.ajax({
            url: base_url + '/cart/store',
            type: 'POST',
            data: {
                id: id,
                product_id: product_id,
                quantity: quantity
            },
        }).done(function(data) {
            getCartProduct()
        }).fail(function(error) {
            $('.loader').css('display', 'none')
        }).always(function() {})
    });
    var getCartProduct = function() {
        $.ajax({
            url: base_url + '/cart/get',
            type: 'POST'
        }).done(function(data) {
            udpateCartSidebar(JSON.parse(data));
            $('#sidebar-right').addClass('sidebar-open');
            $('.sidebar_overlay').addClass('sidebar_overlay_active')
        }).fail(function(error) {
            $('.loader').css('display', 'none')
        }).always(function() {})
    }
    var udpateCartSidebar = function(data) {
        if( !data || data.length < 1 ) {
            location.reload();
        }
        totalAmount = 0;
        count = 0;
        cartProductItemList.children('li').remove();
        $.each(data, function(index, val) {
            
            price = this.price;
            if (this.discount) {
                price = this.price - (this.price * this.discount) / 100
            }
            price = Math.round(price);
            count++;
            $html = '<li>'
            $html += '<a href="' + this.url + '" class="product-image">'
            $html += '<img src="' + this.feature_image + '" alt="' + this.title + '" />'
            $html += '</a>'
            $html += '<div class="product-content">'
            $html += '<a class="product-link" href="' + this.url + '">' + this.title + '</a>'
            $html += '<div class="cart-collateral">'
            $html += '<span class="qty-cart">' + this.quantity + '</span>&nbsp;<span>&#215;</span>&nbsp;'
            $html += '<span class="product-price-amount"><span class="currency-sign"><i class="fa fa-inr"></i>'
            $html += '</span>' + price + '</span>';
            $html += '</div>'
            $html += '<a class="product-remove"   data-id="' + this.id + '" data-value="' + this.product_id + '" href="javascript:void(0)">'
            $html += '<form method="POST" action="' + base_url + '/cart/' + this.product_id + '" accept-charset="UTF-8" id="removeItemFromCart">'
            $html += '<input name="_method" value="DELETE" type="hidden">'
            $html += '<input name="_token" value="' + _token + '" type="hidden">'
            $html += '<button type="submit" data-key="'+this.key+'" data-value="' + this.product_id + '" class="delete text-danger deleteProduct" id="btnRemoveCartItem" data-id="' + this.id + '">'
            $html += '<i class="fa fa-trash fa-lg"></i></button>'
            $html += '</form></a>'
            $html += '</div>'
            $html += '</li>';
            totalAmount += this.quantity * price;
            $($html).appendTo(cartProductItemList)
        });
        carTotalAmount.text(0);
        cartCounter.text(0);
        cartCounter.text(count);
        carTotalAmount.text(totalAmount);
        updateCartTable(data);
        $('.loader').css('display', 'none')
    }
    $('body').on('submit', 'form#removeItemFromCart', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        $('.loader').css('display', 'block');
        var $this = $(this);
        
        var product_id = $('button', $this).attr('data-value');
        var id = $('button', $this).attr('data-id');
        var key = $('button', $this).attr('data-key');
        
        if (!product_id)
            return !1;

        var form = 'id='+id+'&product_id='+product_id+'&key='+key;
        removeCart($this, form, product_id)
    });
    var removeCart = function($this, form = '', product_id) {
        if (!form)
            return !1;
        $.ajax({
            url: base_url + '/cart/remove/product',
            type: 'POST',
            data: form,
            cache: !1,
            success: function(data) {
                getCartProduct();
                $this.parent('a').parent('div').parent('li').remove()
            },
            error: function(xhr, ajaxOpt, thrownError) {
                $('.loader').css('display', 'none')
            }
        })
    }
    $('body').on('click', 'button#btnDeleteCartItem', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        $('.loader').css('display', 'block');
        var $this = $(this);
        
        
        var product_id = $this.attr('data-value');
        var id = $this.attr('data-id');
        var key = $this.attr('data-key');
        if (!product_id || !key)
            return !1;
        form = 'id=' + id + '&product_id=' + product_id+'&key='+key;

        removeCart($this, form, product_id);
        $this.parent('a').parent('td').parent('tr').remove()
    });
    $('body').on('submit', 'form#cartForm', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        $('.loader').css('display', 'block');
        var $this = $(this);
        $('input[name="_method"]', $this).val('PATCH');
        $this.attr('method', 'POST');
        var form = $this.serialize();
        if (!form) {
            return !1
        }
        updateCart(form)
    });
    var updateCart = function(form) {
        $.ajax({
            url: base_url + '/cart/update',
            type: 'POST',
            cache: !1,
            data: form,
        }).done(function(data) {
            getCartProduct()
        }).fail(function(xhr) {}).always(function() {;
            $('.loader').css('display', 'none')
        })
    }
    var cartSubTotal = $('span#cartSubTotal');
    var cartTotalAmount = $('span#cartTotalAmount');
    var updateCartTable = function(data) {
        console.log(data);
        cartSubTotalAmount = 0;
        $.each(data, function(index, val) {
            amount = this.price;
            if (this.discount)
                amount = this.price - (this.price * this.discount) / 100;
            amount = Math.round(amount);
            amount = this.quantity * amount;
            cartSubTotalAmount += amount;
            $('span#cartProductAmount-' + this.product_id).children('span#cartProductTotalAmount').text(0);
            $('span#cartProductAmount-' + this.product_id).children('span#cartProductTotalAmount').text(amount)
        });
        var shipping_charge = parseInt($('input#shippingCharge').val());
        cartSubTotal.text(0);
        cartSubTotal.text(cartSubTotalAmount);
        cartTotalAmount.text(0);
        cartTotalAmount.text(cartSubTotalAmount + shipping_charge)
    }
    $('body').on('submit', 'form#checkAvailability', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        $('.loader').css('display', 'block');
        var $this = $(this);
        $('.input-group', $this).siblings('span.error').remove();
        var form = $this.serialize();
        var url = $this.attr('action');
        $.ajax({
            url: url,
            type: 'POST',
            data: form,
        }).done(function(result) {
            if (result.error) {
                $('<span class="error lavel-warning">' + result.error + '</span>').insertAfter($('.input-group', $this))
            }
            if (result.msg) {
                $('<span class="error lavel-success">' + result.msg + '</span>').insertAfter($('.input-group', $this))
            }
            $('.loader').css('display', 'none')
        }).fail(function(error) {
            $('.loader').css('display', 'none')
        }).always(function() {})
    });
    var country = $('select#tdcountry');
    var state = $('select#tdstate');
    var state_id = $('option:selected', state).val();
    var city = $('select#tdcity');
    var get_state = function(country_id) {
        $.ajax({
            url: base_url + '/get/state/' + country_id,
            type: 'GET'
        }).done(function(result) {
            html = '<option value="">Select</option>';
            if (result.states) {
                $.each(result.states, function(index, val) {
                    if (state_id == this.id) {
                        html += '<option selected value="' + this.id + '">' + this.name + '</option>'
                    } else html += '<option value="' + this.id + '">' + this.name + '</option>'
                });
                state.children('option').remove();
                $(html).appendTo(state)
            }
            $('.loader').css('display', 'none')
        }).fail(function(error) {
            $('.loader').css('display', 'none')
        }).always(function() {})
    }
    if (country_id = $('option:selected', country).val()) {
        get_state(country_id)
    }
    $('body').on('change', 'select#tdcountry', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        $('.loader').css('display', 'block');
        var country_id = $('option:selected', this).val();
        get_state(country_id)
    });
    $('body').on('change', 'select#tdstate', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        $('.loader').css('display', 'block');
        var state_id = $('option:selected', this).val();
        get_city(state_id)
    });
    var get_city = function(state_id) {
        $.ajax({
            url: base_url + '/get/city/' + state_id,
            type: 'GET'
        }).done(function(result) {
            html = '<option value="">Select</option>';
            if (result.cities) {
                $.each(result.cities, function(index, val) {
                    html += '<option value="' + this.id + '">' + this.name + '</option>'
                });
                city.children('option').remove();
                $(html).appendTo(city)
            }
            $('.loader').css('display', 'none')
        }).fail(function(error) {
            $('.loader').css('display', 'none')
        }).always(function() {})
    }
    $('body').on('click', 'a#tabReview', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        $('ul.product-content-tabs li a').removeClass('active');
        $('ul.product-content-tabs li a.review').addClass('active');
        var tabs = $('.product-content-Tabs_wraper').children('div');
        tabs.each(function(index, el) {
            $(this).removeClass('in');
            $(this).removeClass('active');
            $(this).removeClass('show')
        });
        $('#tab_reviews').addClass('in active show');
        $('html, body').animate({
            scrollTop: $("#otherDetails").offset().top
        }, 2000)
    });
    $('body').on('click', 'a#readMoreTab', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        $('ul.product-content-tabs li a').removeClass('active');
        $('ul.product-content-tabs li a.description').addClass('active');
        var tabs = $('.product-content-Tabs_wraper').children('div');
        tabs.each(function(index, el) {
            $(this).removeClass('in');
            $(this).removeClass('active');
            $(this).removeClass('show')
        });
        $('#tab_description').addClass('in active show');
        $('html, body').animate({
            scrollTop: $("#otherDetails").offset().top
        }, 2000)
    });
    var coupon_applied = !1;
    $('body').on('click', 'button#applyCoupon', function(event) {
        event.preventDefault();
        $('span.label-warning').remove();
        $('span.label-success').remove();
        var input_coupon = $('input#inputCoupon');
        if (coupon_applied) {
            $('<span class="label-success">Coupon already applied!</span>').insertAfter(input_coupon.parent('.input-group'));
            return !0
        }
        if (!input_coupon.val()) {
            $('<span class="label-warning">Enter coupon code *</span>').insertAfter(input_coupon.parent('.input-group'));
            return !1
        }
        var amount = parseInt($('input#totalCartAmount0').val());
        var code = input_coupon.val();
        $('.loader').css('display', 'block');
        $.ajax({
            url: base_url + '/validate/code',
            type: 'POST',
            data: {
                code: code,
                amount: amount
            },
        }).done(function(data) {
            if (data.valid === !0 && data.coupon) {
                coupon_applied = !0;
                coupon = data.coupon;
                if (coupon.discount_type === 'inr') {
                    amount = amount - coupon.discount
                }
                if (coupon.discount_type === 'percent') {
                    amount = amount - ((amount * coupon.discount) / 100)
                }
                $('#orderTotal').remove();
                amount = Math.round(amount);
                html = '<tr class="order-total">';
                html += '<th>Discount</th>';
                html += '<td>';
                html += '<span class="product-price-amount amount">';
                if (coupon.discount_type === 'percent')
                    html += coupon.discount + '%';
                else html += ' - <i class="fa fa-inr"></i> ' + coupon.discount + '</span>';
                html += '<input type="hidden" name="coupon_code" value="' + code + '">';
                html += '</td></tr>';
                html += '<tr class="order-total border-top-1">';
                html += '<th>Total</th>'
                html += '<td>'
                html += '<span id="checkoutTotalAmount" class="product-price-amount amount">';
                html += '<input type="hidden" id="totalCartAmount0" name="totalAmount" value="'+amount+'">';
                html += '<i class="fa fa-inr"></i> ' + amount + '</span>';
                html += '</td></tr>';
                $('<span class="label-success">' + data.code_msg + '</span>').insertAfter(input_coupon.parent('.input-group'));
                $(html).insertAfter('.product-checkout-review-order .shipping');
            } else {
                $('<span class="label-warning">' + data.code_err + '</span>').insertAfter(input_coupon.parent('.input-group'))
            }
        }).fail(function(error) {}).always(function() {;
            $('.loader').css('display', 'none')
        })
    });
    $('body').on('submit', 'form#contactForm1', function(event) {
        event.preventDefault();
        $('.loader').css('display', 'block');
        $('span.text-danger').remove();
        $('span.text-success').remove();
        $url = $(this).attr('action');
        var $this = $(this);
        var form = $(this).serialize();
        $.ajax({
            url: $url,
            type: 'POST',
            data: form,
        }).done(function(data) {
            if (data.name) {
                $('<span class="text-danger">' + data.name[0] + '</span>').insertAfter($('input[name="name"]', $this))
            }
            if (data.email) {
                $('<span class="text-danger">' + data.email[0] + '</span>').insertAfter($('input[name="email"]', $this))
            }
            if (data.subject) {
                $('<span class="text-danger">' + data.subject[0] + '</span>').insertAfter($('input[name="subject"]', $this))
            }
            if (data.message) {
                $('<span class="text-danger">' + data.message[0] + '</span>').insertAfter($('textarea[name="message"]', $this))
            }
            if (data.err) {
                $('<span class="text-danger mt-1">' + data.err + '</span>').insertAfter($this);
                return
            }
            if (data.msg) {
                $('<span class="text-success mt-1">' + data.msg + '</span>').insertAfter($this);
                $this[0].reset();
                return
            }
            return
        }).fail(function(error) {}).always(function() {
            $('.loader').css('display', 'none')
        })
    });
    $('body').on('submit', 'form#subscribeForm', function(event) {
        event.preventDefault();
        $('.loader').css('display', 'block');
        $('span.text-danger').remove();
        $('span.text-success').remove();
        $url = $(this).attr('action');
        var $this = $(this);
        var form = $(this).serialize();
        $.ajax({
            url: $url,
            type: 'POST',
            data: form,
        }).done(function(data) {
            if (data.email) {
                $('<span class="text-danger">' + data.email[0] + '</span>').insertAfter($('input[name="email"]', $this))
            }
            if (data.err) {
                $('<span class="text-danger mt-1">' + data.err + '</span>').insertAfter($this);
                return
            }
            if (data.msg) {
                $('<span class="text-success mt-1">' + data.msg + '</span>').insertAfter($this);
                $this[0].reset();
                return
            }
            return
        }).fail(function(error) {}).always(function() {
            $('.loader').css('display', 'none')
        })
    });
    $(window).on('click', '.selector', function(event) {
        event.preventDefault()
    });
    var scrollTo = !1;
    var page = 1;
    var noMore = !1;
    var product_id = !1;
    var scrollFunction = function() {
        var footer = parseInt($('footer').height() + $(window).height());
        var itemContainerHeight = parseInt($('.product-container').height());
        var height = parseInt(itemContainerHeight);
        var header = parseInt($('header').height());
        var totalHeight = itemContainerHeight - header;
        var ht = $('.header-topbar').height();
        console.log($(window).scrollTop() + ' ' + ht);
        $(window).scrollTop() < ht ? $('.header-main').removeClass('fixed') : $('.header-main').addClass('fixed');
        if ($(window).scrollTop() >= totalHeight) {
            if (noMore === !1) {
                $('.loader').css('display', 'block');
                if (checkVisible($('.loader'))) {
                    $(window).off('scroll');
                    getRows()
                }
            }
        }
    }
    $(window).scroll(scrollFunction);

    function checkVisible(elm, eval) {
        eval = eval || "object visible";
        var viewportHeight = $(window).height(),
            scrolltop = $(window).scrollTop(),
            y = $(elm).offset().top,
            elementHeight = $(elm).height();
        if (eval == "object visible") return ((y < (viewportHeight + scrolltop)) && (y > (scrolltop - elementHeight)));
        if (eval == "above") return ((y < (viewportHeight + scrolltop)))
    }
    var getRows = function() {
        var cat = $('.product-container').attr('data-id');
        if (!cat)
            return;
        var sortBy = $('option:selected', $('form#sorting-form select')).val();
        page++;
        $.ajax({
            url: base_url + '/load/data?sort_by=' + sortBy + '&slug=' + cat + '&page=' + page,
            type: 'GET'
        }).done(function(data) {
            $('.nomore').remove();
            if (data.products.length < 1) {
                noMore = !0;
                search_form($('#loadMoreRow'));
                $(window).scroll(scrollFunction)
                return
            }
            if (data.products.length > 0) {
                scrollBack();
                appendRows(data.products, $('#loadMoreRow'))
            }
        }).fail(function(error) {}).always(function() {
            $('.loader').css('display', 'none');
            if (noMore === !1) {
                $(window).scroll(scrollFunction)
            }
        })
    }
    var appendRows = function(products, place) {
        var c = 0;
        $.each(products, function(index, val) {
            if (c < 1 || c === 4) {
                html = '<div id="' + this.product_id + '" class="row product-list-item">';
                c = 0
            }
            html += '<div class="product-item-element col-lg-3 col-md-3 col-sm-6 col-6">';
            html += '<div class="product-item">';
            html += '<div class="product-item-inner">';
            html += '<div class="product-img-wrap">';
            html += '<a href="' + this.cat_url + '">';
            html += '<img src="' + this.img_url + '" alt="' + this.title + '">';
            if (this.discount && this.discount != 0 && this.discount != null) {
                html += '<div class="sale-label discount">'
                html += '<span>' + this.discount + '% off</span>';
                html += '</div>'
            }
            html += '</a>';
            html += '</div>';
            icon = this.in_wishlist ? 'fa-heart' : 'fa-heart-o';
            if (this.available > 0) {
                html += '<div class="product-button">';
                html += '<a role="button" class="js_tooltip" id="addToCartProduct" data-value="' + this.product_id + '" data-id="' + this.id + '" data-mode="top" data-tip="Add To Cart"><i class="fa fa-shopping-bag"></i></a>';
                html += '<a role="button" class="js_tooltip" id="addToWishlist" data-value="' + this.product_id + '" data-id="' + this.id + '" data-mode="top" data-tip="Add To Whishlist"><i class="fa ' + icon + '"></i></a>';
                html += '</div>'
            } else {
                html += '<div class="out-stock">';
                html += '<span>Out of stock</span>';
                html += '</div>'
            }
            html += '</div>';
            html += '<div class="product-detail">';
            html += '<a class="tag" href="#"></a>';
            html += '<p class="product-title">';
            html += '<a href="' + this.cat_url + '">' + this.title + '</a></p>';
            html += '<p class="product-description"></p>';
            html += '<h5 class="item-price">';
            if (this.discount) {
                html += '<del><sub><span class="fa fa-inr"></span>' + this.price + '</sub></del>';
                html += '<span class="fa fa-inr"></span>' + this.newPrice
            } else {
                html += '<span class="fa fa-inr"></span>' + this.newPrice
            }
            html += '</h5>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            if (c === 3) {
                html += '</div>';
                $(html).insertBefore(place)
            }
            c++
        });
        if (c <= 3) {
            html += '</div>';
            $(html).insertBefore(place)
        }
    }
    $('body').on('click', 'button#loadMoreBtnHome', function(event) {
        $('.nomore').remove();
        $('.loader').css('display', 'block');
        var $this = $(this);
        page = parseInt($this.attr('data-id')) + 1;
        event.preventDefault();
        $.ajax({
            url: base_url + '/load/more?page=' + page,
            type: 'GET'
        }).done(function(data) {
            if (data.products.length < 1) {
                search_form($('#all-product-container'));
                return
            }
            if (data.products.length > 0) {
                $this.attr('data-id', page);
                appendRows(data.products, $this.parent('div').parent('div'))
            }
        }).fail(function(error) {}).always(function() {
            $('.loader').css('display', 'none')
        })
    });
    var search_form = function(place) {
        html = '<div class="row nomore product-list-item mb-5"><div class="col-sm-12 text-center">';
        html += '<form class="not-found-search-form" action="' + base_url + '">';
        html += '<label>Something that you have not found, search here...</label>';
        html += '<div class="input-group">';
        html += '<input name="s" placeholder="Search here..." class="form-control" type="text">';
        html += '<div class="input-group-append">';
        html += '<button type="submit" class="btn btn-primary">';
        html += '<span class="fa fa-search"></span>';
        html += '</button>';
        html += '</div>';
        html += '</div></form>';
        html += '</div></div>';
        $(html).appendTo(place);
        return
    }
    var scrollBack = function() {
        $('html, body').animate({
            scrollTop: $("#loadMoreRow").offset().top
        }, 1000)
    }
    var owl = $('.owl-carousel.main-carousel');
    owl.owlCarousel({
        loop: !0,
        margin: 0,
        navSpeed: 1500,
        nav: !0,
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        autoplay: !0,
        rewind: !0,
        dots: !1,
        items: 1
    });

    function setAnimation(_elem, _InOut) {
        var animationEndEvent = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        _elem.each(function() {
            var $elem = $(this);
            var $animationType = 'animated ' + $elem.data('animation-' + _InOut);
            $elem.addClass($animationType).one(animationEndEvent, function() {
                $elem.removeClass($animationType)
            })
        })
    }
    owl.on('change.owl.carousel', function(event) {
        var $currentItem = $('.owl-item', owl).eq(event.item.index);
        var $elemsToanim = $currentItem.find("[data-animation-out]");
        setAnimation($elemsToanim, 'out')
    });
    var round = 0;
    owl.on('changed.owl.carousel', function(event) {
        var $currentItem = $('.owl-item', owl).eq(event.item.index);
        var $elemsToanim = $currentItem.find("[data-animation-in]");
        setAnimation($elemsToanim, 'in')
    })
    owl.on('translated.owl.carousel', function(event) {
        if (event.item.index == (event.page.count - 1)) {
            if (round < 1) {
                round++;
            } else {
                owl.trigger('stop.owl.autoplay');
                var owlData = owl.data('owl.carousel');
                owlData.settings.autoplay = !1;
                owlData.options.autoplay = !1;
                owl.trigger('refresh.owl.carousel')
            }
        }
    });
    $("#img_01").elevateZoom({
        gallery: 'gal1',
        cursor: 'pointer',
        galleryActiveClass: 'active',
        imageCrossfade: !0,
        loadingIcon: base_url + '/assets/img/pre-loader.gif'
    });
    $("#img_01").bind("click", function(e) {
        var ez = $('#img_01').data('elevateZoom');
        $.fancybox(ez.getGalleryList());
        return !1
    })

    $('body').on('change', '.payment_method_cod', function(event) {
        event.preventDefault();
        $('.loader').css('display', 'block');
        var val = $(this).val();
        var charge = parseInt($('.shipping-charge').attr('data-shipping'));
        var total = parseInt($('#totalCartAmount0').val());

        console.log(charge+ ' ' + total);

        if (val === 'cod') {
            var totalAmount = total + charge;
            $('.shipping-charge').text('');
            $('#checkoutTotalAmount').text('');
            html = '<input type="hidden" id="totalCartAmount0" name="totalAmount" value="'+totalAmount+'">';
            html += '<i class="fa fa-inr"></i> <span>' + totalAmount + '</span>'
            $('<i class="fa fa-inr"></i> <span>' + charge + '</span>').appendTo('.shipping-charge');
            $(html).appendTo('#checkoutTotalAmount');
        } else {
            var totalAmount = total - charge;
            $('.shipping-charge').text('');
            $('#checkoutTotalAmount').text('');
            html = '<input type="hidden" id="totalCartAmount0" name="totalAmount" value="'+totalAmount+'">';
            html += '<i class="fa fa-inr"></i> <span>' + totalAmount + '</span>'
            $('<i class="fa fa-inr"></i> <span>' + charge + '</span>').appendTo('.shipping-charge');
            $(html).appendTo('#checkoutTotalAmount');
        }
        $('.loader').css('display', 'none')
    });


    $('body').on('change', '.select-product-cm-size', function(event) {
        event.preventDefault();
        
        var id = $('option:selected', this).val();
        var type = $('option:selected', this).attr('data-type');
        var product_id = $('option:selected', this).attr('data-product');
        get_attr_price( id, type, product_id );
                        
    });


    var attr_id = $('.size-attribute-selector').attr('data-value');
    var attr_type = $('.size-attribute-selector').attr('data-type');
    var attr_product_id = $('.size-attribute-selector').attr('data-product');


    if( attr_id && attr_type && attr_product_id ) {

        get_attr_price( attr_id, attr_type, attr_product_id );
    }

    $('body').on('click', '.size-attribute-selector', function(event) {
        event.preventDefault();
        
        var id = $(this).attr('data-value');
        var type = $(this).attr('data-type');
        var product_id = $(this).attr('data-product');
        get_attr_price( id, type, product_id );      
    });


    function get_attr_price(id, type, product_id) {
        $('.loader').css('display', 'block');
        
        $.ajax({
            url: base_url+'/api/-/attribute/price',
            type: 'POST',
            data: {id:id, type:type, pid:product_id},
        })
        .done(function(data) {

            console.log(data);
            
            if( data.price && data.price !== false ) {
                
                html = '';
                var price = data.price;
                if( data.discount ) {
                    price = Math.round(data.price - ( data.price * data.discount ) / 100);
                    html += '<del><span class="fa fa-inr"></span> '+Math.round(data.price)+'</del>'
                }
                html += '<span><span class="fa fa-inr"></span> '
                    + '<span class="product-price-text">'+price+'</span>';
                if( data.discount) {
                    html += ' <sup class="discount-off">'+data.discount+'% off</sup>';
                }                     
                html +'</span>';

                $('.product-price-wrapper').text('');
                $(html).appendTo('.product-price-wrapper');
            }
            else if( data.product ) {
                
                if( data.product.price_range ) {

                    var range = data.product.price_range;

                    html = '<span><span class="fa fa-inr"></span> '
                            + '<span class="product-price-text"> '+range+'</span></span>';

                    $('.product-price-wrapper').text('');
                    $(html).appendTo('.product-price-wrapper');
                }
                else {
                    html = '';
                    if( data.product.price ) {
                        var price = data.product.price - ( data.product.price * data.discount ) / 100;
                        html += '<del><span class="fa fa-inr"></span> '+price+'</del>'
                    }
                    html += '<span><span class="fa fa-inr"></span> '
                        + '<span class="product-price-text">'+data.product.price+'</span>';
                    if( data.discount) {
                        html += '<sup class="discount-off">'+data.discount+' off</sup>';
                    }                     
                    html +'</span>';

                    $('.product-price-wrapper').text('');
                    $(html).appendTo('.product-price-wrapper');
                }
            }

            $('.loader').css('display', 'none');
        })
        .fail(function(error) {
            console.log(error.responseText);
            $('.loader').css('display', 'block');
        })
        .always(function() {
            console.log("complete");
        });
    }

})