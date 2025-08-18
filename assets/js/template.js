$(document).ready(function() {
    var base_url = $('base').attr('href');
    var _token = $('meta[name="_token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': _token
        }
    }); /*$(".subs-overlay").delay(10000).fadeIn();*/
    
   
$('body').on('click','.show-all-category',function(event){
    event.preventDefault();
    $('.show-all-category .dropdown-show').css('display', 'block');
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

 

});