<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\User\UserController;
use App\Http\Controllers\API\v1\Doctor\DoctorController;
use App\Http\Controllers\API\v1\User\Auth\AuthController;
use App\Http\Controllers\API\v1\Doctor\Auth\AuthController as AuthAuthController;
use App\Http\Controllers\API\v1\Doctor\ScheduleController;
use App\Http\Controllers\API\v1\User\BasicController;
use App\Http\Controllers\API\v1\User\CallController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group.
|
*/


Route::prefix('v1')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Authentication Routes
    |--------------------------------------------------------------------------
    |
    | These routes are used for authentication for both users and doctors.
    |
    */


    Route::controller(AuthController::class)->prefix('user')->group(function () {
        Route::post('login', 'login');
    });
    Route::controller(AuthAuthController::class)->prefix('doctor')->group(function () {
        Route::post('login', 'login');
    });


    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    |
    | These routes are used by authenticated users.
    | Middleware: auth:user (bearer token) and active:user (status)
    | Prefix: user ,Group: user
    |
    */


    Route::middleware(['auth:api', 'active'])->prefix('user')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('update', 'update');
        });
        Route::controller(BasicController::class)->prefix('specializations')->group(function () {
            Route::get('/', 'specializations');
        });
        Route::controller(BasicController::class)->prefix('doctor')->group(function () {
            Route::get('/', 'index');
            Route::get('specialization/{id}', 'doctorBySpecialization');
            Route::get('/{id}', 'show');
            Route::post('toggle-like', 'toggleLikeDoctor');
            Route::post('review', 'storeReview');
        });

        Route::controller(CallController::class)->prefix('call')->group(function () {
            Route::get('/', 'index');
            Route::post('initiate', 'initiate');
        });
    });



    /*
    |--------------------------------------------------------------------------
    | Doctor Routes
    |--------------------------------------------------------------------------
    |
    | These routes are used by authenticated doctors.
    | Middleware: auth:doctor (bearer token).
    | Prefix: doctor ,Group: doctor
    |
    */

    Route::middleware(['auth:doctor'])->prefix('doctor')->group(function () {
        Route::controller(DoctorController::class)->group(function () {
            Route::get('qualifications', 'qualifications');
            Route::get('specializations', 'specializations');
            Route::get('document-types', 'documentTypes');
            Route::post('initial-update', 'initUpdate');
        });


        /*
        |--------------------------------------------------------------------------
        | Active Doctor Routes
        |--------------------------------------------------------------------------
        |
        | These routes are used by authenticated doctors with active status.
        |
        */


        Route::controller(DoctorController::class)
            ->middleware(['active'])
            ->group(function () {
                Route::get('/', 'index');
                Route::get('clinics', 'clinics');
                Route::get('reviews', 'reviews');
                Route::post('clinics', 'storeClinics');
                Route::post('update-status', 'updateStatus');
                Route::controller(ScheduleController::class)->group(function () {

                    Route::prefix('slots')->group(function () {
                        Route::get('/', 'slots');
                        Route::post('/', 'storeSlots');
                    });

                    Route::prefix('schedules')->group(function () {
                        Route::get('/', 'schedules');
                    });
                });
            });
    });
});
