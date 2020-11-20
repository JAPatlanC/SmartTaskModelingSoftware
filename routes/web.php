<?php

use App\Models\Content;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ContentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('contentsVer/{id}', function ($id) {
    $content = Content::find($id);
    $base64 = $content->body;

    return view('contents.ver',  compact(['base64','base64']));
})->name('contentsVer');
Route::get('/admin/task', function () {
    return view('admin/Task');
});
Route::get('/admin/resource', function () {
    return view('admin/Resource');
});

Route::resource('themes', ThemeController::class)->middleware('auth');;
Route::resource('tasks', TaskController::class)->middleware('auth');;
Route::resource('contents', ContentController::class)->middleware('auth');;
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
