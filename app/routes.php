<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/session',function(){

//
});
//Display
Route::get('/',array('uses'=>'LockMainController@index'));
Route::get('/home',array('uses'=>'LockMainController@view_home'));
Route::get('/profile',array('uses'=>'LockMainController@view_profile'));
Route::get('child', array('uses'=>'LockMainController@view_child'));
Route::get('/dashboard',array('uses'=>'LockMainController@view_dashboard'));
Route::get('display',array('uses'=>'SampleController@index'));

Route::get('/logout', array('as'=>'logout','uses'=>'LockMainController@logout'));
//post
Route::post('/login', 'LockMainController@login'); //Login
Route::post('/signup', 'LockMainController@signup'); //Signup
Route::post('/editprofile','LockMainController@editprofile'); //edit profile
Route::post('/editpp','LockMainController@editpp'); //edit profile picture
Route::get('/back','http://localhost:8000/#toregister');

Route::post('/addsite', 'LockMainController@add_blocklist'); //add website to blocklist
Route::post('/deletesite', 'LockMainController@delete_blocklist'); //delete website

//LockAPIController for retrofit
Route::get('/userlist','LockAPIController@user_api');
Route::get('/parentlist','LockAPIController@parent_api');
Route::get('/childlist','LockAPIController@child_api');
Route::post('/apilogin', 'LockAPIController@login'); //Login
Route::get('/checklogin','LockAPIController@checklogin');
//Route::get('/apilogin', 'LockAPIController@login'); //Login
Route::post('/samplelogin', 'LockAPIController@samplelogin'); //sample Login
Route::post('/apisignup', 'LockAPIController@signup'); //Signup
Route::post('/apieditprofile','LockAPIController@editprofile'); //edit profile api
Route::post('/apieditpp','LockAPIController@editpp'); //edit profile picture api
Route::get('/apihome','LockAPIController@view_home'); //display home
Route::get('/apilogout','LockAPIController@logout'); //logout