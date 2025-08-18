$(document).ready(function(){

  var base_url = $('base').attr('href');
  var _token = $('input[name="_token"]').val();
  $.ajaxSetup({headers:{'X-CSRF-TOKEN':_token}});

	$('#img-remove').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		if( confirm('Are you sure?') )
			$(this).parent('div.figure-img').remove();

		return false;
	});
  var ids = [];
  $('body').on('change','.my-selected-priority',function(e){
      alert($(this).val());
      ids.push($(this).val());
       console.log(ids);
  });



	$("#tag-typer").keypress( function(event) {
	    var key = event.which;
	    if (key == 13 || key == 44){
	     event.preventDefault();
	     var tag = $(this).val();
	      if(tag.length > 0){
	        $("<span class='tag' style='display:none'><span class='close'>&times;</span>"+tag+" </span>").insertBefore(this).fadeIn(100);
	        $(this).val("");
	      }
	    }
	});

  $('body').on('change','.check-color-select',function(event){
    event.preventDefault();
    var dd  = $(this).val().toLowerCase();
    $('.add-new-row').append('<div class="row"><div class="col-md-4"><div class="form-group"><input type="text" value="'+dd+'" name="color[]" class="form-control"></div></div><div class="col-md-4"><div class="form-group"><input type="text" name="su_code[]" class="form-control" placeholder="SU Code"></div></div><div class="col-md-4"><div class="form-group"><input type="file" name="images[]" multiple class="form-control"></div></div></div>')
  });

  $('body').on('change','.check-color-select-update',function(event){
    event.preventDefault();
    var dd  = $(this).val().toLowerCase();
    $('.add-new-row-update').append('<div class="row"><div class="col-md-4"><div class="form-group"><input type="text" value="'+dd+'" name="color[]" class="form-control"></div></div><div class="col-md-4"><div class="form-group"><input type="text" style="display:none" name="su_code[]" class="form-control" placeholder="SU Code"></div></div><div class="col-md-4"><div class="form-group"><input type="file" name="images[]" multiple class="form-control"></div></div></div>')
  });

  $('body').on('click','.remove-color-sucode',function(event){
        var pid = $(this).data('pid');
        var color_name = $(this).attr('data-color');
        var row_id = $(this).attr('data-id');
        $.ajax({
            url: base_url + "/remove/sucode/color",
            type: "post",
            data: {product_id: pid,color_name:color_name,rowid: row_id },
            dataType: 'json',
        })
        .done(function(succ) {
            if(succ.message == 'success'){
              $('.add-new-row-'+row_id).remove();
            }
           
            // console.log(succ.id.images);
          
            // console.log(succ);
        })
        .fail(function(err) {
            console.log(err);
        })
        .always(function() {
            console.log("complete");
        });
    });

  $('body').on('click', '.zoomImage', function(event) {
    event.preventDefault();
    console.log('sdfsg');
    var src = $(this).attr('src');
    var lg_src = $(this).attr('data-src-lg');

    if( lg_src ) {

      $('.lightbox-target img').attr('src', lg_src);
      $('.lightbox-target a.download').attr('href', lg_src);
    }
    else {
      $('.lightbox-target a.download').attr('href', src);
      $('.lightbox-target img').attr('src', src);
    }

    $('.lightbox-target').fadeIn();
    /* Act on the event */
  });
  $('body').on('click', 'a.lightbox-close', function(event) {
    event.preventDefault();
    $('.lightbox-target img').attr('src', '');
    $('.lightbox-target a.download').attr('href', '');
    $('.lightbox-target').fadeOut('fast');
  });
  
	$("#tags").on("click", ".close", function() {
		$(this).parent("span.tag").remove();
	});  


  $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
      e.preventDefault();
      $(this).siblings('a.active').removeClass("active");
      $(this).addClass("active");
      var index = $(this).index();
      $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
      $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
  });

  $('body').on('click', 'button#addColorQty', function(event) {
    event.preventDefault();
    /* Act on the event */
    $('#colorQty span.label-warning').remove();
    var color = $('#colorQty select[name="color"]');
    var qty = $('#colorQty input[name="qty"]');
    
    if( !valid_color( color, color.parent('div').parent('div') ) ) return false;
    if( !valid_quantity( qty, qty.parent('div') ) ) return false;

    html = '<div class="tags">';
    html += '<a role="button" class="pull-right" id="removeTag"><span class="fa fa-close"></span></a>';
    html += '<span>Color: '+color.val()+'</span> <span>Qty: '+qty.val()+'</span>';
    html += '</div>';

    $(html).appendTo('#tag-holder');
    return true;

  });

  var valid_color = function( selector, error ) {

    if( $('option:selected', selector).val() === '' ) {
      _error('Select color!', error);
      return false;
    }
    return true;
  }

  var valid_quantity = function( qty, error ) {
    if( qty.val() === '' ) {
      _error('Enter quantity in number!', error);
      return false;
    }
    if( !jQuery.isNumeric( qty.val() ) || qty.val() < 0 ) {
      _error('Quantity must be a valid numeric value!', error);
      return false;
    }
    return true;
  }

  var _error = function( text, selector ) {
    $('<span class="_error label-warning">'+text+'</span>').insertAfter(selector);
  }

  $('body').on('click', 'a.removeImage', function(event) {
    event.preventDefault();
    /* Act on the event */
    $(this).parent('.figure-img').remove();
  });

  
    $(".h-tab_content").hide();
    $(".h-tab_content:first").show();

    $(".h-tab_tab-head li").click(function() {
  
      $(".h-tab_content").hide();
      var activeTab = $(this).attr("rel"); 
      $("#"+activeTab).fadeIn();    
      $(".h-tab_tab-head li").removeClass("active");
      $(this).addClass("active");

    
    });

    $('button#addLink').on('click', function(e) {
      e.preventDefault();

      $('span.error').remove();

      $name = $('input[name="link_title"]');
      $url = $('input[name="link_url"]');

      if( $name.val() === '' ) {
        _error('Name is required *', $name);
        return;
      }
      if( $url.val() === '' ) {
        _error('Url is required *', $url);
        return;
      }

      if( $('input[name="new_tab"]').is(':checked') )
        $check = $('input[name="new_tab"]').val();
      else
        $check = 0;

      $slug = slug( $name.val() );

      $html = '<li class="dd-item" data-slug="'+$slug+'" data-target="'+$check+'" data-type="link" data-url="'+$url.val()+'" data-name="'+$name.val()+'" data-id="0">';
      $html += '<div class="dd-handle">'+$name.val()+'</div></li>';

      $('.m-container .dd-list.item-list').append($html);
      $('input[name="link_title"]').val('');
      $('input[name="link_url"]').val('');
    });

    $('body').on('click', '.add-more-dimension', function(event) {
      event.preventDefault();
      console.log('dfs');
      html = '<tr>'
              +'<td>'
              +'<select class="form-control" name="dimension_type[]">'
                    +'<option value="cm">CM</option>'
                    +'<option value="inch">Inch</option>'
                  +'</select>'
              +'</td>'
              +'<td>'
              +  '<input type="number" value="" name="weight[]" class="form-control">'
             + '</td>'
            +  '<td>'
             +   '<input type="number" value="" name="width[]" class="form-control">'
             + '</td>'
             + '<td>'
             +   '<input type="number" value="" name="height[]" class="form-control">'
            +  '</td>'
             + '<td>'
             +   '<input type="number" value="" name="length[]" class="form-control">'
             + '</td>'
             + '<td>'
              +  '<input type="number" value="" name="dimension_price[]" class="form-control">'
               + '<a class="remove-row-dimension remove-btn"><i class="fa fa-close"></i></a>'
             + '</td>'
           + '</tr>';

      $(html).appendTo('.table-dimensions tbody');
    });

    $('body').on('click', '.add-more-size-field', function(event) {
      event.preventDefault();
      var html = '<div class="form-group">'
                 + '<div class="row">'
                  + '<div class="col-lg-3">'
                  + '<input type="text" placeholder="Size" name="custom_size[]" class="mb-1 form-control">'
                  + '</div>'
                  + '<div class="col-lg-3">'
                  + '<input type="number" placeholder="Stock" name="custom_size_stock[]" class="mb-1 form-control">'
                  + '</div>'
                  + '<div class="col-lg-3">'
                  + '<input type="text" placeholder="Price" name="custom_size_price[]" class="mb-1 form-control">'
                  + '</div>'
                  + '<div class="col-lg-3">'
                  + '<input type="file" placeholder="Image" name="custom_size_image[]" class="mb-1 form-control">'
                  + '</div> <a class="remove-size-field remove-btn"><i class="fa fa-close"></i></a>'
                  + '</div>'
                +'</div>';

      $(html).insertBefore($(this));
    });

    $('body').on('click', '.remove-size-field', function(event) {
      event.preventDefault();
      /* Act on the event */
      $(this).parent('div').parent('div').remove();
    });

    $('body').on('click', '.remove-row-dimension', function(event) {
      event.preventDefault();
      $(this).parent('td').parent('tr').remove();
    });

    var slug = function(str) {
      var $slug = '';
      var trimmed = $.trim(str);
      $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
      replace(/-+/g, '-').
      replace(/^-|-$/g, '');
      return $slug.toLowerCase();
  }


  $('body').on('change', '.action-control', function(event) {
    event.preventDefault();
    var val = $('option:selected', this).val();

    switch (val) {
      case 'select-all':
        $('.table input[type="checkbox"]').each(function(index, el) {
          $(this).attr('checked', true);
        });
        break;

      case 'unselect-all':
        $('.table input[type="checkbox"]').each(function(index, el) {
          $(this).attr('checked', false);
        });
        break;

      case 'active':
          update_product_status( $('option:selected', this).attr('data-id'), $('option:selected', this).val() );
        break;

      case 'inactive':
          update_product_status( $('option:selected', this).attr('data-id'), $('option:selected', this).val() );
        break;

      case 'reject':
          reject_product( $('option:selected', this).attr('data-id'), $('option:selected', this).val() );
        break;

      case 'delete':
        delete_data();
        break;
      default:
        
        break;
    }
  });

  $('body').on('change', '.order-action-control', function(event) {
    event.preventDefault();
    var val = $('option:selected', this).val();

    switch (val) {
      case 'select-all':
        $('.table input[type="checkbox"]').each(function(index, el) {
          $(this).attr('checked', true);
        });
        break;

      case 'unselect-all':
        $('.table input[type="checkbox"]').each(function(index, el) {
          $(this).attr('checked', false);
        });
        break;

      case 'delivered':
          // update_order_status( $('option:selected', this).attr('data-id'), $('option:selected', this).val() );
          shipped_order( $('option:selected', this).attr('data-id'), $('option:selected', this).val() );
        break;

      case 'shipped':
          // update_order_status( $('option:selected', this).attr('data-id'), $('option:selected', this).val() );
          shipped_order( $('option:selected', this).attr('data-id'), $('option:selected', this).val() );
        break;

      case 'pending':
          update_order_status( $('option:selected', this).attr('data-id'), $('option:selected', this).val() );
        break;

      case 'cancel':

        reject_order( $('option:selected', this).attr('data-id'), $('option:selected', this).val() );
        break;

      case 'delete':

        delete_order( $('option:selected', this).attr('data-id') );
        break;

      case 'view-invoice':

        window.location = $('option:selected', this).attr('data-url');

        break;

      case 'generate-invoice':

        window.location = $('option:selected', this).attr('data-url');
        
        break;

      default:
        
        break;
    }


  });


  function delete_order( id ) {
    if( !confirm('Are you sure') ) 
        return;

      $('option:selected', $('.order-action-control')).prop("selected", false);

      if( !id )
        return;

      _show();

      $.ajax({
        url: base_url + '/order/delete/'+id,
        type: 'POST',
        data: {id:id},
      })
      .done(function(data) {
        console.log(data);
        _hide();
      })
      .fail(function(error) {
        _hide();
      }); 
  }

  function update_order_status( id, status ) {

      if( !confirm('Are you sure') ) 
        return;

      $('option:selected', $('.order-action-control')).prop("selected", false);

      if( !id || !status )
        return;

      _show();

      $.ajax({
        url: base_url + '/order/update/status',
        type: 'POST',
        data: {id:id, status:status},
      })
      .done(function(data) {
        console.log(data);
        if( data.message == 'success' ) {
          $('.status-' + id).text( ucfirst(status) );
        }

        _hide();
      })
      .fail(function(error) {
        _hide();
      }); 
  }


  function shipped_order( id, status ) {
    if( !id || !status )
      return;
    $('input[name="order_id"]', 'form#orderShippedForm').val(id);
    $('input[name="status"]', 'form#orderShippedForm').val(status);
    $('#orderShippedModal').modal({
      show: true,
      backdrop: 'static',
      keyboard: false
    });
  }

  $('body').on('submit', 'form#orderShippedForm', function(event) {
    event.preventDefault();
    var id = $('input[name="order_id"]', this).val();
    var remark = $('textarea[name="remark"]', this).val();
    var status = $('.input-value-status').val();

    if( !id )
      return;

    _show();

    $.ajax({
      url: base_url + '/order/update/status',
      type: 'POST',
      data: {id:id, status:status, remark:remark},
    })
    .done(function(data) {
      console.log(data);
      console.log('dddd');
      if( data.message == 'success' ) {
        $('.status-' + id).text( ucfirst(status) );
      }
      console.log('ddddddd');
      $('#orderShippedModal').modal('hide');

      _hide();
    })
    .fail(function(error) {
      _hide();
    });
  });



  function reject_order( id, status ) {
    if( !id || !status )
      return;
    $('input[name="order_id"]', 'form#orderRejectForm').val(id);
    $('#orderRejectModal').modal({
      show: true,
      backdrop: 'static',
      keyboard: false
    });
  }

  $('body').on('submit', 'form#orderRejectForm', function(event) {
    event.preventDefault();
    var id = $('input[name="order_id"]', this).val();
    var remark = $('textarea[name="remark"]', this).val();
    var status = 'cancelled';

    if( !id )
      return;

    _show();

    $.ajax({
      url: base_url + '/order/update/status',
      type: 'POST',
      data: {id:id, status:status, remark:remark},
    })
    .done(function(data) {
      console.log(data);
      if( data.message == 'success' ) {
        $('.status-' + id).text( ucfirst(status) );
      }

      $('#orderRejectModal').modal('hide');

      _hide();
    })
    .fail(function(error) {
      _hide();
    });
  });


  function delete_data() {

    if( !confirm("Are you sure, it can't be recoved!") ) 
      return;

    var ids = [];
    $('.table input[type="checkbox"]').each(function(index, el) {
      if( $(this).is(':checked') ) {
        ids.push( $(this).val() );
      }
    });
    if( ids.length < 1 ) {
      alert('Please select a product to delete!');
      return;
    }

    _show();

    $.ajax({
      url: base_url + '/product/delete',
      type: 'POST',
      data: {ids:ids},
    })
    .done(function(data) {
      console.log(data);
      if( data.message == 'success' )
        location.reload();

      _hide();
    })
    .fail(function(error) {
      _hide();
    });
  }

  function update_product_status( id, status ) {
      if( !confirm('Are you sure') ) 
        return;

      if( !id || !status )
        return;

      _show();

      $.ajax({
        url: base_url + '/product/update/status',
        type: 'POST',
        data: {id:id, status:status},
      })
      .done(function(data) {
        console.log(data);
        if( data.message == 'success' ){
          if(status == 'active'){
            $('.mystatus-'+id).text('Active');
            $('select option:contains("Active")').each(function(){
               var $this = $(this);
               if($(this).attr('data-id') == id){
                 $this.text($this.text().replace("Active","Inactive"));
                 $this.attr('value','inactive');    
               }
            });
          }
          if(status == 'inactive'){
            $('.mystatus-'+id).text('Inactive');

            $('select option:contains("Inactive")').each(function(){
               var $this = $(this);
               if($(this).attr('data-id') == id){
                 $this.text($this.text().replace("Inactive","Active"));    
                 $this.attr('value','active');
               }
            });
          }
          if(status == 'reject'){
            $('.mystatus-'+id).text('Reject');
            
          }
        }
          // location.reload();
          

        _hide();
      })
      .fail(function(error) {
        _hide();
      }); 
  }


  function reject_product( id, status ) {

    console.log('sdfsd'+id);

    if( !id || !status )
      return;

    console.log('iuioui');

    $('input[name="product_id"]', 'form#productRejectForm').val(id);
    $('#productRejectModal').modal({
      show: true,
      backdrop: 'static',
      keyboard: false
    });
  }

  $('.data-question-mark').mouseover(function(event) {
    $('.data-popup').each(function(index, el) {
      $(this).css('display', 'none');
    });
    $(this).siblings('.data-popup').css('display', 'block');
  });
  /*$('.data-question-mark').mouseout(function(event) {
    $('.data-popup').css('display', 'none');
  });*/

  $('body').on('click', '.close-popup', function(event) {
    event.preventDefault();
    $(this).parent('.data-popup').css('display', 'none');
  });

  $('body').on('click', '.message-popup-box', function(event) {
    event.preventDefault();
    $('#messageBoxModal').modal({
      show: true,
      backdrop: 'static',
      keyboard: false
    });
  });

  $('body').on('submit', 'form#productRejectForm', function(event) {
    event.preventDefault();
    var id = $('input[name="product_id"]', this).val();
    var remark = $('textarea[name="remark"]', this).val();
    var status = 'reject';

    if( !id )
      return;

    _show();

    $.ajax({
      url: base_url + '/product/update/status',
      type: 'POST',
      data: {id:id, status:status, remark:remark},
    })
    .done(function(data) {
      if( data.message == 'success' )
        location.reload();

      _hide();
    })
    .fail(function(error) {
      _hide();
    });
  });

  


  var states = $('#states');
  var state_id = $('option:selected', states).val();
  var cities = $('#cities');
  var city_id = $('option:selected', cities).val();
  var countries = $('#countries');
  var country_id = $('option:selected', countries).val();

  function get_state(country_id) {
    _show();
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
          states.children('option').remove();
          $(html).appendTo(states)
      }
      _hide();
    }).fail(function(error) {
      _hide();
    }).always(function() {})
  }

  function get_cities(state_id) {
    _show();
    $.ajax({
      url: base_url + '/get/city/' + state_id,
      type: 'GET'
    }).done(function(result) {
      html = '<option value="">Select</option>';
      if (result.cities) {
          $.each(result.cities, function(index, val) {
            if( city_id == this.id )
              html += '<option selected value="' + this.id + '">' + this.name + '</option>'
            else
              html += '<option value="' + this.id + '">' + this.name + '</option>'
          });
          cities.children('option').remove();
          $(html).appendTo(cities)
      }
      _hide();
    }).fail(function(error) {
      _hide();
    }).always(function() {})
  }

  $('body').on('change', '#countries', function(event) {
    event.preventDefault();
    var country_id = $('option:selected', this).val();
    if( country_id ) {
      get_state( country_id );
    }
  });

  if( country_id ) {
    get_state( country_id );
  }

  if( state_id ) {
    get_cities( state_id );
  }

  $('body').on('change', '#states', function(event) {
    event.preventDefault();
    var state_id = $('option:selected', this).val();
    if( state_id ) {
      get_cities( state_id );
    }
  });

  $('body').on('focusout', 'input#reference', function(event) {
    event.preventDefault();
    var u = $(this).val();
    var $this = $(this);
    
    if( !u )
      return;

    console.log('sdfsgf');

    _show();
    check_username( u, $this );
  });
  var side;
  $('body').on('change', 'input.tree-side', function(event) {
    event.preventDefault();
    side = $(this).val();
    var u = $('input#reference');
    check_username( u.val(), $('input#reference') );
  });

  check_username = function( u, $this ) {
    $this.siblings('span').remove();
    var error = true;
    $.ajax({
      url: base_url + '/check/username',
      type: 'POST',
      async: false,
      data: {username: u, side: side},
    })
    .done(function(data) {
      console.log(data);
      if( data.status === 'failed' ) {
        _error(data.message, $this);
        error = false;
        return false;
      }
      else {
        $('<span class="text-success">'+data.name+'</span>').insertAfter($this);
        error = true;
        return true;
      }
      _hide();
    })
    .fail(function(error) {
      console.log(error.responseText);
      error = false;
      return false;
      _hide();
    })
    .always(function() {
      _hide();
    });

    return error;
  }


  $('body').on('focusout', '.epin-creation-form input[name="epins"]', function(event) {
    event.preventDefault();
    var epin = $(this).val();
    $(this).siblings('._error').remove();

    if( !validate_epin( epin ) )
      return;

    var package = $('input[name="package"]').attr('data-value');
    var total = package *  epin;
    $('input[name="amount"]').val(total);
  });

  function validate_epin( epin ) {
    var re = /[^0-9]/g;
    $erplace = $('input[name="epins"]');
    if( epin == '' ) {
      _error('Epin is required *', $erplace);
      $('input[name="amount"]').val('');
      return false;
    }
    if( epin == 0 ) {
      _error('Epin is required *', $erplace);
      $('input[name="amount"]').val('');
      return false;
    }
    if( !jQuery.isNumeric(epin) ) {
      _error('Epin must be valid!', $erplace);
      $('input[name="amount"]').val('');
      return false;
    }
    if( re.test( epin ) ) {
      _error('Epin must be valid!', $erplace);
      $('input[name="amount"]').val('');
      return false;
    }

    return true;
  }


  $('body').on('focusout', 'input#epin_id', function(event) {
    event.preventDefault();
    var epin_id = $(this).val();
    var $this = $(this);
    $(this).siblings('._error').remove();
    if( !epin_id )
      return;

    _show();

    check_epin( epin_id, $this );
    
  });


  check_epin = function( epin_id, $this ) {
    var error = true;
    $.ajax({
      url: base_url + '/check/epin',
      type: 'POST',
      async: false,
      data: {epin_id: epin_id},
    })
    .done(function(data) {
      console.log(data);
      if( data.auth === 'failed' ) {
        location.reload();
      }
      if( data.validation === 'failed' ) {
        _error(data.message, $this);
        error = false;
        return false;
      }
      else
        error = true;
        return true;

      _hide();
    })
    .fail(function(error) {
      console.log(error.responseText);
      error = false;
      return false;
      _hide();
    })
    .always(function() {
      _hide();
    });

    return error;
  }


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
          url: base_url + '/store/document',
          type: 'POST',
          data: fd,
          contentType: false,
          processData: false,
      })
      .done(function(data) {
        console.log(data);
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
        console.log(error.responseText);
      })
      .always(function() {
        console.log("complete");
      });
  });


  $('body').on('change', '#table-action', function(event) {
    event.preventDefault();
    var url = $('option:selected', this).attr('data-url');
    console.log(url);
    var v = $('option:selected', this).val();
    if( v != 'view' && v != 'view-member' ) {
      if( confirm('Are you sure?') ) {
        window.location = url;
      }
    }
    else
      window.location = url;

  });


    $('body').on('focusout', '.epin-creation-form input[name="epins"]', function(event) {
    event.preventDefault();
    var epin = $(this).val();
    $(this).siblings('._error').remove();

    if( !validate_epin( epin ) )
      return;

    var package = $('input[name="package"]').attr('data-value');
    var total = package *  epin;
    $('input[name="amount"]').val(total);
  });

  function validate_epin( epin ) {
    var re = /[^0-9]/g;
    $erplace = $('input[name="epins"]');
    if( epin == '' ) {
      _error('Epin is required *', $erplace);
      $('input[name="amount"]').val('');
      return false;
    }
    if( epin == 0 ) {
      _error('Epin is required *', $erplace);
      $('input[name="amount"]').val('');
      return false;
    }
    if( !jQuery.isNumeric(epin) ) {
      _error('Epin must be valid!', $erplace);
      $('input[name="amount"]').val('');
      return false;
    }
    if( re.test( epin ) ) {
      _error('Epin must be valid!', $erplace);
      $('input[name="amount"]').val('');
      return false;
    }

    return true;
  }


  $('body').on('change', 'select.payment-mode', function(event) {
    event.preventDefault();
    var mode = $('option:selected', this).val();
    $('.otherfields').html('');
    if( mode === 'neft' || mode === 'imps' || mode === 'netbanking' ) {
      var html = '<div class="col-lg-4 col-md-4 col-xs-4 form-group">';
      html += '<label>Upload screenshot of your transaction *</label>';
      html += '<input type="file" name="image" class="form-control" required>';
      html += '</div>';

      $(html).appendTo('.otherfields') 
    }
    else {
      $('.otherfields').html('');
    }
  });

  $('body').on('click', '#acceptPayoutRequest', function(event) {
    event.preventDefault();
    $.ajax({
      url: $(this).attr('data-url'),
      type: 'POST',
      data: {id: $(this).attr('data-id'), status:$(this).attr('data-status')}
    })
    .done(function(result) {
      console.log(result);
      location.reload();
    })
    .fail(function(error) {
      console.log(error);
    });
    
  });

  $('body').on('click', '#rejectPayoutBtn', function(event) {
    event.preventDefault();
    var url = $(this).attr('data-url');
    var id = $(this).attr('data-id');
    $('#rejectPayoutRequest input[name="id"]').val(id);
    $('#rejectPayoutRequest').attr('action', url);
    $('#rejectPayoutModal').modal('show');
  });

  $('body').on('submit', '#rejectPayoutRequest', function(event) {
    event.preventDefault();
    /* Act on the event */
     $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: $(this).serializeArray()
    })
    .done(function(result) {
      console.log(result);
      location.reload();
    })
    .fail(function(error) {
      console.log(error);
    });
  });

  $('body').on('click', '.btn-reject-doc', function(event) {
    event.preventDefault();
    console.log('sdfsdfg');
    var user_id = $(this).attr('data-user-id');
    var doc_id = $(this).attr('data-id');
    $('input[name="doc_id"]', 'form#docRejectForm').val( doc_id );
    $('input[name="user_id"]', 'form#docRejectForm').val( user_id );
    $('#docRejectModal').modal({
      show: true,
      backdrop: 'static',
      keyboard: false
    });
  });

  $('body').on('click', '.btn-update-status', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    if( !id )
      return;

    $('#complainStatusActionForm input[name="complain_id"]').val(id);
    $('#statusBoxModal').modal({
      show: true,
      backdrop: 'static',
    })
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
          url: base_url + '/store/document',
          type: 'POST',
          data: fd,
          contentType: false,
          processData: false,
      })
      .done(function(data) {
        console.log(data);
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
        console.log(error.responseText);
      })
      .always(function() {
        console.log("complete");
      });

      



  });





  function ucfirst(str,force = true) {
    str=force ? str.toLowerCase() : str;
    return str.replace(/(\b)([a-zA-Z])/,
             function(firstLetter){
                return   firstLetter.toUpperCase();
             });
  }

  function ucwords(str,force = true) {
    str = force ? str.toLowerCase() : str;  
    return str.replace(/(\b)([a-zA-Z])/g,
             function(firstLetter){
                return   firstLetter.toUpperCase();
             });
  }



  function _show() {
    $('.spinner-loader').css('display', 'block');
  }
  function _hide() {
    $('.spinner-loader').css('display', 'none');
  }

  function _error( text, selector ) {
    $('<span class="_error text-warning">'+text+'</span>').insertAfter(selector);
  }

});