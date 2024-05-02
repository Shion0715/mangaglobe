<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [UploadController::class, 'index'])->name('upload');
Route::post('/upload/save', [UploadController::class, 'save'])->name('upload.save');
Route::get('/upload/download', [UploadController::class, 'download'])->name('upload.download');
