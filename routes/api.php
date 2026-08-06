<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventParticipantController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\UserController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('participants', ParticipantController::class);

    Route::apiResource('events', EventController::class)
        ->except(['index', 'show']);

    Route::get('/events/{event}/participants', [EventParticipantController::class, 'index']);
    Route::post('/events/{event}/participants', [EventParticipantController::class, 'store']);
    Route::delete('/events/{event}/participants/{participant}', [EventParticipantController::class, 'destroy']);

    Route::get('/users', [UserController::class, 'index']);
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
});