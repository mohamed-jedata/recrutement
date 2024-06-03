<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('index');
});

Route::get('/', [ContactController::class, 'index'])->name('index');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


Route::get('/contact/{id}', [ContactController::class, 'show']);
Route::put('/contact/{id}', [ContactController::class, 'update']);
Route::delete('/contact', [ContactController::class, 'destroy'])->name('contact.destroy');
