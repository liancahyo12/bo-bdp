<?php

use App\Http\Controllers\Boilerplate\Auth\ForgotPasswordController;
use App\Http\Controllers\Boilerplate\Auth\LoginController;
use App\Http\Controllers\Boilerplate\Auth\RegisterController;
use App\Http\Controllers\Boilerplate\Auth\ResetPasswordController;
use App\Http\Controllers\Boilerplate\DatatablesController;
use App\Http\Controllers\Boilerplate\LanguageController;
use App\Http\Controllers\Boilerplate\Logs\LogViewerController;
use App\Http\Controllers\Boilerplate\Users\RolesController;
use App\Http\Controllers\Boilerplate\Users\UsersController;
use App\Http\Controllers\ApprovepengajuanController;
use App\Http\Controllers\CekpengajuanController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\SuratkeluarController;

Route::group([
    'prefix'     => config('boilerplate.app.prefix', ''),
    'domain'     => config('boilerplate.app.domain', ''),
    'middleware' => ['web', 'boilerplatelocale'],
    'as'         => 'boilerplate.',
], function () {
    // Dashboard
    Route::get('/', [config('boilerplate.menu.dashboard'), 'index'])
        ->middleware(['boilerplateauth', 'ability:admin,backend_access'])
        ->name('dashboard');

    Route::post('keep-alive', [UsersController::class, 'keepAlive'])->name('keepalive');
    Route::get('lang/{lang}', [LanguageController::class, 'switch'])->name('lang.switch');

    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['boilerplateguest']], function () {
        // Login
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.post');

        // Registration
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register'])->name('register.post');

        // Password reset
        Route::get('password/request', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset.post');
    });

    // First login
    Route::get('connect/{token?}', [UsersController::class, 'firstLogin'])->name('users.firstlogin');
    Route::post('connect/{token?}', [UsersController::class, 'firstLoginPost'])->name('users.firstlogin.post');

    // Backend
    Route::group(['middleware' => ['boilerplateauth', 'ability:admin,backend_access']], function () {
        // Datatables
        Route::post('datatables/{slug}', [DatatablesController::class, 'make'])->name('datatables');

        // Roles and users
        Route::resource('roles', RolesController::class)->except('show')->middleware(['ability:admin,roles_crud']);
        Route::group(['middleware' => ['ability:admin,users_crud']], function () {
            Route::resource('users', UsersController::class)->except('show');
            Route::any('users/dt', [UsersController::class, 'datatable'])->name('users.datatable');
        });
        Route::get('userprofile', [UsersController::class, 'profile'])->name('user.profile');
        Route::post('userprofile', [UsersController::class, 'profilePost'])->name('user.profile.post');
        Route::post('userprofile/settings', [UsersController::class, 'storeSetting'])->name('settings');

        // Avatar
        Route::get('userprofile/avatar/url', [UsersController::class, 'getAvatarUrl'])->name('user.avatar.url');
        Route::post('userprofile/avatar/upload', [UsersController::class, 'avatarUpload'])->name('user.avatar.upload');
        Route::post('userprofile/avatar/gravatar', [UsersController::class, 'getAvatarFromGravatar'])->name('user.avatar.gravatar');
        Route::post('userprofile/avatar/delete', [UsersController::class, 'avatarDelete'])->name('user.avatar.delete');

        // Logs
        Route::group(['prefix' => 'logs', 'as' => 'logs.'], function () {
            Route::get('/', [LogViewerController::class, 'index'])->name('dashboard');
            Route::group(['prefix' => 'list'], function () {
                Route::get('/', [LogViewerController::class, 'listLogs'])->name('list');
                Route::delete('delete', [LogViewerController::class, 'delete'])->name('delete');

                Route::group(['prefix' => '{date}'], function () {
                    Route::get('/', [LogViewerController::class, 'show'])->name('show');
                    Route::get('download', [LogViewerController::class, 'download'])->name('download');
                    Route::get('{level}', [LogViewerController::class, 'showByLevel'])->name('filter');
                });
            });
        });
         // Approval
        Route::get('/pengajuan', [PengajuanController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,pengajuan'])
            ->name('pengajuan');
        Route::get('/review-pengajuan', [CekpengajuanController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,review_pengajuan'])
            ->name('review-pengajuan');
        Route::get('/approve-pengajuan', [ApprovepengajuanController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,approve_pengajuan'])
            ->name('approve-pengajuan');

        //surat keluar
        Route::get('/surat-keluar-buat', [SuratkeluarController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,backend_access'])
            ->name('surat-keluar-buat');
        Route::post('/surat-keluar-buat', [SuratkeluarController::class, 'store'])
            ->middleware(['boilerplateauth', 'ability:admin,backend_access'])
            ->name('surat-keluar-buat');
        Route::group(['middleware' => ['ability:admin,backend_access']], function () {
            Route::resource('surat-keluar-saya', SuratkeluarController::class)->except('show');
        });
        Route::get('/surat-keluar-edit/{id}', [SuratkeluarController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,backend_access'])
            ->name('surat-keluar-edit');
        Route::get('/surat-keluar-review', [SuratkeluarController::class, 'review'])
            ->middleware(['boilerplateauth', 'ability:admin,backend_access,review_surat'])
            ->name('surat-keluar-review');
        Route::get('/surat-keluar-approve', [SuratkeluarController::class, 'approve'])
            ->middleware(['boilerplateauth', 'ability:admin,backend_access,approve_surat'])
            ->name('surat-keluar-approve');
        Route::get('/surat-keluar-arsip', [SuratkeluarController::class, 'arsip'])
            ->middleware(['boilerplateauth', 'ability:admin,backend_access,arsip_surat'])
            ->name('surat-keluar-arsip');
    });
});
