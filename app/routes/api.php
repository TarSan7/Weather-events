<?php

use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\TypesController;
use Illuminate\Support\Facades\Route;

Route::resource('events', EventsController::class)->only([
    'index'
]);

Route::resource('types', TypesController::class)->only([
    'index'
]);
