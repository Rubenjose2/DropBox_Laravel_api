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

//Route::get('/', function () {
//    return view('welcome');
//});


//Route::get('/','Filesystem@index');



Route::get('/','Filesystem@index');

Route::get('/test','Test@index');

Route::get('/dropzone',function ()
{
   return view('dropzone');
});

Route::post('/upload_file','Filesystem@file_upload')->name('file.upload');
Route::post('/upload/dropzone','Filesystem@dropzone')->name('dropzone');

Route::get('/database','Schedule@index');

