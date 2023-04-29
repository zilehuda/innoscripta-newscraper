<?php

use App\Http\Controllers\Api\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserPreferenceController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function() {
    Route::post("register", "register");
    Route::post("login", "login");
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get("authors", [ArticleController::class, 'getUniqueAuthors']);
    Route::get("categories", [ArticleController::class, 'getUniqueCategories']);
    Route::get("sources", [ArticleController::class, 'getUniqueSources']);
    Route::get("articles", [ArticleController::class, 'getArticles']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get("preferences", [UserPreferenceController::class, 'getPreference']);
    Route::post("preferences", [UserPreferenceController::class, 'addOrUpdatePreference']);
});