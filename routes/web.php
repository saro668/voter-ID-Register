<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VotersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\DistrictController;



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
    return view('auth.login');
});



Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
  
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
  
    Route::get('logout', 'logout')->middleware('auth')->name('logout');


});

// Define Custom Verification Routes
Route::controller(VerificationController::class)->group(function() {
    Route::get('/email/verify', 'notice')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', 'verify')->name('verification.verify');
    Route::post('/email/resend', 'resend')->name('verification.resend');
});

  
Route::middleware(['auth', 'verified'])->group(function () {
   
    Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
        Route::get('', 'index')->name('dashboard');
    });

    Route::controller(VotersController::class)->prefix('voters')->group(function () {
        Route::get('', 'index')->name('voters');
        Route::get('create', 'create')->name('voters.create');
        Route::post('store', 'store')->name('voters.store');
        Route::get('show/{id}', 'show')->name('voters.show');
        Route::get('destroy/{id}', 'destroy')->name('voters.destroy');
    });

    Route::controller(ReportController::class)->prefix('report')->group(function () {
        Route::get('', 'index')->name('report');
        Route::get('export', 'export')->name('export');
    });

    Route::controller(ActivityLogController::class)->prefix('activity')->group(function () {
        Route::get('', 'index')->name('activity');
    });

     Route::controller(StateController::class)->prefix('state')->group(function () {
        Route::get('', 'index')->name('state');
        Route::get('create', 'create')->name('state.create');
        Route::post('store', 'store')->name('state.store');

        Route::get('{id}/edit', 'edit')->name('state.edit');
        Route::put('state/{id}', 'update')->name('state.update');
        Route::get('destroy/{id}', 'destroy')->name('state.destroy');
        Route::post('updateStatus/{id}', 'updateStatus')->name('state.updateStatus');

    });

    Route::controller(DistrictController::class)->prefix('district')->group(function () {
        Route::get('', 'index')->name('district');
        Route::get('create', 'create')->name('district.create');
        Route::post('store', 'store')->name('district.store');

        Route::get('{id}/edit', 'edit')->name('district.edit');
        Route::post('updateStatus/{id}', 'updateStatus')->name('district.updateStatus');

        Route::put('district/{id}', 'update')->name('district.update');
        Route::get('destroy/{id}', 'destroy')->name('district.destroy');
        Route::get('get/{stateId}', 'get')->name('district.get');

    });
 
});

