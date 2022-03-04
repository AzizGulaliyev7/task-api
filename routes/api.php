<?php

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

Route::group([
    'namespace' => 'Api',
], function () {
    // Authentication routes.
    Route::group([
        'name'   => 'auth',
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('getAuth', 'AuthController@me');
    });

    // User's routes.
    Route::group([
        'name'   => 'users',
    ],function (){
        Route::apiResource('users', 'UserController');
    });

    // Company's routes.
    Route::group([
        'name'   => 'companies',
    ], function () {
        Route::group([
            'prefix'   => 'companies',
        ],function (){
            Route::get('getUserCompany','CompanyController@getUserCompany');
        });
        Route::apiResource('companies', 'CompanyController');
    });

    // Employee's routes.
    Route::group([
        'name'   => 'employees',
    ], function () {
        Route::apiResource('employees', 'EmployeeController');
    });
});