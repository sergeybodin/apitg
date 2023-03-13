<?php

use Illuminate\Support\Facades\Route;

Route::get('ping', 'Api\PingController@index');

Route::get('assets/{uuid}', 'Api\Assets\RenderFileController@open');
Route::get('assets/{uuid}/render', 'Api\Assets\RenderFileController@show');
Route::get('assets/{uuid}/download', 'Api\Assets\RenderFileController@download');

Route::post('register', 'Api\Auth\RegisterController@store');
Route::post('passwords/reset', 'Api\Auth\PasswordsController@store');
Route::put('passwords/reset', 'Api\Auth\PasswordsController@update');

Route::get('/check-email', 'Api\Auth\RegisterController@checkEmail');

Route::group(['middleware' => ['auth:api']], function() {
	Route::apiResource('users', 'Api\Users\UsersController');
	Route::apiResource('roles', 'Api\Users\RolesController');

	Route::get('permissions', 'Api\Users\PermissionsController@index');

    Route::group(['prefix' => 'me'], function() {
        Route::get('/', 'Api\Users\ProfileController@index');
        Route::put('/', 'Api\Users\ProfileController@update');
        Route::patch('/', 'Api\Users\ProfileController@update');
        Route::put('/password', 'Api\Users\ProfileController@updatePassword');

        Route::group(['prefix' => 'notifications'], function() {
            Route::get('/', 'Api\NotificationsController@list');
            Route::post('/', 'Api\NotificationsController@messageRead');
            Route::get('/count', 'Api\NotificationsController@count');
        });
    });

    Route::group(['prefix' => 'assets'], function() {
        Route::post('/', 'Api\Assets\UploadFileController@store');
    });

    Route::group(['prefix' => 'forms'], function() {
        Route::get('/{type}', 'Api\Forms\FormsController@new');
        Route::get('/{type}/{id}', 'Api\Forms\FormsController@edit');
    });

    Route::apiResource('movies', 'Api\Movies\MoviesController');
    Route::apiResource('tasks', 'Api\Tasks\TasksController');
    Route::apiResource('clients', 'Api\Clients\ClientsController');

    Route::group(['prefix' => 'bots', 'namespace' => 'Bots'], function() {
        Route::group(['prefix' => 'cinema', 'namespace' => 'Cinema'], function() {
            // /api/bots/cinema/response
            Route::post('/response', 'ResponseController@post');
            // /api/bots/cinema/request
            Route::post('/request', 'RequestController@post');
        });
    });

});
