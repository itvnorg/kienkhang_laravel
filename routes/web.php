<?php

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

Route::get('/img/{path}', array(
	'as' => 'img.resize',
	'uses' => 'ImageController@show'
))->where('path', '.*');

Route::get('/img-news/{path}', array(
	'as' => 'img.news.resize',
	'uses' => 'ImageController@news_show'
))->where('path', '.*');

Route::get('/', array(
	'as' => 'home', 
	'uses' => 'Portal\BaseController@getHome'
));

//		-------=== BEGIN: Auth routes ===-------
Route::group(['prefix' => '/auth'], function(){
	Route::get('/login', array(
		'as' => 'login.view', 
		'uses' => 'Auth\LoginController@getLoginView'
	));

	Route::post('/login', array(
		'as' => 'login.submit', 
		'uses' => 'Auth\LoginController@login'
	));

	Route::get('/logout', array(
		'as' => 'logout', 
		'uses' => 'Auth\LoginController@logout'
	));
});

Route::group(['prefix' => '/password'], function(){

	Route::get('/forgot', array(
		'as' => 'password.forgot.view',
		'uses' => 'Auth\ForgotPasswordController@getForgotPasswordView'
	));

	Route::post('/forgot', array(
		'as' => 'password.forgot.submit',
		'uses' => 'Auth\ForgotPasswordController@forgotPassword'
	));

	Route::get('/{id}/{code}', array(
		'as' => 'password.update.view',
		'uses' => 'Auth\ForgotPasswordController@getUpdatePasswordView'
	));

	Route::post('/update', array(
		'as' => 'password.update.submit',
		'uses' => 'Auth\ForgotPasswordController@updatePassword'
	));

});
//		-------=== END: Auth routes ===-------

// 		-------=== BEGIN: Portal routes ===-------
Route::group(['prefix' => ''], function () {

	Route::get('/tin-rao/{cat_url_rewrite}/{url_rewrite}', [
	    'as'   => 'portal.products.show',
	    'uses' => 'Portal\ProductController@show'
	]);

	Route::get('/danh-muc-tin-rao/{cat_url_rewrite}', [
	    'as'   => 'portal.product_categories.show',
	    'uses' => 'Portal\ProductCategoryController@show'
	]);

	Route::get('/tin/{cat_url_rewrite}/{url_rewrite}', [
	    'as'   => 'portal.news.show',
	    'uses' => 'Portal\NewsController@show'
	]);

	Route::get('/danh-muc-tin/{cat_url_rewrite}', [
	    'as'   => 'portal.news_categories.show',
	    'uses' => 'Portal\NewsCategoryController@show'
	]);

	Route::get('/trang/{url_rewrite}', [
	    'as'   => 'portal.pages.show',
	    'uses' => 'Portal\PageController@show'
	]);

	Route::get('/lien-he', [
	    'as'   => 'portal.pages.contact',
	    'uses' => 'Portal\PageController@contact'
	]);

	Route::any('/lien-he/gui', [
	    'as'   => 'portal.contact.send',
	    'uses' => 'Portal\ContactController@send'
	]);

	Route::get('/tim-kiem', [
	    'as'   => 'portal.search',
	    'uses' => 'Portal\ProductController@search'
	]);

});
// 		-------=== END: Portal routes ===-------

// 		-------=== BEGIN: Admin routes ===-------
Route::group(['prefix' => 'admin'], function () {

	// 		-------=== BEGIN: Admin Home routes ===-------
	Route::get('/', array(
		'as' => 'admin.home', 
		function(){
			return redirect()->route('admin.settings.index');
		}
	));
	// 		-------=== END: Admin Home routes ===-------

	// 		-------=== BEGIN: Admin System Settings routes ===-------
	Route::get('/settings', array(
		'as' => 'admin.settings.index',
		'uses' => 'Admin\SystemSettingsController@getSettings'
	));

	Route::put('/settings', array(
		'as' => 'admin.settings.update',
		'uses' => 'Admin\SystemSettingsController@updateSettings'
	));
	// 		-------=== END: Admin System Settings routes ===-------

	// 		-------=== BEGIN: Admin Profile routes ===-------
	Route::get('/update_profile', array(
		'as' => 'admin.profile.edit', 
		'uses' => 'Admin\UserController@getUpdateProfile'
	));

	Route::put('/update_profile', array(
		'as' => 'admin.profile.update', 
		'uses' => 'Admin\UserController@updateProfile'
	));
	// 		-------=== END: Admin Profile routes ===-------


	// 		-------=== BEGIN: Admin Role routes ===-------
	//---> Roles
	Route::resource('roles', 'Admin\RoleController', ['names' => [
		'index' => 'admin.roles.index',
		'create' => 'admin.roles.create',
		'store' => 'admin.roles.store',
		'show' => 'admin.roles.show',
		'edit' => 'admin.roles.edit',
		'update' => 'admin.roles.update',
		'destroy' => 'admin.roles.destroy'
	]]);

	Route::group(['prefix' => 'roles'], function (){
		Route::post('/delete', array(
			'as' => 'admin.roles.delete', 
			'uses' => 'Admin\RoleController@delete'
		));
	});
	// 		-------=== END: Admin Role routes ===-------

	// 		-------=== BEGIN: Admin Users routes ===-------
	Route::resource('users', 'Admin\UserController', ['names' => [
		'index' => 'admin.users.index',
		'create' => 'admin.users.create',
		'store' => 'admin.users.store',
		'show' => 'admin.users.show',
		'edit' => 'admin.users.edit',
		'update' => 'admin.users.update',
		'destroy' => 'admin.users.destroy'
	]]);

	Route::group(['prefix' => 'users'], function (){
		Route::post('/delete', array(
			'as' => 'admin.users.delete', 
			'uses' => 'Admin\UserController@delete'
		));
	});
	// 		-------=== END: Admin Users routes ===-------

	// 		-------=== BEGIN: Admin Products routes ===-------
	Route::resource('products', 'Admin\ProductController', ['names' => [
		'index' => 'admin.products.index',
		'create' => 'admin.products.create',
		'store' => 'admin.products.store',
		'show' => 'admin.products.show',
		'edit' => 'admin.products.edit',
		'update' => 'admin.products.update',
		'destroy' => 'admin.products.destroy'
	]]);

	Route::group(['prefix' => 'BEGIN'], function (){
		Route::post('/delete', array(
			'as' => 'admin.products.delete', 
			'uses' => 'Admin\ProductController@delete'
		));
	});
	// 		-------=== END: Admin Products routes ===-------

	// 		-------=== BEGIN: Admin Product Categories routes ===-------
	Route::resource('product-categories', 'Admin\ProductCategoryController', ['names' => [
		'index' => 'admin.product_categories.index',
		'create' => 'admin.product_categories.create',
		'store' => 'admin.product_categories.store',
		'show' => 'admin.product_categories.show',
		'edit' => 'admin.product_categories.edit',
		'update' => 'admin.product_categories.update',
		'destroy' => 'admin.product_categories.destroy'
	]]);

	Route::group(['prefix' => 'product-categories'], function (){
		Route::post('/delete', array(
			'as' => 'admin.product_categories.delete', 
			'uses' => 'Admin\ProductCategoryController@delete'
		));
	});
	// 		-------=== END: Admin Product Categories routes ===-------

	// 		-------=== BEGIN: Admin Province routes ===-------
	Route::resource('provinces', 'Admin\ProvinceController', ['names' => [
		'index' => 'admin.provinces.index',
		'create' => 'admin.provinces.create',
		'store' => 'admin.provinces.store',
		'show' => 'admin.provinces.show',
		'edit' => 'admin.provinces.edit',
		'update' => 'admin.provinces.update',
		'destroy' => 'admin.provinces.destroy'
	]]);

	Route::group(['prefix' => 'provinces'], function (){
		Route::post('/delete', array(
			'as' => 'admin.provinces.delete', 
			'uses' => 'Admin\ProvinceController@delete'
		));
	});
	// 		-------=== END: Admin Province routes ===-------

	// 		-------=== BEGIN: Admin District routes ===-------
	Route::resource('districts', 'Admin\DistrictController', ['names' => [
		'index' => 'admin.districts.index',
		'create' => 'admin.districts.create',
		'store' => 'admin.districts.store',
		'show' => 'admin.districts.show',
		'edit' => 'admin.districts.edit',
		'update' => 'admin.districts.update',
		'destroy' => 'admin.districts.destroy'
	]]);

	Route::group(['prefix' => 'districts'], function (){
		Route::post('/delete', array(
			'as' => 'admin.districts.delete', 
			'uses' => 'Admin\DistrictController@delete'
		));
	});
	// 		-------=== END: Admin District routes ===-------

	// 		-------=== BEGIN: Admin Ward routes ===-------
	Route::resource('wards', 'Admin\WardController', ['names' => [
		'index' => 'admin.wards.index',
		'create' => 'admin.wards.create',
		'store' => 'admin.wards.store',
		'show' => 'admin.wards.show',
		'edit' => 'admin.wards.edit',
		'update' => 'admin.wards.update',
		'destroy' => 'admin.wards.destroy'
	]]);

	Route::group(['prefix' => 'wards'], function (){
		Route::post('/delete', array(
			'as' => 'admin.wards.delete', 
			'uses' => 'Admin\WardController@delete'
		));
	});
	// 		-------=== END: Admin Ward routes ===-------

	// 		-------=== BEGIN: Admin Direction routes ===-------
	Route::resource('directions', 'Admin\DirectionController', ['names' => [
		'index' => 'admin.directions.index',
		'create' => 'admin.directions.create',
		'store' => 'admin.directions.store',
		'show' => 'admin.directions.show',
		'edit' => 'admin.directions.edit',
		'update' => 'admin.directions.update',
		'destroy' => 'admin.directions.destroy'
	]]);

	Route::group(['prefix' => 'directions'], function (){
		Route::post('/delete', array(
			'as' => 'admin.directions.delete', 
			'uses' => 'Admin\DirectionController@delete'
		));
	});
	// 		-------=== END: Admin Direction routes ===-------

	// 		-------=== BEGIN: Admin File Categories routes ===-------
	Route::resource('file-categories', 'Admin\FileCategoryController', ['names' => [
		'index' => 'admin.file_categories.index',
		'create' => 'admin.file_categories.create',
		'store' => 'admin.file_categories.store',
		'show' => 'admin.file_categories.show',
		'edit' => 'admin.file_categories.edit',
		'update' => 'admin.file_categories.update',
		'destroy' => 'admin.file_categories.destroy'
	]]);

	Route::group(['prefix' => 'file-categories'], function (){
		Route::post('/delete', array(
			'as' => 'admin.file_categories.delete', 
			'uses' => 'Admin\FileCategoryController@delete'
		));
	});
	// 		-------=== END: Admin File Categories routes ===-------

	// 		-------=== BEGIN: Admin Files routes ===-------
	Route::resource('files', 'Admin\FileController', ['names' => [
		'index' => 'admin.files.index',
		'create' => 'admin.files.create',
		'store' => 'admin.files.store',
		'show' => 'admin.files.show',
		'edit' => 'admin.files.edit',
		'update' => 'admin.files.update',
		'destroy' => 'admin.files.destroy'
	]]);

	Route::group(['prefix' => 'files'], function (){
		Route::post('/delete', array(
			'as' => 'admin.files.delete', 
			'uses' => 'Admin\FileController@delete'
		));
	});
	// 		-------=== END: Admin Files routes ===-------

	// 		-------=== BEGIN: Admin News routes ===-------
	Route::resource('news', 'Admin\NewsController', ['names' => [
		'index' => 'admin.news.index',
		'create' => 'admin.news.create',
		'store' => 'admin.news.store',
		'show' => 'admin.news.show',
		'edit' => 'admin.news.edit',
		'update' => 'admin.news.update',
		'destroy' => 'admin.news.destroy'
	]]);

	Route::group(['prefix' => 'news'], function (){
		Route::post('/delete', array(
			'as' => 'admin.news.delete', 
			'uses' => 'Admin\NewsController@delete'
		));
	});
	// 		-------=== END: Admin News routes ===-------

	// 		-------=== BEGIN: Admin News Categories routes ===-------
	Route::resource('news-categories', 'Admin\NewsCategoryController', ['names' => [
		'index' => 'admin.news_categories.index',
		'create' => 'admin.news_categories.create',
		'store' => 'admin.news_categories.store',
		'show' => 'admin.news_categories.show',
		'edit' => 'admin.news_categories.edit',
		'update' => 'admin.news_categories.update',
		'destroy' => 'admin.news_categories.destroy'
	]]);

	Route::group(['prefix' => 'news-categories'], function (){
		Route::post('/delete', array(
			'as' => 'admin.news_categories.delete', 
			'uses' => 'Admin\NewsCategoryController@delete'
		));
	});
	// 		-------=== END: Admin News Categories routes ===-------

	// 		-------=== BEGIN: Admin Pages routes ===-------
	Route::resource('pages', 'Admin\PageController', ['names' => [
		'index' => 'admin.pages.index',
		'create' => 'admin.pages.create',
		'store' => 'admin.pages.store',
		'show' => 'admin.pages.show',
		'edit' => 'admin.pages.edit',
		'update' => 'admin.pages.update',
		'destroy' => 'admin.pages.destroy'
	]]);

	Route::group(['prefix' => 'pages'], function (){
		Route::post('/delete', array(
			'as' => 'admin.pages.delete', 
			'uses' => 'Admin\PageController@delete'
		));
	});
	// 		-------=== END: Admin Pages routes ===-------

});
// 		-------=== END: Admin routes ===-------