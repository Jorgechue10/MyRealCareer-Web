<?php

use Illuminate\Support\Facades\Route;

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
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Noticias
Route::resource('noticias', 'NoticiasController');

// Temas
Route::resource('temas', 'TemasController');
Route::get('temas/categoria/{id}', 'TemasController@showTemasCategoria')->name('temas.categoria');

// Comentarios
Route::post('/comentarios/{parent_id}', 'ComentariosController@publicarComentario');

// Likes
Route::post('likes/click', 'LikesController@click');

// FAQ
Route::get('/ayuda', function () {
    return view('ayuda');
})->name('ayuda');

// Users
Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', 'UsersController');
    Route::get('users/{id}/siguiendo', 'UsersController@showSiguiendo')->name('users.siguiendo');
    Route::get('users/{id}/seguidores', 'UsersController@showSeguidores')->name('users.seguidores');
    Route::get('users/{id}/noticias/favoritos', 'UsersController@showNoticiasFavoritos')->name('users.noticias_favoritos');
    Route::get('users/{id}/temas/favoritos', 'UsersController@showTemasFavoritos')->name('users.temas_favoritos');
    Route::get('users/{id}/temas/publicados', 'UsersController@showTemasPublicados')->name('users.temas_publicados');
});
