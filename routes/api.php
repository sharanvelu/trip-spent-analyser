<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SpaceController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\UserTripsController;
use App\Http\Controllers\Api\TripUsersController;
use App\Http\Controllers\Api\UserSpacesController;
use App\Http\Controllers\Api\SpaceTripsController;
use App\Http\Controllers\Api\SpaceUsersController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserExpensesController;
use App\Http\Controllers\Api\TripExpensesController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('users', UserController::class);

        // User Spaces Owned
        Route::get('/users/{user}/spaces', [
            UserSpacesController::class,
            'index',
        ])->name('users.spaces.index');
        Route::post('/users/{user}/spaces', [
            UserSpacesController::class,
            'store',
        ])->name('users.spaces.store');

        // User Expenses
        Route::get('/users/{user}/expenses', [
            UserExpensesController::class,
            'index',
        ])->name('users.expenses.index');
        Route::post('/users/{user}/expenses', [
            UserExpensesController::class,
            'store',
        ])->name('users.expenses.store');

        // User Trips
        Route::get('/users/{user}/trips', [
            UserTripsController::class,
            'index',
        ])->name('users.trips.index');
        Route::post('/users/{user}/trips', [
            UserTripsController::class,
            'store',
        ])->name('users.trips.store');

        // User Spaces
        Route::get('/users/{user}/spaces', [
            UserSpacesController::class,
            'index',
        ])->name('users.spaces.index');
        Route::post('/users/{user}/spaces/{space}', [
            UserSpacesController::class,
            'store',
        ])->name('users.spaces.store');
        Route::delete('/users/{user}/spaces/{space}', [
            UserSpacesController::class,
            'destroy',
        ])->name('users.spaces.destroy');

        // User Trips2
        Route::get('/users/{user}/trips', [
            UserTripsController::class,
            'index',
        ])->name('users.trips.index');
        Route::post('/users/{user}/trips/{trip}', [
            UserTripsController::class,
            'store',
        ])->name('users.trips.store');
        Route::delete('/users/{user}/trips/{trip}', [
            UserTripsController::class,
            'destroy',
        ])->name('users.trips.destroy');

        Route::apiResource('spaces', SpaceController::class);

        // Space Trips
        Route::get('/spaces/{space}/trips', [
            SpaceTripsController::class,
            'index',
        ])->name('spaces.trips.index');
        Route::post('/spaces/{space}/trips', [
            SpaceTripsController::class,
            'store',
        ])->name('spaces.trips.store');

        // Space Users
        Route::get('/spaces/{space}/users', [
            SpaceUsersController::class,
            'index',
        ])->name('spaces.users.index');
        Route::post('/spaces/{space}/users/{user}', [
            SpaceUsersController::class,
            'store',
        ])->name('spaces.users.store');
        Route::delete('/spaces/{space}/users/{user}', [
            SpaceUsersController::class,
            'destroy',
        ])->name('spaces.users.destroy');

        Route::apiResource('trips', TripController::class);

        // Trip Expenses
        Route::get('/trips/{trip}/expenses', [
            TripExpensesController::class,
            'index',
        ])->name('trips.expenses.index');
        Route::post('/trips/{trip}/expenses', [
            TripExpensesController::class,
            'store',
        ])->name('trips.expenses.store');

        // Trip Users
        Route::get('/trips/{trip}/users', [
            TripUsersController::class,
            'index',
        ])->name('trips.users.index');
        Route::post('/trips/{trip}/users/{user}', [
            TripUsersController::class,
            'store',
        ])->name('trips.users.store');
        Route::delete('/trips/{trip}/users/{user}', [
            TripUsersController::class,
            'destroy',
        ])->name('trips.users.destroy');

        Route::apiResource('expenses', ExpenseController::class);
    });
