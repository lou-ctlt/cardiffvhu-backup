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
Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

// Routes pour les fonctions des dossiers
Route::get('folders/{folder_id}', 'WebController@getFolder'); //afficher le dossier et les photos
Route::post('folders', 'WebController@createFolder'); // créer un nouveau dossier
Route::get('folders/delete/{id}', 'WebController@deleteFolder'); // supprimer un dossier

// Routes pour les fonctions des photos
Route::post('photos', 'WebController@uploadPhoto')->name('uploadPhoto'); // ajouter une photo dans le dossier
Route::put('photos/{id}', 'WebController@updatePhoto'); // modifier une photo
Route::get('photos/delete','WebController@deletePhoto')->name('deletePhoto'); // supprimer une photo

// Routes pour les fonctions de l'espace compte
Route::get("account/{id}", "AccountController@index");// afficher la page compte
Route::post("account/{id}", "AccountController@edit"); // modifier les infos


// Routes pour les fonctions de l'espace administrateur
Route::post('admin', 'AdminController@createUser')->name('CreateUser'); // créer un nouvel utilisateur
Route::get('admin/edit/{id}','AdminController@editUserForm')->name('Edit'); // afficher le formulaire de modification d'utilisateur
Route::post('admin/edit/{id}','AdminController@editUser')->name('EditUser'); // modifier un utilisateur
Route::get('admin/delete/{id}', 'AdminController@deleteUser')->name('DeleteUser'); // supprimer un utilisateur