<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(\Auth::check()){
        return redirect('/home');
    }
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/saveKeyPair', 'Ec2Controller@saveKeyPair')->name('saveKeyPair');
Route::get('/describeInstances', 'Ec2Controller@describeInstances');
Route::match(['get','post'],'/create-instance', 'Ec2Controller@LaunchNewInstantace');
Route::match(['get','post'],'/create-keypair', 'Ec2Controller@saveKeyPair');
