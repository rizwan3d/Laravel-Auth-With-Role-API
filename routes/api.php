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


Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');
    Route::post('/register','Auth\ApiAuthController@register')->name('register.api');    
});



Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');

    Route::post('/role/create', 'RoleController@creatRole')->name('creatRole.api');
    Route::post('/role/delete', 'RoleController@deletRole')->name('deletRole.api');

    Route::post('/role/permissions/create', 'PermissionsController@creatPermissions')->name('creatPermissions.api');
    Route::post('/role/permissions/delete', 'PermissionsController@deletePermissions')->name('deletePermissions.api');
});
