<?php

use App\Http\Controllers\Api\MainController;
//use App\Http\Controllers\GenDocController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index']);

Route::view('/docs', 'apidocs');

