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

Route::prefix('v1')->group(function () {
    Route::group(['middleware' => ['cors', 'json.response']], function () {
        Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');
        Route::post('/register', 'Auth\ApiAuthController@register')->name('register.api');
    });



    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');

        Route::post('/role/create', 'RoleController@creatRole')->name('creatRole.api');
        Route::post('/role/delete', 'RoleController@deletRole')->name('deletRole.api');

        Route::post('/role/permissions/create', 'PermissionsController@creatPermissions')->name('creatPermissions.api');
        Route::post('/role/permissions/delete', 'PermissionsController@deletePermissions')->name('deletePermissions.api');

        Route::post('/role/assign', 'RoleController@assignRole')->name('assignRole.api');
        Route::post('/role/revoke', 'RoleController@revokeRole')->name('revokeRole.api');

        Route::post('/role/permissions/assign', 'PermissionsController@assignPermissions')->name('assignPermissions.api');
        Route::post('/role/permissions/revoke', 'PermissionsController@revokePermissions')->name('revokePermissions.api');

        Route::get('/blog', 'PostController@index')->name('allBlog.api');
        Route::post('/blog', 'PostController@store')->name('crateBlog.api');
        Route::get('/blog/{$slug}', 'PostController@show')->name('oneBlog.api');
        Route::post('/blog/{$slug}', 'PostController@update')->name('updateBlog.api');
        Route::delete('/blog/{$slug}', 'PostController@destroy')->name('deletBlog.api');

        Route::group(['middleware' => ['role:super-admin']], function () { 


        });

    });
});
