<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\AdminManagementController;
use App\Http\Controllers\SuperAdmin\BranchManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\BranchAdmin\BranchDashboardController;
use App\Http\Controllers\BranchAdmin\BranchUserController;
use App\Http\Controllers\SuperAdmin\UserManagementController as SuperUserManagementController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| Branch Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:branch_admin'])
    ->prefix('branch')
    ->name('branch.')
    ->group(function () {

        Route::get('/', [BranchDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/users', [BranchUserController::class, 'index'])
            ->name('users.index');
    });



/*
|--------------------------------------------------------------------------
| Authenticated Users (All Roles)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Head Office Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', fn () => view('admin.dashboard'))->name('dashboard');

        Route::get('/users', [UserManagementController::class, 'listUsers'])
            ->name('users.index');
    });

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        Route::get('/', fn () => view('superadmin.dashboard'))->name('dashboard');

        /*
        |--------------------------------------------------------------
        | Admin Management (Head Admin + Branch Admin)
        |--------------------------------------------------------------
        */
        Route::prefix('admins')->name('admins.')->group(function () {

            Route::get('/', [AdminManagementController::class, 'index'])->name('index');
            Route::get('/create', [AdminManagementController::class, 'create'])->name('create');
            Route::post('/', [AdminManagementController::class, 'store'])->name('store');

            Route::get('/{admin}/edit', [AdminManagementController::class, 'edit'])->name('edit');
            Route::put('/{admin}', [AdminManagementController::class, 'update'])->name('update');
            Route::delete('/{admin}', [AdminManagementController::class, 'destroy'])->name('destroy');

            // status control
            Route::patch('/{admin}/suspend', [AdminManagementController::class, 'suspend'])->name('suspend');
            Route::patch('/{admin}/activate', [AdminManagementController::class, 'activate'])->name('activate');
        });

        /*
        |--------------------------------------------------------------
        | Branch Management
        |--------------------------------------------------------------
        */
        Route::prefix('branches')->name('branches.')->group(function () {
    Route::get('/', [BranchManagementController::class, 'index'])->name('index');
    Route::get('/create', [BranchManagementController::class, 'create'])->name('create');
    Route::post('/', [BranchManagementController::class, 'store'])->name('store');

    Route::get('/{branch}/edit', [BranchManagementController::class, 'edit'])->name('edit');
    Route::put('/{branch}', [BranchManagementController::class, 'update'])->name('update');

    // Soft delete (still your "Delete" button)
    Route::delete('/{branch}', [BranchManagementController::class, 'destroy'])->name('destroy');

    // Archive lifecycle
    Route::patch('/{branch}/archive', [BranchManagementController::class, 'archive'])->name('archive');
    Route::patch('/{branch}/restore', [BranchManagementController::class, 'restore'])->name('restore');

    // Soft-delete recovery + true permanent delete (restricted)
    Route::patch('/{id}/undelete', [BranchManagementController::class, 'undelete'])->name('undelete');
    Route::delete('/{id}/force-delete', [BranchManagementController::class, 'forceDelete'])->name('forceDelete');
});

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [SuperUserManagementController::class, 'index'])->name('index');
    Route::get('/create', [SuperUserManagementController::class, 'create'])->name('create');
    Route::post('/', [SuperUserManagementController::class, 'store'])->name('store');
});



        /*
        |--------------------------------------------------------------
        | Unified Account Creation (Admin / User)
        |--------------------------------------------------------------
        */
        Route::prefix('accounts')->name('accounts.')->group(function () {
            Route::get('/create', [UserManagementController::class, 'create'])->name('create');
            Route::post('/', [UserManagementController::class, 'store'])->name('store');
        });
    });

require __DIR__ . '/auth.php';
