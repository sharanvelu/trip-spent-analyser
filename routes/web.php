<?php

use App\Http\Controllers\ExpenseSplitController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PermissionController;
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
    return redirect()->route('spaces.index');
});

\Illuminate\Support\Facades\Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('users', UserController::class);
        Route::resource('spaces', SpaceController::class);
        Route::prefix('spaces/{space}')->group(function () {
            Route::resource('trips', TripController::class);
            Route::prefix('trips/{trip}')->group(function () {
                Route::resource('expenses', ExpenseController::class);
                Route::get('expense_split', [ExpenseSplitController::class, 'index'])->name('expenses.split');
            });
        });
    });
