<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContestController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('api/contest', [ContestController::class, 'contest']);

