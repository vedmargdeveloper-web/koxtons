$(document).ready(function($) {
    var base_url = $('base').attr('href');
    var _token = $('meta[name="_token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': _token
        }
    });
    var cartTotalAmount = $('span#cartTotalPrice');
    $('body').on('click', '#addToCartProductTest', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        $('.loader').css('display', 'block');
        var $this = $(this);
        var id = $this.attr('data-id');
        var product_id = $this.attr('data-value');
        var quantity = $('input#itemQuantity').val();
        var color = $('.filters-color .color-selector .color.active').attr('data-value');
        var size = $('.filters-size .size-selector .size.active').attr('data-value');

        var data = {quantity: quantity, id: id, product_id: product_id, size: size, color: color };
        
        if( !id || !product_id )
            return false;
        cartTotalAmount.text(0);
        $.ajax({
            url: base_url + '/sgtest/cart/store',
            type: 'POST',
            data: data,
        })
        .done(function( data ) {
            console.log(data);
            //getCartProduct();
        })
        .fail(function(error) {
            console.log(error.responseText);
            $('.loader').css('display', 'none');
        })
        .always(function() {
            $('.loader').css('display', 'none');
        });
    });


    $('body').on('click', 'button#btnDeleteCartItemTest', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        /* Act on the event */
        $('.loader').css('display', 'block');
        var $this = $(this);
        $('input[name="_method"]', $('form#cartForm')).val('DELETE');
        var form = $('form#cartForm').serialize();
        var product_id = $this.attr('data-value');
        var id = $this.attr('data-id');
        var variation = $this.attr('data-variation');
        if( !product_id )
            return false;

        var form = {id:id, product_id:product_id, key:variation};

        //form += '&id='+id+'&product_id='+product_id;
        removeCart( $this, form, product_id );
        $this.parent('a').parent('td').parent('tr').remove();
    });


    var removeCart = function( $this, form = '', product_id ) {
        if( !form )
            return false;

        $.ajax({
            url: base_url + '/sgtest/cart/' + product_id,
            type: 'POST',
            data: form,
        })
        .done(function(data) {
            getCartProduct();
            $this.parent('a').parent('div').parent('li').remove();
            console.log(data);
        })
        .fail(function(xhr) {
            console.log(xhr.responseText);
        })
        .always(function() {
            $('.loader').css('display', 'none');
        });
    }


    $('body').on('submit', 'form#cartFormTest', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        $('.loader').css('display', 'block');
        var $this = $(this);
        $('input[name="_method"]', $this).val('PATCH');
        $this.attr('method', 'POST');
        var form = $this.serialize();
        if( !form ) {
            return false;
        }

        //console.log(form);

        updateCart( form );

    });

    var updateCart = function( form ) {      

        $.ajax({
            url: base_url + '/sgtest/cart/update',
            type: 'POST',
            data: form,
        })
        .done(function(data) {
            console.log(data);
            getCartProduct();
            /*if( data.response === true ) {

            }
            if( data.response === false ) {

            }
            if( data.data ) {
                udpateCartSidebar( data.data );
                updateCartTable( data.data );
            }*/
        })
        .fail(function(xhr) {
            console.log(xhr.responseText);
        })
        .always(function() {
            $('.loader').css('display', 'none');
        });
    }

    var updateCartTable = function( data ) {

        cartSubTotalAmount = 0;

        $.each(data, function(index, val) {
            amount = this.price;
            if( this.discount )
                amount = this.price - ( this.price * this.discount ) / 100;

            amount = Math.round(amount);

            amount = this.quantity * amount;
            cartSubTotalAmount += amount;

            $('span#cartProductAmount-'+this.product_id).children('span#cartProductTotalAmount').text(0);
            $('span#cartProductAmount-'+this.product_id).children('span#cartProductTotalAmount').text(amount);
        });
        var shipping_charge = parseInt($('input#shippingCharge').val());

        cartSubTotal.text(0);
        cartSubTotal.text(cartSubTotalAmount);
        cartTotalAmount.text(0);
        cartTotalAmount.text(cartSubTotalAmount+shipping_charge);
    }
    /*$('body').on('click', '.quantityPlus, .quantityMinus', function(event) {
        event.preventDefault();
        var val = $(this).siblings('.itemKey').val();
        var quantity = $(this).siblings('.quantity').val();
        var json = JSON.parse(val);
        var myObject = new Object();
        myObject.key = json.key;
        myObject.id = json.id;
        myObject.quantity = quantity;
        var myString = JSON.stringify(myObject);

        $(this).siblings('.itemKey').val(myString);
    });*/
    var getCartProduct = function() {
        $.ajax({
            url: base_url + '/sgtest/cart/get/items',
            type: 'POST'
        })
        .done(function( data ) {
            udpateCartSidebar( data );
            $('#sidebar-right').addClass('sidebar-open');
            $('.sidebar_overlay').addClass('sidebar_overlay_active');
        })
        .fail(function(error) {
            console.log(error.responseText);
            $('.loader').css('display', 'none');
        })
        .always(function() {
        });
        
    }
    var carTotalAmount = $('span#cartTotalPrice');
    var cartProductItemList = $('ul#cartProductItemList');
    var cartCounter = $('span#cartCounter');
    var udpateCartSidebar = function( data ) {

        totalAmount = 0;
        count = 0;
        cartProductItemList.children('li').remove();
        $.each(data, function(index, val) {
            $this = this;
            price = this.price;
            if( this.discount ) {
                price = this.price - ( this.price * this.discount ) / 100;
            }
            variations = JSON.parse(this.variations);
            $.each(variations, function(index, val) {
                 price = Math.round(price);
                count++;
                $html = '<li>'
                $html += '<a href="'+ $this.url +'" class="product-image">'
                $html += '<img src="'+ $this.feature_image +'" alt="'+ $this.title +'" />'
                $html += '</a>'
                $html += '<div class="product-content">'
                $html += '<a class="product-link" href="'+ $this.url +'">'+ $this.title +'</a>'
                $html += '<div class="cart-collateral">'
                $html += '<span class="qty-cart">'+$this.quantity+'</span>&nbsp;<span>&#215;</span>&nbsp;'
                $html += '<span class="product-price-amount"><span class="currency-sign"><i class="fa fa-inr"></i>'
                $html += '</span>'+price+'</span>';
                $html += '</div>'
                $html += '<a class="product-remove" data-id="'+$this.id+'" data-value="'+$this.product_id+'" href="javascript:void(0)">'
                $html += '<form method="POST" action="'+ base_url + '/sgtest/cart/' + $this.product_id +'" accept-charset="UTF-8" id="removeItemFromCartTest">'
                $html += '<input name="_method" value="DELETE" type="hidden">'
                $html += '<input name="_token" value="'+_token+'" type="hidden">'
                $html += '<button type="submit" data-value="'+$this.product_id+'" class="delete text-danger deleteProduct" id="btnRemoveCartItem" data-id="'+$this.id+'">'
                $html += '<i class="fa fa-trash fa-lg"></i></button>'
                $html += '</form></a>'
                $html += '</div>'
                $html += '</li>';
                totalAmount += $this.quantity * price;
                $( $html ).appendTo(cartProductItemList);
            });
            

            
        });
        carTotalAmount.text(0);
        cartCounter.text(0);
        cartCounter.text(count);
        carTotalAmount.text(totalAmount);
        //updateCartTable( data );
        $('.loader').css('display', 'none');
    }


    $('body').on('submit', 'form#removeItemFromCartTest', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        event.stopPropagation();
        /* Act on the event */
        $('.loader').css('display', 'block');
        var $this = $(this);
        var form = $(this).serialize();
        var product_id = $('button', $this).attr('data-value');
        var id = $('button', $this).attr('data-id');
        if( !product_id )
            return false;
        form += '&id='+id+'&product_id='+product_id;
        removeCart( $this, form, product_id );
    });


});