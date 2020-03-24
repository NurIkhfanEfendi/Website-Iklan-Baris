<?php

use Illuminate\Http\Request;

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

Route::middleware(['jwt.verify'])->group(function(){

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
