<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::get('/register', function () {
    return view('register');
})->middleware('guest')->name('register');

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'middleware' => ['auth:api'],
 ], function ($router) {
    Route::get('/home', function (Request $request) {
        return view('user');
    })->name('home');
});