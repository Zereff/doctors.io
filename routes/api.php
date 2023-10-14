<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\TimeslotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [AuthController::class, 'login']);

Route::controller(DoctorController::class)->group(function () {
    Route::get('/doctors', 'index');
    Route::get('/doctors/{doctor}', 'show');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::controller(DoctorController::class)->group(function () {
        Route::post('/doctors', 'store');
        Route::patch('/doctors/{doctor}', 'update');
        Route::delete('/doctors/{doctor}', 'destroy');
    });

    Route::controller(AvailabilityController::class)->group(function () {
        Route::get('/availabilities', 'index');
        Route::post('/availabilities', 'store');
        Route::get('/availabilities/{availability}', 'show');
        Route::patch('/availabilities/{availability}', 'update');
        Route::delete('/availabilities/{availability}', 'destroy');
    });

    Route::controller(PatientController::class)->group(function () {
        Route::get('/patients', 'index');
        Route::post('/patients', 'store');
        Route::get('/patients/{patient}', 'show');
        Route::patch('/patients/{patient}', 'update');
        Route::delete('/patients/{patient}', 'destroy');
    });

    Route::controller(TimeslotController::class)->group(function () {
        Route::get('/timeslots', 'index');
        Route::post('/timeslots', 'store');
        Route::get('/timeslots/{timeslot}', 'show');
        Route::patch('/timeslots/{timeslot}', 'update');
        Route::delete('/timeslots/{timeslot}', 'destroy');
    });

    Route::controller(AppointmentController::class)->group(function () {
        Route::get('/appointments', 'index');
        Route::post('/appointments', 'store');
        Route::delete('/appointments/{appointment}', 'destroy');
    });
});
