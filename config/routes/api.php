<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use mms80\TodoApi\Http\Controllers\TaskController;
use mms80\TodoApi\Http\Controllers\LabelController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api-auth')->apiResource('tasks',TaskController::class)->except('destroy');
Route::middleware('api-auth')->apiResource('labels',LabelController::class)->only('index','store');
