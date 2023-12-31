<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



// Ваши роуты с проверкой adminKey
/**
 * 
 * Defines the routes for posts and reviews API endpoints.
 * 
 * @route GET /posts
 * @route GET /post/{id}
 * @route POST /post
 * @route PUT /post/{id}
 * @route DELETE /post/{id}
 * @route GET /reviews
 * @route GET /review/{id}
 * @route POST /review
 * @route PUT /review/{id}
 * @route DELETE /review/{id}
 * 
 * @param \App\Http\Controllers\PostController $postController
 * @param \App\Http\Controllers\ReviewController $reviewController
 */

Route::middleware('cors')->group(function () {
    Route::get('/posts', [PostController::class, 'index']); //Получение всех постов
    Route::get('/post/{id}', [PostController::class, 'show']); //Получение одного поста
    Route::post('/post', [PostController::class, 'store']); //Создание поста
    Route::put('/post/{id}', [PostController::class, 'update']); //Обновление поста
    Route::get('/reviews', [ReviewController::class, 'index']); //Получение всех отзывов
    Route::get('/review/{id}', [ReviewController::class, 'show']); //Получение  одного отзыва
    Route::post('/review', [ReviewController::class, 'store']); //Создание отзыва
    Route::post('/admin/login', [AdminController::class, 'login']);
    Route::delete('/post/{id}', [PostController::class, 'destroy']); //Удаление поста
    Route::delete('/review/{id}', [ReviewController::class, 'destroy']); //Удаление отзыва
    Route::post('/upload-image', [ImageController::class, 'upload']);
    Route::middleware('admin')->group(function () {
        Route::post('/admin/register', [AdminController::class, 'register']);
        Route::put('/review/{id}', [ReviewController::class, 'update']); //Обновление отзыва
    });
});