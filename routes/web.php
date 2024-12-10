<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('migrate', function (){
    return \Illuminate\Support\Facades\Artisan::call('migrate');
});
