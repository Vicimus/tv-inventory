<?php

use App\Http\Controllers\OemKeysController;
use Illuminate\Support\Facades\Route;

// Take a value from the 'config/oem.php' file. ex: '/my-motors'
Route::redirect('/', '/my-motors');
Route::get('/{slug}', [OemKeysController::class, 'index']);
