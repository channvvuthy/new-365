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