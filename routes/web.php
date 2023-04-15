<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/registration');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/users/{user}/settings', [UserSettingController::class, 'index'])->name('settings.index');
    Route::post('/users/{user}/settings', [UserSettingController::class, 'store'])->name('settings.store');
    Route::get('/users/{user}/settings/create', [UserSettingController::class, 'create'])->name('settings.create');
    Route::get('/users/{user}/settings/{setting}/edit', [UserSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/users/{user}/settings/{setting}', [UserSettingController::class, 'update'])->name('settings.update');
    Route::delete('/users/{user}/settings/{setting}', [UserSettingController::class, 'destroy'])->name('settings.destroy');
    Route::post('/users/{user}/settings/check_confirmation_code', [UserSettingController::class, 'checkConfirmationCode'])->name('settings.check_confirmation_code');
    Route::post('/users/{user}/settings/send_confirmation_code', [UserSettingController::class, 'sendConfirmationCode'])->name('settings.send_confirmation_code');
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
