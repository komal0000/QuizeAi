<?php

use App\Http\Controllers\DashbordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuizeController;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], 'signup',[LoginController::class,'signup'])->name('signup');
Route::match(['get', 'post'], 'login',[LoginController::class,'login'])->name('login');

Route::middleware(['auth'])->group(function(){
    Route::get('',[DashbordController::class,'index'])->name('index');
    Route::match(['GET','POST'],'singlequize/{option}',[QuizeController::class,'singlequize'])->name('singlequize');
});
