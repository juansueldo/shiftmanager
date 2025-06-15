<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\sections\AccountController;
use App\Http\Controllers\sections\DashboardController;
use App\Http\Controllers\sections\CalendarController;
use App\Http\Controllers\sections\UserController;
use App\Http\Controllers\sections\PatientController;
use App\Http\Controllers\sections\SpecialtyController;
use App\Http\Controllers\sections\DoctorController;
use App\Http\Controllers\settings\ConnectionsController;
use App\Http\Controllers\auth\GoogleAuthController;
use App\Http\Controllers\settings\CustomerController;
use Illuminate\Support\Facades\Route;

// Redirigir a dashboard si el usuario está autenticado
Route::get('/', function () {
    return redirect()->route('dashboard.index');
})->middleware('auth');
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::get('/auth/google/disconnect', [GoogleAuthController::class, 'disconnect'])->name('auth.disconnect');
// Cambiar idioma
Route::get('/language/{lang}', [DashboardController::class, 'setLanguage'])->name('dashboard.language');

// Página de inicio
Route::get('/landing', [DashboardController::class, 'landing'])->name('home');

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('login.destroy')->middleware('auth');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/main', [DashboardController::class, 'create'])->name('dashboard.create');
    Route::post('/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::get('/profile/{id?}', [AccountController::class, 'index'])->name('account.index');
    Route::get('/navbar', [DashboardController::class, 'navbar'])->name('dashboard.navbar');
    Route::post('/widgets/update', [DashboardController::class, 'updateWidgets'])->name('dashboard.widgets.update');
    Route::get('/widgets/create/{name}', [DashboardController::class, 'createWidget'])->name('dashboard.widgets.create');
    Route::get('/widgets/delete/{id}', [DashboardController::class, 'deleteWidget'])->name('dashboard.widgets.delete');
    // Calendario
    Route::prefix('calendar')->name('calendar.')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('index');
        Route::get('/add/{id?}', [CalendarController::class, 'add'])->name('add');
        Route::post('/save', [CalendarController::class, 'store'])->name('save');
    });

    // Usuarios
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/data', [UserController::class, 'data'])->name('data');
        Route::get('/form/{id?}', [UserController::class, 'add'])->name('form');
        Route::post('/save', [UserController::class, 'store'])->name('save');
    });

    // Pacientes
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('/', [PatientController::class, 'index'])->name('index');
        Route::post('/data', [PatientController::class, 'data'])->name('data');
        Route::get('/form/{id?}', [PatientController::class, 'add'])->name('form');
        Route::post('/save', [PatientController::class, 'store'])->name('save');
        Route::post('/checkidentifier', [PatientController::class, 'checkidentifier'])->name('checkidentifier');
    });

    // Doctores
    Route::prefix('doctors')->name('doctors.')->group(function (): void {
        Route::get('/', [DoctorController::class, 'index'])->name('index');
        Route::post('/data', [DoctorController::class, 'data'])->name('data');
        Route::get('/form/{id?}', [DoctorController::class, 'add'])->name('form');
        Route::post('/save', [DoctorController::class, 'store'])->name('store');
        Route::get('/sethours/{id}', [DoctorController::class, 'setHours'])->name('sethours');
        Route::post('/checkspecialty', [DoctorController::class, 'checkSpecialty'])->name('checkspecialty');
        Route::post('/savehours', [DoctorController::class, 'saveHours'])->name('savehours');
    });

    // Especialidades
    Route::prefix('specialty')->name('specialty.')->group(function () {
        Route::get('/', [SpecialtyController::class, 'index'])->name('index');
        Route::post('/data', [SpecialtyController::class, 'data'])->name('data');
        Route::get('/form/{id?}', [SpecialtyController::class, 'add'])->name('form');
        Route::post('/save', [SpecialtyController::class, 'store'])->name('save');
        Route::get('/list', [SpecialtyController::class, 'list'])->name('list');
    });
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/connections', [ConnectionsController::class, 'index'])->name('connections');
        Route::get('/billing', [CustomerController::class, 'index'])->name('billing');
        Route::post('/save', [CustomerController::class, 'store'])->name('save');
    });
});
