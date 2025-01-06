<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('components.layout');
});
Route::get('/project', function () {
    return view('project');
});
Route::get('/tasks', function () {
    return view('task');
});
Route::get('/time_entries', function () {
    return view('time_entries');
});

Route::get('/report', function () {
    return view('report');
});

Route::get('/getTasks/{project}', [ProjectController::class, 'getTasks'])->name('getTasks');

Route::post('/createTimeEntry', [ProjectController::class, 'store'])->name('createTimeEntry');

Route::post('/search-projects', [ProjectController::class, 'searchProjects']);
