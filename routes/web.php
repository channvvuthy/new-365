<?php
Route::get('/', 'Update\HomeController@getIndex');

Route::post('register', 'Update\RegisterController@postRegister');