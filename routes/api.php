<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//auth
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
//auth//
//middleware
Route::group(["middleware"=>"checkuser:user_api"],function (){
//wshlist
Route::get('getwishlist', 'OtherController@getwishlist');
Route::post('savewishlist', 'OtherController@savewishlist');
//wshlist//
//rating
Route::put('saverating', 'OtherController@saverating');
Route::get('getmaxrating', 'OtherController@getmaxrating');
//rating//
Route::get('id', 'SearchController@detels');
//category
Route::get('getexpertsforcategory', 'OtherController@getexpertsforcategory');
Route::get('get_category', 'OtherController@getcategory');
//category//
    //search
    Route::get('search', 'SearchController@search');

    //search//
//time
Route::get('getregisted', 'Time@getregisted');
Route::put('saveregisteraton', 'Time@saveregisteraton');
Route::post('times', 'Time@availabletime');
Route::get('getregisteraton', 'Time@getregisteraton');
//time//
//EC
Route::post('RegisterE', 'RegisterECController@RegisterE');
Route::post('RegisterC', 'RegisterECController@RegisterC');
    Route::put('complete_infoexpert', 'RegisterECController@complete_infoexpert');
//EC//
});
//middleware//
//time
//time//

//Route::post("r",function (){
//    return Auth()->id();
//})->middleware("checkuser:user_api"); 
//Route::post('register_exp', 'AuthController@register_exp');
//Route::get('get_category', 'AuthController@get_category');



