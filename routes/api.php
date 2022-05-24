<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ScriptController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Models\Role;
use App\Http\Controllers\MediaController;
use App\Models\Media;
use App\Models\User;
use App\Models\Script;
use App\Models\Achievement;

Route::post('/login', [UserController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/users', [UserController::class, 'search'])->can('search', User::class);
    Route::post('/users', [UserController::class, 'create'])->can('create', User::class);
    Route::put('/users/{id}', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->can('update', User::class);

    Route::get('/roles', [RoleController::class, 'search'])->can('search', Role::class);

    Route::post('/media', [MediaController::class, 'create'])->can('create', Media::class);
    Route::delete('/media/{id}', [MediaController::class, 'delete'])->where(['id' => '[0-9]+']);
    Route::get('/media/{id}', [MediaController::class, 'getById'])->where(['id' => '[0-9]+']);
    Route::get('/media/{id}/content', [MediaController::class, 'getContentById'])->where(['id' => '[0-9]+']);

    Route::post('/scripts', [ScriptController::class, 'create'])->can('create', Script::class);
    Route::put('/scripts/{id}', [ScriptController::class, 'update'])->where(['id' => '[0-9]+'])->can('update', Script::class);
    Route::delete('/scripts/{id}', [ScriptController::class, 'delete'])->where(['id' => '[0-9]+'])->can('delete', Script::class);
    Route::get('/scripts/{id}', [ScriptController::class, 'get'])->where(['id' => '[0-9]+']);
    Route::get('/scripts', [ScriptController::class, 'search']);

    Route::post('/achievements', [AchievementController::class, 'create'])->can('create', Achievement::class);
    Route::put('/achievements/{id}', [AchievementController::class, 'update'])->where(['id' => '[0-9]+'])->can('update', Achievement::class);;
    Route::delete('/achievements/{id}', [AchievementController::class, 'delete'])->where(['id' => '[0-9]+'])->can('delete', Achievement::class);
    Route::get('/achievements/{id}', [AchievementController::class, 'get'])->where(['id' => '[0-9]+']);
    Route::get('/achievements', [AchievementController::class, 'search']);
});
