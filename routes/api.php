<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowRecordController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\RateController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/add/user', [AuthController::class, 'addUser'])->middleware('role:admin');

    Route::apiResource('/books', BookController::class);

//    Route::apiResource('/borrows',BorrowRecordController::class);
    Route::middleware('role:user')->group(function () {
        Route::post('/borrows', [BorrowRecordController::class, 'store']);
        Route::put('/borrows/{borrow_record}', [BorrowRecordController::class, 'update']);
        Route::delete('/borrows/{borrow_record}', [BorrowRecordController::class, 'destroy']);
    });
    Route::get('/borrows', [BorrowRecordController::class, 'index'])->middleware('role:admin');
    Route::get('/borrows/{borrow_record}', [BorrowRecordController::class, 'show']);
    Route::post('/book/restore/{borrow_record}',[BorrowRecordController::class,'restore']);

    Route::apiResource('/rates',RateController::class);

});
