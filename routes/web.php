<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



//Auth
Route::get('/login', [AuthController::class, 'loginView'])->name('login-view');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login-post');

Route::get('/register', [AuthController::class, 'registerView'])->name('register-view');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register-post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');




//Dealers
Route::name('dealers.')->prefix('dealers')->group(function () {

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
Route::name('departments.')->prefix('departments')->group(function () {

    //Page
    Route::get('/', [DepartmentController::class, 'index'])->name('index');
    Route::get('/create', [DepartmentController::class, 'create'])->name('create');
    Route::get('/{department}/edit', [DepartmentController::class, 'edit'])->name('edit');
    Route::get('/{department}', [DepartmentController::class, 'show'])->name('show');


    //Logical
    Route::post('/', [DepartmentController::class, 'store'])->name('store');
    Route::put('/{department}', [DepartmentController::class, 'update'])->name('update');
    Route::delete('/{department}', [DepartmentController::class, 'destroy'])->name('destroy');
});


//Areas
Route::name('areas.')->prefix('areas')->group(function () {

    //Page
    Route::get('/', [AreaController::class, 'index'])->name('index');
    Route::get('/create', [AreaController::class, 'create'])->name('create');
    Route::get('/{area}/edit', [AreaController::class, 'edit'])->name('edit');
    Route::get('/{area}', [AreaController::class, 'show'])->name('show');


    //Logical
    Route::post('/', [AreaController::class, 'store'])->name('store');
    Route::put('/{area}', [AreaController::class, 'update'])->name('update');
    Route::delete('/{area}', [AreaController::class, 'destroy'])->name('destroy');
});




//Task
Route::name('tasks.')->prefix('tasks')->group(function () {

    //Page
    Route::get('/', [TaskController::class, 'index'])->name('index');
    Route::get('/create', [TaskController::class, 'create'])->name('create');
    Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
    Route::get('/{task}', [TaskController::class, 'show'])->name('show');


    //Logical
    Route::post('/', [TaskController::class, 'store'])->name('store');
    Route::put('/{task}', [TaskController::class, 'update'])->name('update');
    Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
});

//ManageTask