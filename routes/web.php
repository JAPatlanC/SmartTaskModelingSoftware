<?php

use App\Models\Content;
use App\Models\Theme;
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
    //$baseData = base64_encode($base64);

    $my_bytea = stream_get_contents($base64);
    $my_string = pg_unescape_bytea($my_bytea);
    $baseData = htmlspecialchars($my_string);

    return view('contents.ver',  compact(['baseData','baseData']));
})->name('contentsVer');


Route::get('validaEstructura', function () {
    $projects = Theme::with('parent')->get();
    $data = [];
    foreach ($projects as $theme){
        try {
        if($theme->id==$theme->parent->id)
            continue;
        } catch (Exception $e) {
            continue;
        }
        try {
            $data[''.$theme->parent->name] += $theme->value;
        } catch (Exception $e) {
            $data[''.$theme->parent->name] = intval('0'+$theme->value);

        }
    }

    return view('validaEstructura',  compact(['data','data']));
})->name('validaEstructura');


Route::get('diagrama', function () {
    $topic= Theme::where('parent_id','=',null)->firstOrFail();
    $topNode = new \App\Models\Node();
    $topNode->text= new \App\Models\Node();
    $topNode->text->name=$topic->name;
    $topNode->children=\App\Models\Utilities::addChildren(Theme::where('parent_id','=',$topic->id)->get());//
    $data = $topNode;
    //$data->name = $topic->name;


    return view('diagrama',  compact(['data','data']));
})->name('diagrama');

Route::get('resultados', function () {
    return view('resultados');
})->name('resultados');

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
