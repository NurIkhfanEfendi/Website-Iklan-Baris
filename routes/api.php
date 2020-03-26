<?php

use Illuminate\Http\Request;

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

Route::middleware(['jwt.verify'])->group(function(){
	Route::get('login/check', "UserController@LoginCheck"); 
	Route::post('logout', "UserController@logout"); 
	
    Route::get('iklan', "IklanController@index"); 
	Route::get('iklan/{limit}/{offset}', "IklanController@getAll");
	Route::post('iklan', 'IklanController@store'); 
	Route::put('iklan/{id}', "IklanController@update"); 
	Route::delete('iklan/{id}', "IklanController@delete"); 
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
