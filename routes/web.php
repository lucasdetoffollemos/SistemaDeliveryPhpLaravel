<?php

use Illuminate\Support\Facades\Route;
use \App\Models\TipoProduto;
use \App\Models\Produto;
use Illuminate\Support\Facades\DB;



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

//ROTAS TIPO PRODUTO
Route::get('/tipoproduto', "App\Http\Controllers\TipoProdutoController@index");
Route::post('/tipoproduto', "App\Http\Controllers\TipoProdutoController@store");
Route::get('/tipoproduto/create', "App\Http\Controllers\TipoProdutoController@create");

//ROTAS PRODUTO
Route::get('/produto', "App\Http\Controllers\ProdutoController@index");
Route::get('/produto/create', "App\Http\Controllers\ProdutoController@create");
Route::post('/produto', "App\Http\Controllers\ProdutoController@store");