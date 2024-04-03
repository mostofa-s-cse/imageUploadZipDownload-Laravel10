<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/upload', [ImageController::class, 'upload'])->name('image.upload');
Route::get('/download', [ImageController::class, 'download'])->name('image.download');
Route::get('/singleDownload/{id}', [ImageController::class, 'singleDownload'])->name('image.singleDownload');

