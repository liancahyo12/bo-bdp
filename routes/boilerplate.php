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
use App\Http\Controllers\BayarpengajuanController;
use App\Http\Controllers\CekpengajuanController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\SuratkeluarController;
use App\Http\Controllers\SuratmasukController;
use App\Http\Controllers\ReviewsuratkeluarController;
use App\Http\Controllers\ApprovesuratkeluarController;
use App\Http\Controllers\RequestSuratKeluarController;
use App\Http\Controllers\ArsipSuratKeluarController;
use App\Http\Controllers\ReviewdeppengajuanController;
use App\Http\Controllers\ReviewpengajuanController;
use App\Http\Controllers\ClosingController;
use App\Http\Controllers\ReviewdepclosingController;
use App\Http\Controllers\ReviewclosingController;
use App\Http\Controllers\ApproveclosingController;
use App\Http\Controllers\Rek_userController;
use App\Http\Controllers\LogReportController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DepartemenController;

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

        // Rekening Karyawan
        Route::get('/karyawan', [KaryawanController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_karyawan,detail_karyawan,nonaktif_karyawan,hapus_karyawan'])
            ->name('karyawan');
        Route::get('/edit-karyawan', [KaryawanController::class, 'edit'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_karyawan'])
            ->name('edit-karyawan');
        Route::put('/update-karyawan', [KaryawanController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_karyawan'])
            ->name('update-karyawan');
        Route::get('/detail-karyawan', [KaryawanController::class, 'show'])
            ->middleware(['boilerplateauth', 'ability:admin,detail_karyawan'])
            ->name('detail-karyawan');
        Route::put('/nonaktif-karyawan', [KaryawanController::class, 'nonaktif'])
            ->middleware(['boilerplateauth', 'ability:admin,nonaktif_karyawan'])
            ->name('nonaktif-karyawan');
        Route::delete('/delete-karyawan', [KaryawanController::class, 'destroy'])
            ->middleware(['boilerplateauth', 'ability:admin,hapus_karyawan'])
            ->name('delete-karyawan');


         // Pengajuan
        Route::get('/saya-pengajuan', [PengajuanController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('saya-pengajuan');
        Route::get('/buat-pengajuan', [PengajuanController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('buat-pengajuan');
        Route::post('/buat-pengajuan', [PengajuanController::class, 'store'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('buat-pengajuan');
        Route::get('/edit-pengajuan/{id}', [PengajuanController::class, 'edit'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('edit-pengajuan');
        Route::get('/edit-pengajuan-lampiran/{id}', [PengajuanController::class, 'unduh_lampiran'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('edit-pengajuan-lampiran');
        Route::get('/edit-pengajuan-bukti/{id}', [PengajuanController::class, 'unduh_bukti'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('edit-pengajuan-bukti');
        Route::get('/edit-pengajuan-jadi/{id}', [PengajuanController::class, 'unduh_pengajuan'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('edit-pengajuan-jadi');
        Route::put('/edit-pengajuan/{id}', [PengajuanController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('update-pengajuan');
        Route::delete('/edit-pengajuan-hapus/{id}', [PengajuanController::class, 'destroy'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('edit-pengajuan-hapus');

        // reviewdep pengajuan
        Route::get('/reviewdep-pengajuan', [ReviewdeppengajuanController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,reviewdep_pengajuan'])
            ->name('reviewdep-pengajuan');
        Route::get('/detail-reviewdep-pengajuan/{id}', [ReviewdeppengajuanController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,reviewdep_pengajuan'])
            ->name('detail-reviewdep-pengajuan');
        Route::put('/update-reviewdep-pengajuan/{id}', [ReviewdeppengajuanController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,reviewdep_pengajuan'])
            ->name('update-reviewdep-pengajuan');
        Route::get('/detail-reviewdep-pengajuan-lampiran/{id}', [ReviewdeppengajuanController::class, 'unduh_lampiran'])
            ->middleware(['boilerplateauth', 'ability:admin,reviewdep_pengajuan'])
            ->name('detail-reviewdep-pengajuan-lampiran');

        // review pengajuan
        Route::get('/review-pengajuan', [ReviewpengajuanController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,review_pengajuan'])
            ->name('review-pengajuan');
        Route::get('/detail-review-pengajuan/{id}', [ReviewpengajuanController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,review_pengajuan'])
            ->name('detail-review-pengajuan');
        Route::put('/update-review-pengajuan/{id}', [ReviewpengajuanController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,review_pengajuan'])
            ->name('update-review-pengajuan');
        Route::get('/detail-review-pengajuan-lampiran/{id}', [ReviewpengajuanController::class, 'unduh_lampiran'])
            ->middleware(['boilerplateauth', 'ability:admin,review_pengajuan'])
            ->name('detail-review-pengajuan-lampiran');
            
        // approve pengajuan
        Route::get('/approve-pengajuan', [ApprovepengajuanController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,approve_pengajuan'])
            ->name('approve-pengajuan');
        Route::get('/detail-approve-pengajuan/{id}', [ApprovepengajuanController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,approve_pengajuan'])
            ->name('detail-approve-pengajuan');
        Route::put('/update-approve-pengajuan/{id}', [ApprovepengajuanController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,approve_pengajuan'])
            ->name('update-approve-pengajuan');
        Route::get('/detail-approve-pengajuan-lampiran/{id}', [ApprovepengajuanController::class, 'unduh_lampiran'])
            ->middleware(['boilerplateauth', 'ability:admin,approve_pengajuan'])
            ->name('detail-approve-pengajuan-lampiran');
        
        // bayar pengajuan
        Route::get('/bayar-pengajuan', [BayarpengajuanController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,bayar_pengajuan'])
            ->name('bayar-pengajuan');
        Route::get('/detail-bayar-pengajuan/{id}', [BayarpengajuanController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,bayar_pengajuan'])
            ->name('detail-bayar-pengajuan');
        Route::put('/update-bayar-pengajuan/{id}', [BayarpengajuanController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,bayar_pengajuan'])
            ->name('update-bayar-pengajuan');
        Route::get('/detail-bayar-pengajuan-lampiran/{id}', [BayarpengajuanController::class, 'unduh_lampiran'])
            ->middleware(['boilerplateauth', 'ability:admin,bayar_pengajuan'])
            ->name('detail-bayar-pengajuan-lampiran');
        Route::get('/detail-bayar-pengajuan-bukti/{id}', [BayarpengajuanController::class, 'unduh_bukti'])
            ->middleware(['boilerplateauth', 'ability:admin,bayar_pengajuan'])
            ->name('detail-bayar-pengajuan-bukti');
        Route::get('/detail-bayar-pengajuan-jadi/{id}', [BayarpengajuanController::class, 'unduh_jadi'])
            ->middleware(['boilerplateauth', 'ability:admin,bayar_pengajuan'])
            ->name('detail-bayar-pengajuan-jadi');

        // closing saya
        Route::get('/saya-closing-pengajuan', [ClosingController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('saya-closing-pengajuan');
        Route::get('/buat-closing-pengajuan/{id}', [ClosingController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('buat-closing-pengajuan');
        Route::post('/buat-closing-pengajuan/{id}', [ClosingController::class, 'store'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('buat-closing-pengajuan');
        Route::get('/edit-closing-pengajuan/{id}', [ClosingController::class, 'edit'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('edit-closing-pengajuan');
        Route::put('/update-closing-pengajuan/{id}', [ClosingController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('update-closing-pengajuan');
        Route::get('/edit-closing-pengajuan-lampiran/{id}', [ClosingController::class, 'unduh_lampiran'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('edit-closing-pengajuan-lampiran');
        Route::put('/pengembalian-closing-pengajuan/{id}', [ClosingController::class, 'update_pengembalian'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('pengembalian-closing-pengajuan');
        Route::get('/pengembalian-closing-pengajuan-bukti/{id}', [ClosingController::class, 'unduh_bukti_pengembalian'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pengajuan'])
            ->name('edit-closing-pengajuan-lampiran');

        // reviewdep closing
        Route::get('/reviewdep-closing-pengajuan', [ReviewdepclosingController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,reviewdep_pengajuan'])
            ->name('reviewdep-closing-pengajuan');
        Route::get('/detail-reviewdep-closing-pengajuan/{id}', [ReviewdepclosingController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,reviewdep_pengajuan'])
            ->name('detail-reviewdep-closing-pengajuan');
        Route::put('/update-reviewdep-closing-pengajuan/{id}', [ReviewdepclosingController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,reviewdep_pengajuan'])
            ->name('update-reviewdep-closing-pengajuan');
        Route::get('/detail-reviewdep-closing-pengajuan-lampiran/{id}', [ReviewdepclosingController::class, 'unduh_lampiran'])
            ->middleware(['boilerplateauth', 'ability:admin,reviewdep_pengajuan'])
            ->name('detail-reviewdep-closing-pengajuan-lampiran');

        // review closing
        Route::get('/review-closing-pengajuan', [ReviewclosingController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,review_pengajuan'])
            ->name('review-closing-pengajuan');
        Route::get('/detail-review-closing-pengajuan/{id}', [ReviewclosingController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,review_pengajuan'])
            ->name('detail-review-closing-pengajuan');
        Route::put('/update-review-closing-pengajuan/{id}', [ReviewclosingController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,review_pengajuan'])
            ->name('update-review-closing-pengajuan');
        Route::get('/detail-review-closing-pengajuan-lampiran/{id}', [ReviewclosingController::class, 'unduh_lampiran'])
            ->middleware(['boilerplateauth', 'ability:admin,review_pengajuan'])
            ->name('detail-review-closing-pengajuan-lampiran');
        Route::get('/detail-review-closing-pengajuan-pengembalian/{id}', [ReviewclosingController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,review_pengajuan'])
            ->name('detail-review-closing-pengajuan-pengembalian');
        Route::get('/detail-review-closing-pengajuan-bukti/{id}', [ReviewclosingController::class, 'unduh_bukti_pengembalian'])
            ->middleware(['boilerplateauth', 'ability:admin,review_pengajuan'])
            ->name('detail-review-closing-pengajuan-lampiran');
            
        // approve closing
        Route::get('/approve-closing-pengajuan', [ApproveclosingController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,approve_pengajuan'])
            ->name('approve-closing-pengajuan');
        Route::get('/detail-approve-closing-pengajuan/{id}', [ApproveclosingController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,approve_pengajuan'])
            ->name('detail-approve-closing-pengajuan');
        Route::put('/update-approve-closing-pengajuan/{id}', [ApproveclosingController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,approve_pengajuan'])
            ->name('update-approve-closing-pengajuan');
        Route::get('/detail-approve-closing-pengajuan-lampiran/{id}', [ApproveclosingController::class, 'unduh_lampiran'])
            ->middleware(['boilerplateauth', 'ability:admin,approve_pengajuan'])
            ->name('detail-approve-closing-pengajuan-lampiran');

        //request surat keluar
        Route::get('/surat-keluar-request-buat', [RequestSuratKeluarController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,request_surat_keluar'])
            ->name('surat-keluar-request-buat');
        Route::post('/surat-keluar-request-buat', [RequestSuratKeluarController::class, 'store'])
            ->middleware(['boilerplateauth', 'ability:admin,request_surat_keluar'])
            ->name('surat-keluar-request-buat');
        
        //request surat keluar saya
        Route::group(['middleware' => ['ability:admin,request_surat_keluar']], function () {
            Route::resource('surat-keluar-request-saya', RequestSuratKeluarController::class)->except('show');
            Route::any('surat-keluar-request-saya/dt', [RequestSuratKeluarController::class, 'datatable'])->name('surat-keluar-request-saya');
        });
        Route::get('/surat-keluar-request-saya/{id}', [RequestSuratKeluarController::class, 'edit'])
            ->middleware(['boilerplateauth', 'ability:admin,request_surat_keluar'])
            ->name('surat-keluar-request-saya');
        Route::get('/surat-keluar-request-lampiran/{id}', [RequestSuratKeluarController::class, 'download'])
            ->middleware(['boilerplateauth', 'ability:admin,request_surat_keluar'])
            ->name('surat-keluar-request-lampiran');
        Route::get('/surat-keluar-request-suratkeluar/{id}', [RequestSuratKeluarController::class, 'download_suratkeluar'])
            ->middleware(['boilerplateauth', 'ability:admin,request_surat_keluar'])
            ->name('surat-keluar-request-suratkeluar');
        Route::put('/surat-keluar-request-saya/{id}', [RequestSuratKeluarController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,request_surat_keluar'])
            ->name('surat-keluar-request-saya');

        //request surat keluar review
        Route::get('/surat-keluar-request-review', [RequestSuratKeluarController::class, 'show'])
            ->middleware(['boilerplateauth', 'ability:admin,review_surat'])
            ->name('surat-keluar-request-review');
        Route::get('/surat-keluar-request-review-lampiran/{id}', [RequestSuratKeluarController::class, 'download_review'])
            ->middleware(['boilerplateauth', 'ability:admin,review_surat'])
            ->name('surat-keluar-request-review-lampiran');
        Route::get('/surat-keluar-request-review/{id}', [RequestSuratKeluarController::class, 'review'])
            ->middleware(['boilerplateauth', 'ability:admin,review_surat'])
            ->name('surat-keluar-request-review.edit');
        Route::put('/surat-keluar-request-review/{id}', [RequestSuratKeluarController::class, 'update_review'])
            ->middleware(['boilerplateauth', 'ability:admin,review_surat'])
            ->name('surat-keluar-request-review.review');

        //surat keluar
        Route::get('/surat-keluar-buat', [SuratkeluarController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_keluar'])
            ->name('surat-keluar-buat');
        Route::get('/surat-keluar-buat-format/{id}', [SuratkeluarController::class, 'unduh_format'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_keluar'])
            ->name('surat-keluar-buat-format');
        Route::get('/surat-keluar-buat/{id}', [SuratkeluarController::class, 'create_request'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_keluar'])
            ->name('surat-keluar-buat');
        Route::put('/surat-keluar-buata/{id}', [SuratkeluarController::class, 'store_request'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_keluar'])
            ->name('surat-keluar-buata');
        Route::post('/surat-keluar-buat', [SuratkeluarController::class, 'store'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_keluar'])
            ->name('surat-keluar-buat');
        
        // surat keluar saya
        Route::group(['middleware' => ['ability:admin,backend_access']], function () {
            Route::resource('surat-keluar-saya', SuratkeluarController::class)->except('show');
            Route::any('surat-keluar-saya/dt', [SuratkeluarController::class, 'datatable'])->name('surat-keluar-saya');
        });
        Route::get('/surat-keluar-edit', [SuratkeluarController::class, 'edit'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_keluar'])
            ->name('surat-keluar-edit');
        Route::get('/surat-keluar-detail/{id}', [SuratkeluarController::class, 'detail'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_keluar'])
            ->name('surat-keluar-detail');
        Route::get('/surat-keluar-lampiran/{id}', [SuratkeluarController::class, 'unduh_lampiran'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_keluar'])
            ->name('surat-keluar-lampiran');
        Route::get('/surat-keluar-surat-lama/{id}', [SuratkeluarController::class, 'unduh_surat_lama'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_keluar'])
            ->name('surat-keluar-lampiran');
        Route::get('/surat-keluar-surat-jadi/{id}', [SuratkeluarController::class, 'unduh_surat_jadi'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_keluar'])
            ->name('surat-keluar-jadi');
        Route::put('/surat-keluar-edit/{id}', [SuratkeluarController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_keluar'])
            ->name('surat-keluar-edit');
        Route::delete('/surat-keluar-delete/{id}', [SuratkeluarController::class, 'destroy'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_keluar'])
            ->name('surat-keluar-delete');

        // surat keluar review
        Route::group(['middleware' => ['ability:admin,review_surat']], function () {
            Route::resource('surat-keluar-review', ReviewsuratkeluarController::class)->except('show');
            Route::any('surat-keluar-review/dt', [ReviewsuratkeluarController::class, 'datatable'])->name('surat-keluar-review');
        });
        // Route::get('/surat-keluar-review', [ReviewsuratkeluarController::class, 'edit'])
        //     ->middleware(['boilerplateauth', 'ability:admin,backend_access,review_surat'])
        //     ->name('surat-keluar-review');
        Route::get('/surat-keluar-review/{id}', [ReviewsuratkeluarController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,review_surat'])
            ->name('surat-keluar-review.edit');
        Route::put('/surat-keluar-review/{id}', [ReviewsuratkeluarController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,review_surat'])
            ->name('surat-keluar-review.review');

        //surat keluar approve    
        Route::group(['middleware' => ['ability:admin,approve_surat']], function () {
            Route::resource('surat-keluar-approve', ApprovesuratkeluarController::class)->except('show');
            Route::any('surat-keluar-approve/dt', [ApprovesuratkeluarController::class, 'datatable'])->name('surat-keluar-approve');
        });
        // Route::get('/surat-keluar-approve', [ApprovesuratkeluarController::class, 'approve'])
        //     ->middleware(['boilerplateauth', 'ability:admin,backend_access,approve_surat'])
        //     ->name('surat-keluar-approve');
        Route::get('/surat-keluar-approve/{id}', [ApprovesuratkeluarController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,approve_surat'])
            ->name('surat-keluar-approve.edit');
        Route::get('/surat-keluar-approve-lampiran/{id}', [ApprovesuratkeluarController::class, 'unduh_lampiran'])
            ->middleware(['boilerplateauth', 'ability:admin,approve_surat'])
            ->name('surat-keluar-approve-lampiran');
        Route::get('/surat-keluar-approve-preview/{id}', [ApprovesuratkeluarController::class, 'preview_surat'])
            ->middleware(['boilerplateauth', 'ability:admin,approve_surat'])
            ->name('surat-keluar-approve-preview');
        Route::put('/surat-keluar-approve/{id}', [ApprovesuratkeluarController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,approve_surat'])
            ->name('surat-keluar-approve.approve');

        
        Route::get('/surat-keluar-arsip', [ArsipSuratKeluarController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,arsip_surat'])
            ->name('surat-keluar-arsip');
        Route::get('/surat-keluar-arsip/{id}', [ArsipSuratKeluarController::class, 'show'])
            ->middleware(['boilerplateauth', 'ability:admin,arsip_surat'])
            ->name('surat-keluar-arsip-edit');
        Route::put('/surat-keluar-arsip/{id}', [ArsipSuratKeluarController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,arsip_surat'])
            ->name('surat-keluar-arsip-update');
        Route::get('/surat-keluar-arsip-lampiran/{id}', [ArsipSuratKeluarController::class, 'unduh_lampiran'])
            ->middleware(['boilerplateauth', 'ability:admin,arsip_surat'])
            ->name('surat-keluar-arsip-lampiran');
        Route::get('/surat-keluar-surat/{id}', [ArsipSuratKeluarController::class, 'unduh_surat'])
            ->middleware(['boilerplateauth', 'ability:admin,arsip_surat'])
            ->name('surat-keluar-surat');
        Route::get('/surat-keluar-surat-scan/{id}', [ArsipSuratKeluarController::class, 'unduh_surat_scan'])
            ->middleware(['boilerplateauth', 'ability:admin,arsip_surat'])
            ->name('surat-keluar-surat-scan');

        //surat masuk
        Route::get('/surat-masuk-buat', [SuratmasukController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_masuk'])
            ->name('surat-masuk-buat');
        Route::post('/surat-masuk-buat', [SuratmasukController::class, 'store'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_masuk'])
            ->name('surat-masuk-buat');
        Route::get('/surat-masuk-saya', [SuratmasukController::class, 'saya'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_masuk'])
            ->name('surat-masuk-saya');
        Route::get('/surat-masuk-edit/{id}', [SuratmasukController::class, 'edit'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_masuk'])
            ->name('surat-masuk-edit');
        Route::get('/surat-masuk-saya-detail/{id}', [SuratmasukController::class, 'detail_saya'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_masuk'])
            ->name('surat-masuk-saya-detail');
        Route::get('/surat-masuk', [SuratmasukController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,surat_masuk'])
            ->name('surat-masuk');
        Route::get('/surat-masuk-detail/{id}', [SuratmasukController::class, 'detail'])
            ->middleware(['boilerplateauth', 'ability:admin,surat_masuk'])
            ->name('surat-masuk-detail');
        Route::get('/surat-masuk-arsip', [SuratmasukController::class, 'arsip'])
            ->middleware(['boilerplateauth', 'ability:admin,arsip_surat_masuk'])
            ->name('surat-masuk-arsip');
        Route::get('/surat-masuk-arsip-detail/{id}', [SuratmasukController::class, 'detail_arsip'])
            ->middleware(['boilerplateauth', 'ability:admin,arsip_surat_masuk'])
            ->name('surat-masuk-arsip-detail');
        Route::get('/surat-masuk-file-arsip/{id}', [SuratmasukController::class, 'file_arsip'])
            ->middleware(['boilerplateauth', 'ability:admin,arsip_surat_masuk'])
            ->name('surat-masuk-file-arsip');
        Route::get('/surat-masuk-file-saya/{id}', [SuratmasukController::class, 'file_saya'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_surat_masuk'])
            ->name('surat-masuk-file-saya');
        Route::get('/surat-masuk-file/{id}', [SuratmasukController::class, 'file'])
            ->middleware(['boilerplateauth', 'ability:admin,surat_masuk'])
            ->name('surat-masuk-file');

        // log report
        Route::get('/log-report-pengajuan-saya', [LogReportController::class, 'lr_pengajuan_saya'])
            ->middleware(['boilerplateauth', 'ability:admin,log_report_pengajuan_saya'])
            ->name('log-report-pengajuan-saya');
        Route::get('/log-report-pengajuan', [LogReportController::class, 'lr_pengajuan'])
            ->middleware(['boilerplateauth', 'ability:admin,log_report_pengajuan'])
            ->name('log-report-pengajuan');
        Route::get('/log-report-suratkeluar-saya', [LogReportController::class, 'lr_suratkeluar_saya'])
            ->middleware(['boilerplateauth', 'ability:admin,log_report_suratkeluar_saya'])
            ->name('log-report-suratkeluar-saya');
        Route::get('/log-report-suratkeluar', [LogReportController::class, 'lr_suratkeluar'])
            ->middleware(['boilerplateauth', 'ability:admin,log_report_suratkeluar'])
            ->name('log-report-suratkeluar');
        Route::get('/log-report-closing-saya', [LogReportController::class, 'lr_closing_saya'])
            ->middleware(['boilerplateauth', 'ability:admin,log_report_closing_saya'])
            ->name('log-report-closing-saya');
        Route::get('/log-report-closing', [LogReportController::class, 'lr_closing'])
            ->middleware(['boilerplateauth', 'ability:admin,log_report_closing'])
            ->name('log-report-closing');

        //departemen
        Route::get('/departemen', [DepartemenController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,lihat_departemen'])
            ->name('departemen');
        Route::get('/buat-departemen', [DepartemenController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_departemen'])
            ->name('buat-departemen');
        Route::post('/buat-departemen', [DepartemenController::class, 'store'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_departemen'])
            ->name('store-departemen');
        Route::get('/edit-departemen/{id}', [DepartemenController::class, 'edit'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_departemen'])
            ->name('edit-departemen');
        Route::put('/edit-departemen/{id}', [DepartemenController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_departemen'])
            ->name('update-departemen');
        Route::delete('/delete-departemen/{id}', [DepartemenController::class, 'destroy'])
            ->middleware(['boilerplateauth', 'ability:admin,hapus_departemen'])
            ->name('delete-departemen');
    });
});
    