<?php

use App\Video;

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
    return view('welcome');
});

//Rutas para el login, registro, etc...
Auth::routes();

Route::get('/home', array(
    'as' => 'home',
    'uses' => 'HomeController@index'
));

//Rutas del controlador de Videos
    /**
     * Ruta para ir al formulario de la creación del video, si no estamos logueados, actua el middleware
     **/
Route::get('/crear-video', array(
    'as' => 'createVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@createVideo'
));

    /**
     * Ruta que guarda el video en la BBDD
     **/
Route::post('/guardar-video', array(
    'as' => 'saveVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@saveVideo'
));

    /**
     * Ruta que nos devuelve la imagen (minuatura) del video
     **/
Route::get('/miniatura/{filename}', array(
    'as' => 'imageVideo',
    'uses' => 'VideoController@getImage'
));

Route::get('/video-file/{filename}', array(
    'as' => 'fileVideo',
    'uses' => 'VideoController@getVideo'
));

Route::get('/video/{video_id}', array(
    'as' => 'detailVideo',
    'uses' => 'VideoController@getVideoDetail'
));
