<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function () {
    // Below mention routes are public, user can access those without any restriction.
    // Create New User
    Route::post('register', 'AuthController@register');
    // Login User
    Route::post('login', 'AuthController@login');
    Route::post('login-oauth', 'AuthController@loginOauth');
    
    // Refresh the JWT Token
    Route::get('refresh', 'AuthController@refresh');
    
    // Below mention routes are available only for the authenticated users.
    Route::middleware('auth:api')->group(function () {
        // Get user info
        Route::get('user', 'AuthController@user');
        // Logout user from application
        Route::post('logout', 'AuthController@logout');
    });
});

Route::prefix('crawler')->group(function () {
    Route::get('consult', 'CrawlerController@consult');
});

Route::prefix('post')->group(function () {
    // Route::post('register', 'UserController@register');
    // Below mention routes are available only for the authenticated users.
    Route::middleware('auth:api')->group(function () {
        // Create New User
        Route::post('create_post', 'PostController@create');
        Route::post('post_category', 'PostController@postByCategory');
        Route::post('post_details', 'PostController@show');
        // Get user info
        Route::post('create_comment', 'CommentController@create');
        Route::post('comments_post', 'CommentController@commentByPost');
    });
});

Route::post('search', 'SearchController@search');
