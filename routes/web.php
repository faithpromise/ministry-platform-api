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

use Illuminate\Support\Facades\Route;

Route::get('/groups', 'Controller@groups');
Route::get('/groups/focuses', 'Controller@groupFocuses');
Route::get('/groups/life-stages', 'Controller@lifeStages');
