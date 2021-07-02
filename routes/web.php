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

Route::get('/supplier_home', 'SupplierController@HomePage');
Route::get('/suplmas_home_data', 'SupplierController@HomeData');
Route::get('/supplier_new', 'SupplierController@New');
Route::get('/supplier_preview', 'SupplierController@Preview');
Route::get('/supplier_edit', 'SupplierController@Edit');

Route::post('/supplier_name_validate', 'SupplierController@name_validate');
Route::post('/supplier_save', 'SupplierController@save');



