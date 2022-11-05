<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\StudentsController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Students Todo List
Route::prefix('/students')->group(function (){
    Route::get('/', [StudentsController::class, "index"])->name('students');
    Route::get('/list', [StudentsController::class, "list"])->name('students.list');
    Route::post('/store', [StudentsController::class, "store"])->name('students.store');
    Route::get('/edit', [StudentsController::class, "edit"])->name('students.edit');
    Route::post('/{task_id}/update', [StudentsController::class, "update"])->name('students.update');
    Route::delete('/{task_id}/delete', [StudentsController::class, "delete"])->name('students.delete');
    Route::get('/{task_id}/active', [StudentsController::class, "done"])->name('students.done');
});

require __DIR__.'/auth.php';
