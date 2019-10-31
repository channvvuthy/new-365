<?php
Route::get('/', 'Update\HomeController@getIndex');

Route::post('register', 'Update\RegisterController@postRegister');

Route::get('user/verify-account/{code}', 'Update\RegisterController@getVerify');

Route::get('profile', 'Update\UserController@getProfile');

Route::get('logout', 'Update\UserController@getLogout');

Route::get('update-profile', 'Update\UserController@getUpdateProfile');

Route::get('post', 'Update\UserController@getPost');