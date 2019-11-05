<?php
Route::get('/', 'Update\HomeController@getIndex');

Route::post('register', 'Update\RegisterController@postRegister');

Route::get('user/verify-account/{code}', 'Update\RegisterController@getVerify');

Route::get('profile', 'Update\UserController@getProfile');

Route::get('logout', 'Update\UserController@getLogout');

Route::get('update-profile', 'Update\UserController@getUpdateProfile');

Route::get('post', 'Update\UserController@getPost');

Route::post('login', 'Update\UserController@postLogin');

Route::get('category/{name}', 'Update\ProductController@getProductByCat');

Route::get('store/{name}', 'Update\UserController@getStore');

Route::get('detail/{id}', 'Update\ProductController@getDetail');

Route::get('filter', 'Update\ProductController@getFilter');

Route::post('create-ads', 'Update\UserController@postCreatePost');

Route::get('product/user/delete/{id}', 'PostController@getProductUserById');

Route::get('update/product/{id}', 'Update\UserController@getUpdateProduct');

Route::get('delete/product/image', 'Update\ProductController@getDeleteProImage');

Route::post('update-ads', 'Update\UserController@postUpdateProduct');

Route::post('update-profile', 'Update\UserController@postUpdateProfile');

Route::post('forgot', 'Update\UserController@postForgot');

Route::get('reset-password/{code}', 'Update\UserController@getReset');

Route::get('reset/{code}', 'Update\UserController@getReset');

Route::post('reset', 'Update\UserController@postReset');

Route::get('about', 'Update\AboutControllerr@getAbout');

Route::post('about', 'Update\AboutControllerr@postAbout');