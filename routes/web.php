<?php

use App\EnumHelpers\EnumColumnAccess;
use App\EnumHelpers\EnumMenus;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'index'])->name('admin.login.index');
Route::post('/login/action/login', [\App\Http\Controllers\Admin\AuthController::class, 'actionLogin'])->name('admin.login.action-login');

Route::middleware(['checkAuthAdmin'])->group(function () {

    Route::get('/admin/logout/action/logout', [\App\Http\Controllers\Admin\LogoutController::class, 'actionLogout'])->name('admin.logout.action-logout');

    Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard.index');

    //profile
    Route::prefix('admin/profile')->group(function () {
        Route::get('index', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('admin.profile.index');
        Route::get('edit', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('edit/action', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.edit.action');
        Route::get('edit-password', [\App\Http\Controllers\Admin\ProfileController::class, 'editPassword'])->name('admin.profile.change-password.index');
        Route::put('edit-password/action', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('admin.profile.change-password.edit.action');
    });

    //user
    Route::prefix('admin/users')->group(function () {
        Route::get('index', [\App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('admin.user-management.index')->middleware('checkActionMenuPrivilage:' . EnumMenus::_USER_MANAGEMENT_ID);
        Route::get('add', [\App\Http\Controllers\Admin\UserManagementController::class, 'create'])->name('admin.user-management.add')->middleware('checkActionMenuPrivilage:' . EnumMenus::_USER_MANAGEMENT_ID . ',' . EnumColumnAccess::IS_CREATE);
        Route::post('add/action', [\App\Http\Controllers\Admin\UserManagementController::class, 'store'])->name('admin.user-management.add.action')->middleware('checkActionMenuPrivilage:' . EnumMenus::_USER_MANAGEMENT_ID . ',' . EnumColumnAccess::IS_CREATE);
        Route::get('show/{id}', [\App\Http\Controllers\Admin\UserManagementController::class, 'show'])->name('admin.user-management.show')->middleware('checkActionMenuPrivilage:' . EnumMenus::_USER_MANAGEMENT_ID . ',' . EnumColumnAccess::IS_READ);
        Route::get('edit/{id}', [\App\Http\Controllers\Admin\UserManagementController::class, 'edit'])->name('admin.user-management.edit')->middleware('checkActionMenuPrivilage:' . EnumMenus::_USER_MANAGEMENT_ID . ',' . EnumColumnAccess::IS_UPDATE);
        Route::put('edit/{id}/action', [\App\Http\Controllers\Admin\UserManagementController::class, 'update'])->name('admin.user-management.edit.action')->middleware('checkActionMenuPrivilage:' . EnumMenus::_USER_MANAGEMENT_ID . ',' . EnumColumnAccess::IS_UPDATE);
        Route::get('edit-password/{id}', [\App\Http\Controllers\Admin\UserManagementController::class, 'editPassword'])->name('admin.user-management.edit-password')->middleware('checkActionMenuPrivilage:' . EnumMenus::_USER_MANAGEMENT_ID . ',' . EnumColumnAccess::IS_UPDATE);
        Route::put('edit-password/{id}/action', [\App\Http\Controllers\Admin\UserManagementController::class, 'updatePassword'])->name('admin.user-management.edit-password.action')->middleware('checkActionMenuPrivilage:' . EnumMenus::_USER_MANAGEMENT_ID . ',' . EnumColumnAccess::IS_UPDATE);
        Route::post('api/pagination', [\App\Http\Controllers\Admin\UserManagementController::class, 'apiPagination'])->name('admin.user-management.api.pagination.action')->middleware('checkActionMenuPrivilage:' . EnumMenus::_USER_MANAGEMENT_ID . ',' . EnumColumnAccess::IS_READ);
    });

});