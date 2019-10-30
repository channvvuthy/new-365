<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('category', 'CategoryController');
Route::resource('banner', 'BannerController');
Route::resource('location', 'LocationController');

Route::resource('product', 'PostController');

Route::resource('user', 'UserController');

Route::resource('auth', 'AuthController');

Route::resource('save', 'SaveController');

Route::post('register', [
    'uses' => 'SingUpController@postSignUp',
    'as' => 'signup'
]);

Route::post('login', [
    'uses' => 'SignInController@postLogin',
    'as' => 'login'
]);
Route::get('profile', [
    'uses' => 'SignInController@getProfile',
    'as' => 'getProfile'
]);
Route::post('edit-profile', [
    'uses' => 'SignInController@postProfile',
    'as' => 'postProfile'
]);

Route::get('product-by-category', [
    'uses' => 'PostController@getProductByCategory',
    'as' => 'pcat'
]);

Route::get('save-product-to-favorite', [
    'uses' => 'SaveController@getSaveProductToFavorite',
    'as' => 'save-product',
    'middleware' => 'jwt.auth'
]);

Route::post('create-post', [
    'uses' => 'PostController@postCreatePost',
    'as' => 'create-post',
    'middleware' => 'jwt.auth'
]);

Route::post('update-store', [
    'uses' => 'UserController@postUpdateStore',
    'as' => 'update-store',
    'middleware' => 'jwt.auth'
]);

Route::post('update-product', [
    'uses' => 'PostController@postUpdate',
    'as' => 'update.product'
]);

Route::post('forgot-password', [
    'uses' => 'UserController@postForgotPassword',
    'as' => 'api.forgot.password'
]);

Route::post('reset-password', [
    'uses' => 'UserController@postResetPassword',
    'as' => 'api.reset.password'
]);


