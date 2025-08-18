<?php
use App\Http\Controllers\Mailer;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




/*Route::get('/', function () { 
    return view('welcome');
});*/

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


// Route::get('/send-email', function () {
// 	// dd("Inside the send-mail route");
//     $mailer = new Mailer();
//     $arr = [
//         'to' => 'techdostdev@gmail.com',
//         'name' => 'Test',
//         'subject' => 'Testing',
//         'message' => 'Message test'
//     ];
//     // dd($arr);
//     return $mailer->sendMail($arr) ? 'Email sent successfully' : 'Failed to send email';
// });

Route::get('/clear-cache', function () {
	$exitCode = Artisan::call('cache:clear');
	$exitCode = Artisan::call('config:cache');
	$exitCode = Artisan::call('optimize:clear');
	return 'DONE'; //Return anything

});



Route::get('test/image', function () {

	// echo public_path('assets/images');

	/*$img = Image::cache(function($image) {
				    $image->make('public/assets/products/images/m-18a3089j3003i-united-colors-of-benetton-original-imaf9hcag3zaspvy-jpeg-5hPaBtbp-jpeg-MEPTYd8a.jpeg')->resize(250, 300);
				});

	return Response::make($img, 200, ['Content-Type' => 'image/jpeg']);*/
});


Route::get('bm/-/admin', 'Admin\AdminController@index')->name('admin');
Route::post('bm/-/admin/login', 'Admin\AdminController@login')->name('admin.login');


Route::namespace('Admin')->prefix('bm/-/admin')->middleware('admin')->group(function () {


	Route::get('upload', 'AdminController@upload');
	Route::get('home', 'AdminController@home')->name('admin.home');
	Route::get('logout', 'AdminController@logout')->name('admin.logout');

	Route::get('user/create', 'AdminController@user_create')->name('admin.user.create');
	Route::post('user/store', 'AdminController@user_store')->name('admin.user.store');
	Route::get('user/edit/{id}', 'AdminController@edit_user')->name('admin.user.edit');
	Route::post('user/update/{id}', 'AdminController@update_user')->name('admin.user.update');
	Route::post('user/delete/{id}', 'AdminController@delete_user')->name('admin.user.delete');

	// Role managemanet

	Route::post('user/role/permission/create', 'AdminController@user_role_permission_create')->name('admin.user.role.permission.create');

	Route::get('users', 'AdminController@users')->name('admin.users');
	Route::get('user/view/{id}', 'AdminController@view_user')->name('admin.user.view');



	Route::get('seller/create', 'SellerController@create')->name('admin.seller.create');
	Route::get('sellers', 'SellerController@index')->name('admin.sellers');
	Route::post('seller', 'SellerController@store')->name('admin.seller.store');
	Route::get('seller/edit/{id}', 'SellerController@edit')->name('admin.seller.edit');
	Route::patch('seller/update/{id}', 'SellerController@update')->name('admin.seller.update');

	Route::get('seller/view/{id}', 'SellerController@show')->name('admin.seller.show');
	Route::patch('seller/status/{id}', 'SellerController@update_status')->name('admin.seller.status');

	Route::get('seller/products/{id}', 'SellerController@products')->name('admin.seller.products');

	Route::get('setup/{uid}', 'SellerController@setup')->name('admin.seller.setup');
	Route::post('setup', 'SellerController@store_setup')->name('admin.seller.setup.store');

	Route::post('message', 'MessageController@store')->name('admin.message');
	Route::get('seller/message/{id}', 'MessageController@seller_message')->name('admin.seller.message');

	Route::post('store/document', 'SellerController@store_document');
	Route::post('seller/document', 'SellerController@document')->name('admin.seller.document');
	Route::get('seller/document/view/{id}', 'SellerController@view_document')->name('admin.seller.view.document');

	Route::post('seller/document/status', 'SellerController@document_status')->name('admin.seller.document.status');

	Route::post('update/password', 'AdminController@update_password')->name('admin.update.password');

	Route::resource('category', 'CategoryController');
    Route::resource('redirects', 'RedirectController');
	Route::resource('product-mrps', 'ProductMrpController');
	Route::resource('post-categories', 'PostCategoryController');

	 
	Route::get('product-mrps/import', 'ProductMrpController@importForm')->name('product-mrps.import.form');
	Route::post('product-mrps/import', 'ProductMrpController@import')->name('product-mrps.import');
	Route::get('download-sample',  'ProductMrpController@download')->name('download.sample');


	Route::get('/receipt/{id}', 'ReceiptController@printReceipt')->name('receipt.print');
    Route::post('/receipts', 'ReceiptController@printReceipts')->name('receipts.print');


	Route::get('invoices', 'InvoiceController@index')->name('admin.invoice');
	Route::post('invoice/store', 'InvoiceController@store')->name('admin.invoice.store');
	Route::get('invoice/create/{id}', 'InvoiceController@create')->name('admin.invoice.create');
	Route::get('invoice/view/{id}', 'InvoiceController@show')->name('admin.invoice.view');
	Route::get('invoice/download/{id}', 'InvoiceController@download')->name('admin.invoice.download');

	Route::post('invoice/send', 'InvoiceController@send')->name('admin.invoice.send');
	Route::get('invoice/print/{id}', 'InvoiceController@print')->name('admin.invoice.print');


	Route::get('complains', 'ComplainController@index')->name('admin.complains');
	Route::get('complain/view/{id}', 'ComplainController@show')->name('admin.complain.view');
	Route::post('complain/update/status', 'ComplainController@update_status')->name('admin.complain.update.status');

	Route::resource('brand', 'BrandController');

	Route::post('remove/sucode/color', 'ProductController@remove_sucode_color');

	Route::resource('product', 'ProductController');
	Route::patch('product/update/{id}', 'ProductController@update')->name('product.update');
	Route::post('product/delete', 'ProductController@delete');
	// Route::post('product/product-delete', 'ProductController@product_delete');
	Route::post('abcd', 'ProductController@delete_mproduct');

	Route::post('product/update/status', 'ProductController@update_status')->name('admin.product.status');
	Route::resource('post', 'PostController');
	Route::resource('page', 'PageController');
	Route::resource('media', 'MediaController');
	Route::resource('menu', 'MenuController');
	Route::resource('coupon', 'CouponController');
	Route::resource('slide', 'SliderController');

	Route::get('set/pincode', 'SliderController@pincode')->name('set.pincode');
	Route::post('pincode/upload', 'SliderController@upload_pincode')->name('upload.pincode');

	Route::resource('ourclient', 'OurClientController');


	Route::post('coupon/status', 'CouponController@status')->name('coupon.status');

	Route::get('orders', 'OrderController@index')->name('orders');
	Route::post('order/update/status', 'OrderController@update_status')->name('admin.order.status');
	Route::get('order/{name}', 'OrderController@orders')->name('orders.status');
	Route::post('order/delete/{id}', 'OrderController@delete')->name('order.delete');

	Route::get('order/show/{id}', 'OrderController@show')->name('order.show');
	Route::get('reviews', 'ReviewController@index')->name('admin.reviews');
	Route::delete('review/delete/{id}', 'ReviewController@delete')->name('admin.review.delete');

	Route::get('review/product/{product_id}', 'ReviewController@product_review')->name('admin.product.review');

	Route::get('payment/request/{id}', 'AdminController@paymentRequestMail')->name('payment.request.mail');

	// Route::get('menu/{name}', 'MenuController@index')->name('menu.index');
	// Route::post('menu/store', 'MenuController@store')->name('menu.store');

	Route::get('setting/{name}', 'MetaController@index')->name('setting.index');
	Route::post('setting/store', 'MetaController@store')->name('setting.store');

	Route::get('get/state/{id}', 'MLM\MainController@get_state');
	Route::get('get/city/{id}', 'MLM\MainController@get_city');

	Route::get('subscribers', 'SubscriberController@index')->name('admin.subscribers');

	Route::namespace('MLM')->prefix('mlm')->group(function () {
		Route::get('/', 'MainController@index')->name('mlm');
		Route::post('check/username', 'MainController@check_username');
		Route::get('epins', 'EpinController@index')->name('mlm.epins');
		Route::get('epin/requested', 'EpinController@requested')->name('mlm.epin.requested');
		Route::get('epin/create', 'EpinController@create')->name('mlm.epin.create');
		Route::post('epin/store', 'EpinController@store')->name('mlm.epin.store');
		Route::get('epin/accept/{id}', 'EpinController@accept')->name('mlm.epin.accept');
		Route::get('epin/reject/{id}', 'EpinController@reject')->name('mlm.epin.reject');
		Route::get('epin/view/{id}', 'EpinController@view')->name('mlm.epin.view');
		Route::get('epin/edit/{id}', 'EpinController@edit')->name('mlm.epin.edit');
		Route::patch('epin/update/{id}', 'EpinController@update')->name('mlm.epin.update');
		Route::get('epin/delete/{id}', 'EpinController@delete')->name('mlm.epin.delete');
		Route::post('check/epin', 'EpinController@check');

		Route::get('members/direct', 'MemberController@direct')->name('mlm.members.direct');
		Route::get('members/reference', 'MemberController@reference')->name('mlm.members.reference');
		Route::get('member/{name}', 'MemberController@create')->name('mlm.member.create');
		Route::post('member/store', 'MemberController@store')->name('mlm.member.store');
		Route::get('members', 'MemberController@index')->name('mlm.members');
		Route::get('member/view/{id}', 'MemberController@view')->name('mlm.member.view');
		Route::get('message/{id}', 'MemberController@messages')->name('admin.mlm.message');

		Route::get('member/document/view/{id}', 'MemberController@view_document')->name('mlm.member.view.document');

		Route::get('member/edit/{id}', 'MemberController@edit')->name('mlm.member.edit');
		Route::delete('member/destroy/{id}', 'MemberController@destroy')->name('mlm.member.delete');
		Route::patch('member/update/{id}', 'MemberController@update')->name('mlm.member.update');
		Route::patch('member/status/{id}', 'MemberController@status')->name('mlm.member.status');

		Route::post('member/document', 'MemberController@document')->name('mlm.member.document');
		Route::post('store/document', 'MemberController@store_document');

		Route::get('get/state/{id}', 'MainController@get_state');
		Route::get('get/city/{id}', 'MainController@get_city');


		Route::get('wallet', 'WalletController@index')->name('mlm.wallet');
		Route::get('wallet/view/{id}', 'WalletController@show')->name('mlm.wallet.view');
		Route::get('wallet/payout/requests', 'WalletController@requested')->name('mlm.wallet.payout.requested');

		Route::post('wallet/update/status/{id}', 'WalletController@update_status')->name('mlm.wallet.status');

		Route::get('salary', 'SalaryController@index')->name('mlm.salary');
		Route::get('salary/upcoming', 'SalaryController@upcoming')->name('mlm.salary.upcoming');
		Route::get('salary/history', 'SalaryController@history')->name('mlm.salary.history');

		Route::get('cashbacks', 'SalaryController@cashbacks')->name('mlm.cashbacks');
		Route::get('distributed/coupons', 'SalaryController@coupons')->name('mlm.coupons');
	});
});


Route::namespace('Seller')->prefix('seller')->group(function () {
	Route::get('', 'SellerController@index')->name('seller');
	Route::post('login', 'SellerController@login')->name('seller.login');
	Route::post('logout', 'SellerController@logout')->name('seller.logout');
	Route::get('register', 'SellerController@register')->name('seller.register');
	Route::post('register', 'SellerController@signup')->name('seller.signup');
	Route::get('setup/{uid}', 'SellerController@setup')->name('seller.setup');
	Route::post('setup', 'SellerController@store_setup')->name('seller.setup.store');
	Route::post('store/document', 'SellerController@store_document');
	Route::post('document', 'SellerController@document')->name('seller.document');
	Route::get('setup/success', 'SellerController@success')->name('seller.success');

	Route::get('home', 'SellerController@home')->name('seller.home');

	Route::get('products', 'ProductController@index')->name('seller.products');
	Route::get('product/create', 'ProductController@create')->name('seller.product.create');
	Route::post('product', 'ProductController@store')->name('seller.product.store');
	Route::get('product/edit/{id}', 'ProductController@edit')->name('seller.product.edit');
	Route::patch('product/update/{id}', 'ProductController@update')->name('seller.product.update');

	Route::match(['get', 'post'], 'edit-profile', 'SellerController@edit_profile')->name('seller.edit');
	Route::match(['get', 'post'], 'change-password', 'SellerController@change_password')->name('seller.change.password');
	Route::match(['get', 'post'], 'contact', 'SellerController@contact')->name('seller.contact');
	Route::match(['get', 'post'], 'bank', 'SellerController@bank')->name('seller.bank');
	Route::get('documents', 'SellerController@update_document')->name('seller.documents');

	Route::get('messages', 'SellerController@message')->name('seller.messages');
	Route::post('message/set/read', 'SellerController@set_read');


	Route::get('orders', 'OrderController@index')->name('seller.orders');
	Route::get('order/view/{id}', 'OrderController@show')->name('seller.order.view');
});



Route::namespace('User')->prefix('-/user')->group(function () {

	Route::get('', 'UserController@index')->name('user.home');
	Route::match(['get', 'post'], 'edit-profile', 'UserController@edit_profile')->name('user.edit');
	Route::match(['get', 'post'], 'change-password', 'UserController@change_password')->name('user.change.password');
	Route::match(['get', 'post'], 'contact', 'UserController@contact')->name('user.contact');
	Route::match(['get', 'post'], 'bank', 'UserController@bank')->name('user.bank');
	Route::get('documents', 'UserController@document')->name('user.documents');

	Route::post('store/avtar', 'UserController@store_avtar');
	Route::post('store/document', 'UserController@store_document');


	Route::post('0/epin', 'EpinController@check');


	Route::post('logout', 'UserController@logout')->name('user.logout');
	Route::get('member/profiles', 'MemberController@profiles')->name('member.profiles');
	Route::get('member/{name}', 'MemberController@create')->name('member.create');
	Route::post('member/store', 'MemberController@store')->name('member.store');
	Route::get('my/network', 'MemberController@index')->name('member.network');
	Route::get('network/tree', 'MemberController@tree')->name('network.tree');
	Route::get('member/view/{id}', 'MemberController@view')->name('member.view');
	Route::get('member/view/users/{username}', 'MemberController@users')->name('member.users');
	Route::get('member/edit/{id}', 'MemberController@edit')->name('member.edit');
	Route::patch('member/update/{id}', 'MemberController@update')->name('member.update');


	Route::get('messages', 'UserController@messages')->name('user.messages');

	Route::get('epins', 'EpinController@index')->name('epins');
	Route::get('epin/create', 'EpinController@create')->name('epin.create');
	Route::post('epin/store', 'EpinController@store')->name('epin.store');

	Route::post('check/username', 'UserController@check_username');

	Route::get('points', 'WalletController@index')->name('user.point');
	Route::get('points/transfer/request', 'WalletController@transfer')->name('user.transfer');
	Route::post('points/transfer', 'WalletController@transfer_store')->name('user.transfer.store');
	Route::get('points/payout/request', 'WalletController@payout_request')->name('user.payout.request');

	Route::get('my/orders', 'OrderController@index')->name('user.my.orders');
	Route::get('my/order/view/{id}', 'OrderController@view')->name('user.my.order.view');



	Route::get('coupon/history', 'CouponController@index')->name('user.coupon.history');

	Route::get('member/level/{name}', 'MemberController@level')->name('user.member.level');
});


Route::get('order/request/payment/{oid}', 'OrderController@orderPaymentRequest')->name('order.payment.request');











Route::post('paytm/payment/status', 'PaytmController@paymentCallback')->name('status');


/*Route::prefix('0/-/reseller')->group( function() {


	Route::get('/', 'seller\sellerController@index')->name('seller');
	Route::post('login', 'seller/sellerController@login')->name('seller.login');
	Route::get('home', 'AdminController@home')->name('admin.home');
	Route::get('logout', 'AdminController@logout')->name('admin.logout');

	Route::post('update/password', 'AdminController@update_password')->name('admin.update.password');

	Route::resource('category', 'CategoryController');

	Route::resource('product', 'ProductController');
	Route::resource('post', 'PostController');
	Route::resource('page', 'PageController');
	Route::resource('media', 'MediaController');
	Route::resource('menu', 'MenuController');
	Route::resource('coupon', 'CouponController');
	Route::resource('slide', 'SliderController');
	Route::post('coupon/status', 'CouponController@status')->name('coupon.status');

	Route::get('orders', 'OrderController@orders')->name('orders');

	Route::get('order/show/{id}', 'OrderController@show')->name('order.show');


	// Route::get('menu/{name}', 'MenuController@index')->name('menu.index');
	// Route::post('menu/store', 'MenuController@store')->name('menu.store');

	Route::get('setting/{name}', 'MetaController@index')->name('setting.index');
	Route::post('setting/store', 'MetaController@store')->name('setting.store');

});*/

Route::prefix('api/-/')->group(function () {

	Route::post('attribute/price', 'Api\VariationController@attribute_price');
});


Route::get('500', function () {
	abort(500);
});

Route::post('order/store', 'OrderController@store')->name('order.store');

//Auth::routes(); 

Route::post('check/auth/user/status', 'Auth\AuthController@check_auth_user_status');





Route::get('login', 'Auth\AuthController@login')->name('login');
Route::get('register', 'Auth\AuthController@register')->name('register');
Route::post('logout', 'Auth\AuthController@logout')->name('logout');
Route::post('login', 'Auth\AuthController@doLogin')->name('user.login');
Route::post('register', 'Auth\AuthController@doRegister')->name('user.register');
Route::get('password/request', 'Auth\AuthController@password_request')->name('password.request');

Route::post('request/mail', 'Auth\AuthController@request_mail')->name('request.mail');
Route::get('password/reset/{name}', 'Auth\AuthController@reset_password')->name('user.password.reset');
Route::post('password/update', 'Auth\AuthController@update_password')->name('user.password.update');
Route::get('reset/password/success', 'Auth\AuthController@password_reset_success')->name('password.reset.success');



// Route::get('/', function () {
// 	echo "<center style='margin-top:20%;'><h1>we are working</h1></center>";
// });

Route::get('/', 'MainController@index');

Route::get('get-product/color-variation', 'MainController@get_product_color_variation');       //mt


Route::any('payment', 'CCAvenueController@index')->name('payment');
Route::get('payment/response/{name}/{id}/{order_id}', 'CCAvenueController@response')->name('payment.response');
Route::get('payment/error', 'CCAvenueController@error')->name('payment.error');
Route::any('response/ccresponse', 'CCAvenueController@ccresponse')->name('payment.ccresponse');

Route::post('payment/success/dsfa/fdsaf/gsdaf/fdsaf', function () {
	// echo var_dump($_POST);
})->name('payment.abc');

Route::any('payment/success', 'PaymentController@success')->name('payment.success');
Route::any('payment/cancel', 'PaymentController@cancel')->name('payment.cancel');
Route::get('payment/status/{id}', 'PaymentController@status')->name('payment.status');





Route::get('check/email/testing/new/demo', 'OrderController@emailtestinghere');







Route::get('pincode', 'MainController@upload');
//Route::get('test', 'MainController@test');

Route::get('load/data', 'MainController@load');
Route::get('load/more', 'MainController@more');

Route::post('comment', 'CommentController@store')->name('comment.store');
Route::post('contact', 'MainController@contact')->name('contact');
Route::post('subscribe', 'MainController@subscribe')->name('subscribe');

Route::post('check/availability', 'MainController@check_availability')->name('availability');
Route::get('get/state/{id}', 'MainController@get_state');
Route::get('get/city/{id}', 'MainController@get_city');
Route::get('change-password', 'UserController@create')->name('change.password');
Route::post('update/password', 'UserController@update')->name('update.password');






Route::get('order/upload/files/{id}', 'OrderController@upload_files')->name('product.order.files');
Route::post('order/upload/files', 'OrderController@store_file')->name('product.order.files.upload');

Route::get('my/orders', 'OrderController@index')->name('order');

Route::get('my/profile', 'OrderController@my_profile')->name('customer.profile');
Route::post('customer/profile/update', 'OrderController@my_profile_update')->name('customer.profile.update');

Route::get('my/profile/password', 'OrderController@my_profile_password')->name('customer.profile.change.password');
Route::post('customer/profile/update/password', 'OrderController@my_profile_update_password')->name('customer.profile.update.passoword');


Route::get('order/success/{id}', 'OrderController@success')->name('order.success');




Route::get('checkout', 'CheckoutController@index')->name('checkout');



Route::get('wishlist', 'CookieController@index');
Route::get('blog/{fname}', 'MainController@view_blog')->name('view.blog');
Route::get('cart/view', 'CartController@index')->name('cart');

Route::get('offers/hot-deals', 'ProductController@hotdeals')->name('hotdeals');

Route::get('new-arrivals', 'ProductController@new')->name('product.new');
Route::get('featured-collection', 'ProductController@featured')->name('product.featured');

Route::get('{fname}', 'MainController@action')->name('product.category');
Route::get('{fname}/{lname}', 'ProductController@index')->name('category.product');
Route::get('{fname}/{lname}/{id}', 'ProductController@view')->name('product.view');

Route::post('add/wishlist', 'CookieController@store');
Route::post('add/wishlist', 'CookieController@store');
Route::post('cart/store', 'CartController@store');
Route::post('cart/store/buynow', 'CartController@store_buynow');
Route::post('cart/get', 'CartController@get');
Route::post('cart/remove/product', 'CartController@destroy')->name('cart.destroy');



Route::patch('cart/update', 'CartController@update')->name('cart.update');


Route::post('order/cancel', 'OrderController@cancel')->name('order.cancel');



Route::post('review', 'ReviewController@store')->name('review.store');

Route::post('validate/code', 'MainController@validate_code');


Route::get('checkout/test', 'CheckoutController@test')->name('checkout.test');
Route::post('test', 'TestController@store')->name('test');


Route::post('order/search', 'ComplainController@search_order')->name('order.search');
Route::post('complain/send', 'ComplainController@store')->name('order.return.store');

Route::get('order/complain/success/{id}', 'ComplainController@show')->name('order.complain.success');








//Route::get('/home', 'HomeController@index')->name('home');
