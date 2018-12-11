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



Route::get('/',function ()
{
    return view('home');
});

Route::get('/dropzone',function ()
{
   return view('dropzone');
});

Route::post('/upload','Filesystem@file_upload')->name('file.upload');
Route::post('/upload/dropzone','Filesystem@dropzone')->name('dropzone');

//Google cloud Storage version

Route::prefix('google')->group(function ()
{
   Route::get('/',function () {return view('google_single');});
   Route::get('/dropzone',function(){return view('goggle-dropzone');});
   Route::post('/upload','Filesystem@gg_file_upload')->name('gg_file.upload');
   Route::post('/upload/dropzone','Filesystem@gg_dropone')->name('gg_dropzone');

});
