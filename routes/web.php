<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContestController;

Route::get('/', function () {
    return view('welcome');
});

//Endpoint post api/contest - ContestController
Route::post('api/contest', [ContestController::class, 'contest']);

