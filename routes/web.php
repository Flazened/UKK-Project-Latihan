<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



//Dealers
Route::name('dealers.')->prefix('dealers')->group(function(){

//Page
Route::get('/', [DealerController::class, 'index'])->name('index');
Route::get('/create', [DealerController::class, 'create'])->name('create');
Route::get('/{dealer}/edit', [DealerController::class, 'edit'])->name('edit');
Route::get('/{dealer}', [DealerController::class, 'show'])->name('show');


//Logical
Route::post('/', [DealerController::class, 'store'])->name('store');
Route::put('/{dealer}', [DealerController::class, 'update'])->name('update');
Route::delete('/{dealer}', [DealerController::class, 'destroy'])->name('destroy');
});



//Deapertments
Route::name('departments.')->prefix('departments')->group(function(){

//Page
Route::get('/', [DepartmentController::class, 'index'])->name('index');
Route::get('/create', [DepartmentController::class, 'create'])->name('create');
Route::get('/{departments}/edit', [DepartmentController::class, 'edit'])->name('edit');
Route::get('/{departments}', [DepartmentController::class, 'show'])->name('show');


//Logical
Route::post('/', [DepartmentController::class, 'store'])->name('store');
Route::put('/{departments}', [DepartmentController::class, 'update'])->name('update');
Route::delete('/{departments}', [DepartmentController::class, 'destroy'])->name('destroy');
});


//Areas
Route::name('areas.')->prefix('areas')->group(function(){

//Page
Route::get('/', [AreaController::class, 'index'])->name('index');
Route::get('/create', [AreaController::class, 'create'])->name('create');
Route::get('/{areas}/edit', [AreaController::class, 'edit'])->name('edit');
Route::get('/{areas}', [AreaController::class, 'show'])->name('show');


//Logical
Route::post('/', [AreaController::class, 'store'])->name('store');
Route::put('/{areas}', [AreaController::class, 'update'])->name('update');
Route::delete('/{areas}', [AreaController::class, 'destroy'])->name('destroy');
});




//Task
Route::name('tasks.')->prefix('tasks')->group(function(){

//Page
Route::get('/', [TaskController::class, 'index'])->name('index');
Route::get('/create', [TaskController::class, 'create'])->name('create');
Route::get('/{tasks}/edit', [TaskController::class, 'edit'])->name('edit');
Route::get('/{tasks}', [TaskController::class, 'show'])->name('show');


//Logical
Route::post('/', [TaskController::class, 'store'])->name('store');
Route::put('/{tasks}', [TaskController::class, 'update'])->name('update');
Route::delete('/{tasks}', [TaskController::class, 'destroy'])->name('destroy');
});


