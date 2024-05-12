<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\JobController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return view('registration');
});

Route::get('/login-view', function () {
    return view('login');
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login_user', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/create-job', [JobController::class, 'create']);
    Route::post('/save-job', [JobController::class, 'store']);
    Route::get('/dashboard', [JobController::class, 'dashboard']);
    Route::get('/getJobData/{userId}', [JobController::class, 'getJobData']);
    Route::post('/jobs', [JobController::class, 'show']);
    Route::post('/apply-job', [JobController::class, 'apply']);
});

