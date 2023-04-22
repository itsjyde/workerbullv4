<?php

use App\Http\Controllers\Backend\Auth\Role\RoleController;
use App\Http\Controllers\Backend\Auth\User\UserAccessController;
use App\Http\Controllers\Backend\Auth\User\UserConfirmationController;
use App\Http\Controllers\Backend\Auth\User\UserController;
use App\Http\Controllers\Backend\Auth\User\UserPasswordController;
use App\Http\Controllers\Backend\Auth\User\UserSessionController;
use App\Http\Controllers\Backend\Auth\User\UserSocialController;
use App\Http\Controllers\Backend\Auth\User\UserStatusController;

/*
 * All route names are prefixed with 'admin.auth'.
 */
Route::prefix('auth')->name('auth.')->middleware('role:' . config('access.users.admin_role'))->group(function () {
    /*
     * User Management
     */
    /*
     * User Status'
     */
    Route::get('user/deactivated', [UserStatusController::class, 'getDeactivated'])->name('user.deactivated');
    Route::get('user/deleted', [UserStatusController::class, 'getDeleted'])->name('user.deleted');

    /*
     * User CRUD
     */
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::get('user/get-data', [UserController::class, 'getData'])->name('user.getData');
    Route::post('user', [UserController::class, 'store'])->name('user.store');

    /*
     * Specific User
     */
    Route::prefix('user/{user}')->group(function () {
        // User
        Route::get('/', [UserController::class, 'show'])->name('user.show');
        Route::get('edit', [UserController::class, 'edit'])->name('user.edit');
        Route::patch('/', [UserController::class, 'update'])->name('user.update');
        Route::delete('/', [UserController::class, 'destroy'])->name('user.destroy');

        // Account
        Route::get('account/confirm/resend', [UserConfirmationController::class, 'sendConfirmationEmail'])->name('user.account.confirm.resend');

        // Status
        Route::get('mark/{status}', [UserStatusController::class, 'mark'])->name('user.mark')->where(['status' => '[0,1]']);

        // Social
        Route::delete('social/{social}/unlink', [UserSocialController::class, 'unlink'])->name('user.social.unlink');

        // Confirmation
        Route::get('confirm', [UserConfirmationController::class, 'confirm'])->name('user.confirm');
        Route::get('unconfirm', [UserConfirmationController::class, 'unconfirm'])->name('user.unconfirm');

        // Password
        Route::get('password/change', [UserPasswordController::class, 'edit'])->name('user.change-password');
        Route::patch('password/change', [UserPasswordController::class, 'update'])->name('user.change-password.post');

        // Access
        Route::get('login-as', [UserAccessController::class, 'loginAs'])->name('user.login-as');

        // Session
        Route::get('clear-session', [UserSessionController::class, 'clearSession'])->name('user.clear-session');

        // Deleted
        Route::get('delete', [UserStatusController::class, 'delete'])->name('user.delete-permanently');
        Route::get('restore', [UserStatusController::class, 'restore'])->name('user.restore');
    });

    /*
     * Role Management
     */
    Route::get('role', [RoleController::class, 'index'])->name('role.index');
    Route::get('role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('role', [RoleController::class, 'store'])->name('role.store');

    Route::prefix('role/{role}')->group(function () {
        Route::get('edit', [RoleController::class, 'edit'])->name('role.edit');
        Route::patch('/', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/', [RoleController::class, 'destroy'])->name('role.destroy');
    });
});
