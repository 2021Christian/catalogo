<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
});


Route::view('/inicio', 'inicio');

######## CRUD Marcas #############
Route::get( '/marcas', [ MarcaController::class, 'index' ]);
Route::get( '/marca/create', [ MarcaController::class, 'create' ]);
Route::post( 'marca/store', [ MarcaController::class, 'store' ]);
Route::get( '/marca/edit/{id}', [ MarcaController::class, 'edit' ]);
Route::patch( '/marca/update', [ MarcaController::class, 'update' ]);
Route::get( '/marca/delete/{id}', [ MarcaController::class, 'confirm' ]);
Route::delete( '/marca/destroy', [ MarcaController::class, 'destroy']);


######## CRUD Categorias #############
Route::get('/categorias', [ CategoriaController::class, 'index' ]);
Route::get('/categoria/create', [ CategoriaController::class, 'create' ]);
Route::post('categoria/store', [ CategoriaController::class, 'store' ]);
Route::get( '/categoria/edit/{id}', [ CategoriaController::class, 'edit' ]);
Route::patch( '/categoria/update', [ CategoriaController::class, 'update' ]);
Route::get( '/categoria/delete/{id}', [ CategoriaController::class, 'confirm' ]);
Route::delete( '/categoria/destroy', [ CategoriaController::class, 'destroy'] );


######## CRUD Categorias #############
Route::get('/productos', [ ProductoController::class, 'index' ]);
Route::get('/producto/create', [ ProductoController::class, 'create' ]);
Route::post('/producto/store', [ ProductoController::class, 'store' ]);
Route::get('/producto/edit/{id}', [ProductoController::class, 'edit']);
Route::patch('/producto/update', [ProductoController::class, 'update']);
Route::get('/producto/delete/{id}', [ProductoController::class, 'confirm']);
Route::delete('/producto/destroy', [ ProductoController::class, 'destroy' ]);

