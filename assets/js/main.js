$(document).ready(function() {
    var scale = 3;
    var base_url = $('base').attr('href');
    var _token = $('meta[name="_token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': _token
        }
    }); /*$(".subs-overlay").delay(10000).fadeIn();*/
    $('body').on('click', '.close-popup', function(event) {
        event.preventDefault();
        $(".subs-overlay").fadeOut();
        $(".video-overlay").fadeOut()
    });
    $('.product-video-item').unbind('click');
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

    $('body').on('click','.show-cart-popup',function(event){
        event.preventDefault();
        $('#sidebar-right').addClass('sidebar-open');
        $('.sidebar_overlay').addClass('sidebar_overlay_active')
    });
    
    $('body').on('click', '#addToWishlist', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        _show();
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
                _hide();
            },
            error: function(xhr, ajaxOpt, thrownError) {
                _hide();
            }
        })
    });
    $('body').on('click', 'button#btnDeleteWishlistItem', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        _show();
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
            $this.parent('a').parent('td').parent('tr').remove();
            if ($('.cart-product-table-wrap tr').length <= 1) {
                $('.wish-list-item-title').text('0 Item In Your Wishlist');
                location.reload();
            }
        }).fail(function() {}).always(function() {;
            _hide();
        })
    });
    var carTotalAmount = $('span#cartTotalPrice');
    var cartProductItemList = $('ul#cartProductItemList');
    var cartCounter = $('span#cartCounter');
    $('body').on('submit', '.product-add-to-cart-form', function(event) {
        event.preventDefault();
        
        var form = $(this).serialize();
        $('._error', this).remove();
        var color = $('.filters-color .color-selector .color.active').attr('data-value');
        var size = $('.filters-size .size-attribute-selector.size.active').attr('data-value');

        if( $('.filters-size .size-attribute-selector').length > 0 ) {
            if( !size ) {
                _error('Select a size *', $('.filters-size .size-attribute-selector').parent('div') );
                return;
            }
        }
        var c_size = $('.product-cm-size.active').attr('data-value');
        if (color !== '' && color !== undefined)
            form = form + '&color=' + color;
        if (size !== '' && size !== undefined) form = form + '&size=' + size;
        if (c_size !== '' && c_size !== undefined) form = form + '&c_size=' + c_size;

        _show();
        var $this = $(this);
        var id = $this.attr('data-id');
        var product_id = $this.attr('data-product');
        if (!id || !product_id)
            return !1;
        form = form + '&id=' + id + '&product_id=' + product_id;
        carTotalAmount.text(0);
        $.ajax({
            url: base_url + '/cart/store',
            type: 'POST',
            data: form
        }).done(function(data) {
            
            if( !data.response ) {
                if (data.quantity === !1) {
                    $('<span class="_error text-warning">' + data.message + '</span>').insertAfter($('button#addToCartProductbtn').parent('.single-variation-wrap'))
                }
                else
                    getCartProduct();
            }

            _hide();
        }).fail(function(error) {
            _hide();
        }).always(function() {})
    });
    $('body').on('click', '#addToCartProduct', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        _show();
        var $this = $(this);
        var id = $this.attr('data-id');
        var product_id = $this.attr('data-value');
        //var quantity = $('input#itemQuantity').val();
        if (!id || !product_id)
            return !1;
        carTotalAmount.text(0);
        $.ajax({
            url: base_url + '/cart/store',
            type: 'POST',
            data: {
                id: id,
                product_id: product_id
            },
        }).done(function(data) {
            getCartProduct()
        }).fail(function(error) {
            _hide();
        }).always(function() {})
    });
    var getCartProduct = function() {
        $.ajax({
            url: base_url + '/cart/get',
            type: 'POST'
        }).done(function(data) {
            udpateCartSidebar(data);
            $('#sidebar-right').addClass('sidebar-open');
            $('.sidebar_overlay').addClass('sidebar_overlay_active')
        }).fail(function(error) {
            _hide();
        }).always(function() {})
    }
    var udpateCartSidebar = function(data) {
        if (!data || data.length < 1) {
            location.reload()
        }
        totalAmount = 0;
        count = 0;
        cartProductItemList.children('li').remove();
        $.each(data, function(index, val) {
            var variation = JSON.parse(this.variations);
            price = variation.price;
            if( !variation.price ) {
                variation.original_price
            } 
            if (variation.discount) {
                price = variation.price - (variation.price * variation.discount) / 100
            }
            if( variation.tax ) {
                price = price + ( price * variation.tax / 100 );
            }
            price = Math.round(price);
            count++;
            $html = '<li>'
            $html += '<a href="' + variation.url + '" class="product-image">'
            $html += '<img src="' + variation.feature_image + '" alt="' + variation.title + '" />'
            $html += '</a>'
            $html += '<div class="product-content">'
            $html += '<a class="product-link" href="' + variation.url + '">' + variation.title + '</a>'
            $html += '<div class="cart-collateral">'
            $html += '<span class="qty-cart">' + variation.quantity + '</span>&nbsp;<span>&#215;</span>&nbsp;'
            $html += '<span class="product-price-amount"><span class="currency-sign"><i class="fa fa-inr"></i>'
            $html += '</span>' + price + '</span>';
            $html += '</div>'
            $html += '<a class="product-remove"   data-id="' + this.product_id + '" data-value="' + this.product_no + '" href="javascript:void(0)">'
            $html += '<form method="POST" action="' + base_url + '/cart/' + this.product_no + '" accept-charset="UTF-8" id="removeItemFromCart">'
            $html += '<input name="_method" value="DELETE" type="hidden">'
            $html += '<input name="_token" value="' + _token + '" type="hidden">'
            $html += '<button type="submit" data-key="' + this.id + '" data-value="' + this.product_no + '" class="delete text-danger deleteProduct" id="btnRemoveCartItem" data-id="' + this.product_id + '">'
            $html += '<i class="fa fa-trash fa-lg"></i></button>'
            $html += '</form></a>'
            $html += '</div>'
            $html += '</li>';
            totalAmount += variation.quantity * price;
            $($html).appendTo(cartProductItemList)
        });
        carTotalAmount.text(0);
        cartCounter.text(0);
        cartCounter.text(count);
        carTotalAmount.text(totalAmount);
        updateCartTable(data);
        _hide();
    }
    $('body').on('submit', 'form#removeItemFromCart', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        _show();
        var $this = $(this);
        var product_id = $('button', $this).attr('data-value');
        var id = $('button', $this).attr('data-id');
        var key = $('button', $this).attr('data-key');
        if (!product_id)
            return !1;
        var form = 'id=' + id + '&product_id=' + product_id + '&key=' + key;
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
                _hide();
            }
        })
    }
    $('body').on('click', 'button#btnDeleteCartItem', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        _show();
        var $this = $(this);
        var product_id = $this.attr('data-value');
        var id = $this.attr('data-id');
        var key = $this.attr('data-key');
        if (!product_id || !key)
            return !1;
        form = 'id=' + id + '&product_id=' + product_id + '&key=' + key;
        removeCart($this, form, product_id);
        $this.parent('a').parent('td').parent('tr').remove()
    });
    $('body').on('submit', 'form#cartForm', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        _show();
        $('span._error', this).remove();
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
            if( data.response === false ) {
                _error(data.message, $('.cart-product-table-wrap'));
                return;
            }
            getCartProduct()
        }).fail(function(xhr) {}).always(function() {;
            _hide();
        })
    }
    var cartSubTotal = $('span#cartSubTotal');
    var cartTotalAmount = $('span#cartTotalAmount');
    var updateCartTable = function(data) {


        cartSubTotalAmount = 0;
        $.each(data, function(index, val) {
            var variation = JSON.parse(this.variations);
            amount = variation.price;
            if( !amount )
                amount = variation.original_price
            if (amount && variation.discount)
                amount = amount - (amount * variation.discount) / 100;
            if( variation.tax )
                amount = amount + (amount * variation.tax) / 100;

            amount = Math.round(amount);
            amount = variation.quantity * amount;
            
            cartSubTotalAmount += amount;
            $('span#cartProductAmount-' + this.product_no + ' span#cartProductTotalAmount').text(0);
            $('span#cartProductAmount-' + this.product_no + ' span#cartProductTotalAmount').text(amount)
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
        _show();
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
                $('<span class="error text-warning">' + result.error + '</span>').insertAfter($('.input-group', $this))
            }
            if (result.msg) {
                $('<span class="error text-success">' + result.msg + '</span>').insertAfter($('.input-group', $this))
            }
            _hide()
        }).fail(function(error) {
            _hide()
        }).always(function() {})
    });
    var country = $('select#tdcountry');
    var state = $('select#tdstate');
    var state_id = $('option:selected', state).val();
    var city = $('select#tdcity');
    var city_id = $('option:selected', city).val();
    
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
            _hide()
        }).fail(function(error) {
            _hide()
        }).always(function() {})
    }
    if (country_id = $('option:selected', country).val()) {
        get_state(country_id)
    }
    $('body').on('change', 'select#tdcountry', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        _show();
        var country_id = $('option:selected', this).val();
        get_state(country_id)
    });
    $('body').on('change', 'select#tdstate', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        _show();
        var state_id = $('option:selected', this).val();
        get_city(state_id)
    });
    if( state_id )
        get_city(state_id);

    function get_city(state_id) {
        
        $.ajax({
            url: base_url + '/get/city/' + state_id,
            type: 'GET'
        }).done(function(result) {
            html = '<option value="">Select</option>';
            if (result.cities) {
                $.each(result.cities, function(index, val) {
                    if( city_id == this.id )
                        html += '<option selected value="' + this.id + '">' + this.name + '</option>';
                    else
                        html += '<option value="' + this.id + '">' + this.name + '</option>';
                });
                city.children('option').remove();
                $(html).appendTo(city)
            }
            _hide()
        }).fail(function(error) {
            _hide()
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
        _show();
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
                
                amount = Math.round(amount);
                html = '<tr class="cart-subtotal">';
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
                html += '<input type="hidden" id="totalCartAmount0" name="totalAmount" value="' + amount + '">';
                html += '<i class="fa fa-inr"></i> ' + amount + '</span>';
                html += '</td></tr>';
                $('<span class="text-success">' + data.code_msg + '</span>').insertAfter(input_coupon.parent('.input-group'));
                $(html).insertBefore('#orderTotal');
                $('#orderTotal').remove();
            } else {
                $('<span class="text-warning">' + data.code_err + '</span>').insertAfter(input_coupon.parent('.input-group'))
            }
        }).fail(function(error) {}).always(function() {;
            _hide()
        })
    });

    $('body').on('click', '.bmcoupon-apply', function(event) {
        event.preventDefault();
        var totalAmt = parseInt($('input#totalCartAmount0').val());
        if( $(this).siblings('input').is(':checked') ) {
            if( totalAmt ) {
                var amt = totalAmt + (totalAmt * 10 / 100);
                $('.newTotalAmount').remove();
                $(this).siblings('input').attr('checked', false);
            }
        }
        else {
            if( totalAmt ) {
                var amt = totalAmt - (totalAmt * 10 / 100);
                html = '<p class="newTotalAmount"><strong>Amount:</strong> <i class="fa fa-inr"></i> '+amt+'</p>';
                $(html).insertAfter($(this).parent('p'));
                $(this).siblings('input').attr('checked', true);
            }
        }
    });
    $('body').on('submit', 'form#contactForm1', function(event) {
        event.preventDefault();
        _show();
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
            _hide()
        })
    });
    $('body').on('submit', 'form#subscribeForm', function(event) {
        event.preventDefault();
        _show();
        $('.error', this).remove();
        $url = $(this).attr('action');
        var $this = $(this);
        var form = $(this).serialize();
        $.ajax({
            url: $url,
            type: 'POST',
            data: form,
        }).done(function(data) {
            if (data.email) {
                $('<span class="error text-danger">' + data.email[0] + '</span>').insertAfter($('.input-group', $this));
            }
            if (data.err) {
                $('<span class="error text-danger mt-1">' + data.err + '</span>').insertAfter($('.input-group', $this));
                return
            }
            if (data.msg) {
                $('<span class="error text-success mt-1">' + data.msg + '</span>').insertAfter($('.input-group', $this));
                $this[0].reset();
                return
            }
            return
        }).fail(function(error) {}).always(function() {
            _hide()
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
        var totalHeight = itemContainerHeight - (header + 200 );
        var header_topbar = parseInt($('.header-main').height());
        $(window).scrollTop() < header_topbar ? $('.header-main').removeClass('fixed') : $('.header-main').addClass('fixed');

        if ($(window).scrollTop() >= totalHeight) {
            if (noMore === !1) {
                _show();
                if (checkVisible($('#loadMoreRow'))) {
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
        var type = $('.product-container').attr('data-type');
        var s = $('input[name="s"]').val();
        /*if (!cat) {
            _hide();
            return;
        }*/

        var url = base_url + '/load/data?slug=' + cat;
        var sortBy = $('option:selected', $('form#sorting-form select')).val();
        page++;
        if( S )
            url += '&S=' + S;
        if( sortBy )
            url += '&sort_by=' + sortBy;
        if( type )
            url += '&type=' + type;
        if( page )
            url += '&page=' + page;
        
        $.ajax({
            url: url,
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
                
                appendRows(data.products, $('#loadMoreRow'));
                scrollBack();
            }
        }).fail(function(error) {}).always(function() {
            _hide();
            if (noMore === !1) {
                $(window).scroll(scrollFunction)
            }
        })
    }
    var appendRows = function(products, place) {
        var c = 0;
        $.each(products, function(index, val) {
            if (c < 1 || c === 3) {
                html = '<div id="' + this.product_id + '" class="row product-list-item">';
                c = 0
            }
            html += '<div class="product-item-element col-sm-4 col-md-4 col-lg-4 col-12">';
            html += '<div class="product-item">';
            html += '<a href="' + this.cat_url + '">';

                html += '<div class="product-item-inner">';
                    html += '<div class="product-img-wrap">';
                    
                        html += '<img src="' + this.img_url + '" alt="' + this.title + '">';
                        if (this.discount && this.discount != 0 && this.discount != null) {
                            html += '<div class="sale-label discount">'
                            html += '<span>-' + this.discount + '%</span>';
                            html += '</div>'
                        }
                    html += '</div>';

                    icon = this.in_wishlist ? 'fa-heart' : 'fa-heart-o';

                    html += '<div class="product-over">';
                    html += '<div class="product-button">';
                    html += '<div role="button" class="btn-cart" id="addToCartProduct" data-value="' + this.product_id + '" data-id="' + this.id +'" data-mode="top" data-tip="Add To Cart"><i class="fa fa-shopping-bag"></i></div>';
                    html += '<div role="button" class="btn-wishlist" id="addToWishlist" data-value="' + this.product_id + '" data-id="' + this.id + '" data-mode="top" data-tip="Add To Whishlist"><i class="fa ' + icon + '"></i></div>';
                    html += '</div>';
                    html += '</div>';

                html += '</div>';

                html += '<div class="product-detail">';
                    html += '<p class="product-title">' + this.title + '</p>';
                    html += '<h5 class="item-price">';
                    if (this.discount) {
                        html += '<del><sub><span class="fa fa-inr"></span>' + this.price + '</sub></del>';
                        html += '<span class="fa fa-inr"></span>' + this.newPrice
                    } else {
                        html += '<span class="fa fa-inr"></span>' + this.price
                    }
                    html += '</h5>';
                html += '</div>';
            html += '</a>';
            html += '</div>';
            html += '</div>';
            if (c === 2) {
                html += '</div>';
                $(html).insertBefore(place)
            }
            c++
        });
        if (c <= 2) {
            html += '</div>';
            $(html).insertBefore(place)
        }
    }
    $('body').on('click', 'button#loadMoreBtnHome', function(event) {
        $('.nomore').remove();
        _show();
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
            _hide()
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
                round++
            } else {
                owl.trigger('stop.owl.autoplay');
                var owlData = owl.data('owl.carousel');
                owlData.settings.autoplay = !1;
                owlData.options.autoplay = !1;
                owl.trigger('refresh.owl.carousel')
            }
        }
    });
    $('body').on('change', '.payment_method_cod', function(event) {
        event.preventDefault();
        _show();
        var val = $(this).val();
        var charge = parseInt($('.shipping-charge').attr('data-shipping'));
        var total = parseInt($('#totalCartAmount0').val());
        var totalAmount = total;
        if (val === 'cod') {
            
            //$('.shipping-charge').text('');
            $('#checkoutTotalAmount').text('');
            
            if( $('#membership').is(':checked') ) {
                var amount = parseInt($('#membership').attr('data-value'));
                totalAmount = total - amount;
                //totalAmount = totalAmount + charge;
                $('#membership').prop('checked', false);
            }
            else {
                //totalAmount = total + charge;
            }

            html = '<input type="hidden" id="totalCartAmount0" name="totalAmount" value="' + totalAmount + '">';
            html += '<i class="fa fa-inr"></i> <span>' + totalAmount + '</span>'
            //$('<i class="fa fa-inr"></i> <span>' + charge + '</span>').appendTo('.shipping-charge');
            $(html).appendTo('#checkoutTotalAmount');

            $('#membership').attr('disabled', true);

        } else {
            //var totalAmount = total - charge;
            //$('.shipping-charge').text('');
            $('#checkoutTotalAmount').text('');
            html = '<input type="hidden" id="totalCartAmount0" name="totalAmount" value="' + totalAmount + '">';
            html += '<i class="fa fa-inr"></i> <span>' + totalAmount + '</span>'
            //$('<i class="fa fa-inr"></i> <span>' + charge + '</span>').appendTo('.shipping-charge');
            $(html).appendTo('#checkoutTotalAmount');
            $('#membership').attr('disabled', false);
        }
        _hide()
    });
    $('body').on('click', '.select-product-cm-size .product-cm-size', function(event) {
        event.preventDefault();
        var id = $(this).attr('data-value');
        var type = $(this).attr('data-type');
        var product_id = $(this).attr('data-product');
        get_attr_price(id, type, product_id)
    });
    var attr_id = $('.size-attribute-selector').attr('data-value');
    var attr_type = $('.size-attribute-selector').attr('data-type');
    var attr_product_id = $('.size-attribute-selector').attr('data-product');
    if (attr_id && attr_type && attr_product_id) {
        get_attr_price(attr_id, attr_type, attr_product_id)
    }
    var attr_id = $('.select-product-cm-size .product-cm-size.active').attr('data-value');
    var attr_type = $('.select-product-cm-size .product-cm-size.active').attr('data-type');
    var attr_product_id = $('.select-product-cm-size .product-cm-size.active').attr('data-product');
    if (attr_id && attr_type && attr_product_id) {
        get_attr_price(attr_id, attr_type, attr_product_id);
    }
    $('body').on('click', '.size-attribute-selector', function(event) {
        event.preventDefault();
        var id = $(this).attr('data-value');
        var type = $(this).attr('data-type');
        var product_id = $(this).attr('data-product');
        get_attr_price(id, type, product_id)
    });

    function get_attr_price(id, type, product_id) {
        _show();
        $.ajax({
            url: base_url + '/api/-/attribute/price',
            type: 'POST',
            data: {
                id: id,
                type: type,
                pid: product_id
            },
        }).done(function(data) {
            if (data.price) {
                html = '';
                var price = data.price;
                if (data.discount != 0) {
                    html += '<del><span class="fa fa-inr"></span> ' + Math.round(price) + '</del>';
                    price = price - (price * data.discount) / 100;
                }

                if ( data.tax ) {
                    price = price + (price * data.tax) / 100;
                }

                html += '<span><span class="fa fa-inr"></span> ' + '<span class="product-price-text">' + Math.round(price) + '</span>';
                if (data.discount) {
                    html += ' <sup class="discount-off">' + data.discount + '% off</sup>'
                }

                if (data.shipping_charge) {
                    html += '<span class="shipping-charge"> + <span class="fa fa-inr"></span>'+data.shipping_charge+' (Shipping charge)</span>'
                }

                html + '</span>';
                $('.product-price-wrapper').text('');
                $(html).appendTo('.product-price-wrapper')
            } else if (data.product) {

                if (data.product.price_range) {
                    var range = data.product.price_range;
                    html = '<span><span class="fa fa-inr"></span> ' + '<span class="product-price-text"> ' + range + '</span></span>';
                    $('.product-price-wrapper').text('');
                    $(html).appendTo('.product-price-wrapper')
                } else {
                    html = '';
                    var price = data.product.price;
                    if (data.product.discount) {
                        html += '<del><span class="fa fa-inr"></span> ' + price + '</del>'
                        price = price - (price * data.product.discount) / 100;
                    }

                    if ( data.product.tax ) {
                        price = price + (price * data.product.tax) / 100;
                    }

                    html += '<span><span class="fa fa-inr"></span> ' + '<span class="product-price-text">' + price + '</span>';
                    if (data.product.discount) {
                        html += '<sup class="discount-off">' + data.product.discount + ' off</sup>'
                    }

                    if (data.product.shipping_charge) {
                        html += '<span class="shipping-charge"> + <span class="fa fa-inr"></span>'+data.product.shipping_charge+' (Shipping charge)</span>'
                    }
                    html + '</span>';
                    $('.product-price-wrapper').text('');
                    $(html).appendTo('.product-price-wrapper')
                }
            }
            _hide()
        }).fail(function(error) {
            _show()
        }).always(function() {})
    }
    $('body').on('click', '.product-video', function(event) {
        event.preventDefault();
        $('.video-overlay').fadeIn()
    })

    if (window.location.hash == '#review') {
        $('.product-content-tabs li a').removeClass('active');
        $('.product-content-tabs li a.review').addClass('active');

        $('.product-content-Tabs_wraper .tab-pane').removeClass('active in');
        $('.product-content-Tabs_wraper .reviews.tab-pane').addClass('active in');

        $('html, body').animate({
            scrollTop: $("#otherDetails").offset().top
        }, 2000);
    }

    $(".main-slider").each(function(index, el) {
        var config = $(this).data();
        config.navText = ['', ''];
        config.smartSpeed = "800";

        $(this).owlCarousel(config);
    });

    $(".product-item-6").owlCarousel({
        items: 6,
        loop: !1,
        lazyLoad: 1,
        autoplay: !1,
        autoplayHoverPause: !0,
        singleItem: !0,
        dots: !1,
        nav: !0,
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        responsive: {
            0: {
                items: 2,
                margin: 10,
            },
            320: {
                items: 2,
                margin: 10,
            },
            480: {
                items: 2,
                margin: 15,
            },
            775: {
                items: 3,
                margin: 20,
            },
            991: {
                items: 5,
                margin: 30,
            },
            1170: {
                items: 6,
                margin: 30,
            }
        }
    });

    $('body').on('click', 'a.btn-category', function(event) {
        event.preventDefault();
        if( $('span', this).hasClass('fa-angle-down') ) {
            $('span', this).removeClass('fa-angle-down');
            $('span', this).addClass('fa-angle-up');
        }
        else {
            $('span', this).removeClass('fa-angle-up');
            $('span', this).addClass('fa-angle-down');
        }

        $(this).siblings('.dropdown-category').toggle();
    });

    $('body').on('click', '.dropdown-category li a', function(event) {
        event.preventDefault();

        var label = $(this).attr('data-label');
        var value = $(this).attr('data-value');
        $('.btn-category').html( label + '<span class="fa fa-angle-down"></span>');
        $('.btn-category').siblings('input[name="cat"]').val(value);
        $('.dropdown-category').fadeOut();

        $('.dropdown-category .dropdown-menu').each(function(index, el) {
            $(this).removeClass('show');
        });
        $('.dropdown-category .has-children .mobile.plus-sign').each(function(index, el) {
            $(this).removeClass('open');
        });
    });

    $('body').on('click', '.mobile.plus-sign', function(event) {
        event.preventDefault();
        $(this).toggleClass('open');        
        $('.dropdown-category .has-children .dropdown-menu').each(function(index, el) {
            $(this).removeClass('show');
        });
        if( $(this).siblings('.dropdown-menu').hasClass('show') ) {
            $(this).siblings('.dropdown-menu').removeClass('show');
            $(this).siblings('.dropdown-menu').addClass('hide');
        }
        else {
            if( $(this).hasClass('open') ) {
                $(this).siblings('.dropdown-menu').removeClass('hide');
                $(this).siblings('.dropdown-menu').addClass('show');
            }
            else {
                $(this).siblings('.dropdown-menu').removeClass('show');
                $(this).siblings('.dropdown-menu').addClass('hide');
            }
        }
        $('.dropdown-category .has-children .mobile.plus-sign').each(function(index, el) {
            if( $(this).siblings('.dropdown-menu').hasClass('show') ){

            }
            else
                $(this).removeClass('open');
        });
        
        //$(this).parent('a').siblings('.dropdown-category').toggle();
    });

    $('body').on('change', '#membership', function(event) {
        event.preventDefault();
        var amount = parseInt($(this).attr('data-value'));
        var totalAmount = parseInt($('#totalCartAmount0').val());
        if( $(this).is(':checked') ) {
            totalAmount = totalAmount + amount;
        }
        else
            totalAmount = totalAmount - amount;

        var html = '<th>Total</th>';
        html += '<td>';
        html += '<span id="checkoutTotalAmount" class="product-price-amount amount">';
        html += '<i class="fa fa-inr"></i> '+totalAmount+'</span>';
        html += '<input type="hidden" id="totalCartAmount0" name="totalAmount" value="'+totalAmount+'">';
        html += '</td>';
        html += '</tr>';

        $('#orderTotal').html('');
        $(html).appendTo('#orderTotal');
    });


    $('body').on('change', 'input#document', function(event) {
          event.preventDefault();

          $(this).siblings('._error').remove();
          var $this = $(this);
          var name = $(this).attr('name');
          var uid = $('input[name="uid"]').val();

          var file = $(this)[0].files[0];
          var fd = new FormData();
          fd.append(name, file);
          fd.append('uid', uid);

          if( !file.name ) return;

          _show();
          
          $.ajax({
              url: base_url + '/seller/store/document',
              type: 'POST',
              data: fd,
              contentType: false,
              processData: false,
          })
          .done(function(data) {
            if( data.validation == 'failed' ) {
              if( data.errors ) {
                if( data.errors.avtar )
                  _error(data.errors.avtar, $this );
                if( data.errors.pancard )
                  _error(data.errors.pancard, $this );
                if( data.errors.aadhar )
                  _error(data.errors.aadhar, $this );
                if( data.errors.signature )
                  _error(data.errors.signature, $this );
                if( data.errors.passbook )
                  _error(data.errors.passbook, $this );
                if( data.message )
                  _error(data.message, $this );
              }
            }
            if( data.validation == 'success' ) {
              $('img#'+name).attr('src', data.file_url);
            }
            _hide();
          })
          .fail(function(error) {
            _hide();
          });
    });


    $('body').on('click', '.mobile-filter-menu', function(event) {
        event.preventDefault();
        $(this).parent('.filter-button').siblings('.filter-sidebar').toggle('show');

        if( $(this).children('span').hasClass('fa-filter') ) {
            $(this).children('span').removeClass('fa fa-filter');
            $(this).children('span').addClass('close');
        }
        else {
            $(this).children('span').removeClass('close');
            $(this).children('span').addClass('fa fa-filter');
            
        }
    });


    $('body').on('submit', 'form#orderSearchForm', function(event) {
        event.preventDefault();
        var form = $(this).serialize();
        var $this = $(this);
        $('span._error', $this).remove();
        $('#orderDetails').remove();
        _show();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: form,
        })
        .done(function(data) {
            $(data).insertAfter( $this );
            _hide();
        })
        .fail(function(error) {
            if( error.responseJSON.order_no ) {
                _error( error.responseJSON.order_no , $('input[name="order_no"]', $this) );
            }
            if( error.responseJSON.mobile ) {
                _error( error.responseJSON.mobile , $('input[name="order_no"]', $this) );
            }
            
            _hide();
        });
        
    });




    function _show() {
        $('.spinner-loader').css('display', 'block');
    }
    function _hide() {
        $('.spinner-loader').css('display', 'none');
    }
    function _error( text, selector ) {
        $('<span class="_error text-warning">'+text+'</span>').insertAfter(selector);
    }

    /*$("#img_01").elevateZoom({
        gallery:'gal1',cursor:'pointer',galleryActiveClass:'active',imageCrossfade:!0,
    });
    $("#img_01").bind("click",function(e){
        var ez=$('#img_01').data('elevateZoom');$.fancybox(ez.getGalleryList());
        return!1
    })*/

})