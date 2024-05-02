<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [UploadController::class, 'index'])->name('upload');
Route::post('/upload/save', [UploadController::class, 'save'])->name('upload.save');
Route::get('/upload/download', [UploadController::class, 'download'])->name('upload.download');
