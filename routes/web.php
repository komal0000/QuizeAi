<?php

use App\Http\Controllers\DashbordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuizeController;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], 'signin',[LoginController::class,'signin'])->name('signin');
Route::match(['get', 'post'], 'login',[LoginController::class,'login'])->name('login');

Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function(){
    Route::get('',[DashbordController::class,'index'])->name('index');
    Route::match(['POST'],'singlequize/{option}',[QuizeController::class,'singlequize'])->name('singlequize');
    Route::match(['GET','POST'],'play/{quize}',[QuizeController::class,'play'])->name('play');
});
