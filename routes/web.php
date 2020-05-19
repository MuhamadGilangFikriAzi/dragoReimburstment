<?php

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
    return view('auth/login');
});

Auth::routes();

Route::get('view-data', 'AuthorizationController@viewData');
Route::get('create-data', 'AuthorizationController@createData');
Route::get('edit-data', 'AuthorizationController@editData');
Route::get('update-data', 'AuthorizationController@updateData');
Route::get('delete-data', 'AuthorizationController@deleteData');

Route::middleware('auth:web')->group(function () {

    Route::prefix('home')->group(function () {
        Route::get('/', 'HomeController@index')->name('home.index');
        Route::get('{user}/edit', 'HomeController@edit')->name('home.edit');
        Route::put('{user}/update', 'HomeController@update')->name('home.update');
        Route::get('filter', 'HomeController@filter')->name('filter');
    });

    Route::prefix('reimburstment')->group(function () {
        Route::get('index', 'ReimbursementController@index')->name('reimburstment.index');
        Route::get('create', 'ReimbursementController@create')->name('reimburstment.create')->middleware(['permission:Ajukan Reimburstment']);
        Route::post('store', 'ReimbursementController@store')->name('reimburstment.store')->middleware(['permission:Ajukan Reimburstment']);
        Route::get('{reimburst}/show', 'ReimbursementController@show')->name('reimburstment.show')->middleware(['permission:Lihat Reimburstment']);
        Route::get('{reimburst}/edit', 'ReimbursementController@edit')->name('reimburstment.edit')->middleware(['permission:Edit Reimburstment']);
        Route::put('{reimburst}/update', 'ReimbursementController@update')->name('reimburstment.update')->middleware(['permission:Edit Reimburstment']);
        Route::delete('{reimburst}/delete', 'ReimbursementController@delete')->name('reimburstment.delete')->middleware(['permission:Hapus Reimburstment']);
        Route::put('{reimburst}/terima', 'ReimbursementController@terima')->name('reimburstment.terima')->middleware(['permission:Terima Reimburstment']);
        Route::put('{reimburst}/tolak', 'ReimbursementController@tolak')->name('reimburstment.tolak')->middleware(['permission:Tolak Reimburstment']);
        Route::post('getUser', 'ReimbursementController@getUser')->name('reimburstment.get.user');
        Route::get('{reimburst}/sendEmail', 'ReimbursementController@sendEmail')->name('reimburstment.send.email')->middleware(['permission:Kirim Email Reimburstment']);
    });

    Route::prefix('pengembalian')->group(function () {
        Route::get('index', 'PengembalianController@index')->name('pengembalian.index');
        Route::get('create', 'PengembalianController@create')->name('pengembalian.create')->middleware(['permission:Memberikan Pengembalian Dana']);
        Route::post('store', 'PengembalianController@store')->name('pengembalian.store')->middleware(['permission:Memberikan Pengembalian Dana']);
        Route::get('{pengembalian}/show', 'PengembalianController@show')->name('pengembalian.show')->middleware(['permission:Lihat Pengembalian Dana']);
        Route::get('{pengembalian}/edit', 'PengembalianController@edit')->name('pengembalian.edit')->middleware(['permission:Edit Pengembalian Dana']);
        Route::put('{pengembalian}/update', 'PengembalianController@update')->name('pengembalian.update')->middleware(['permission:Edit Pengembalian Dana']);
        Route::put('{pengembalian}/terima', 'PengembalianController@terima')->name('pengembalian.terima');
        Route::put('{pengembalian}/tolak', 'PengembalianController@tolak')->name('pengembalian.tolak');
        Route::delete('{pengembalian}/delete', 'PengembalianController@delete')->name('pengembalian.delete')->middleware(['permission:Hapus Pengembalian Dana']);
    });

    Route::prefix('report')->group(function () {
        Route::get('reimburstment/index', 'ReportController@index')->name('report.reimburstment.index')->middleware(['permission:Mencari Laporan Reimburstment']);
        Route::get('reimburstment/result', 'ReportController@report')->name('report.reimburstment.result')->middleware(['permission:Melihat Laporan Reimburstment']);
        Route::get('reimburstment/excel', 'ReportController@exportExcel')->name('report.reimburstment.excel')->middleware(['permission:Eksport Laporan Reimburstment']);
        Route::get('reimburstment/pdf', 'ReportController@exportPdf')->name('report.reimburstment.pdf')->middleware(['permission:Eksport Laporan Reimburstment']);
        Route::get('pengembalian/index', 'ReportController@pengembalianIndex')->name('report.pengembalian.index')->middleware(['permission:Mencari Laporan Pengembalian Dana']);
        Route::get('pengembalian/result', 'ReportController@pengembalianReport')->name('report.pengembalian.result')->middleware(['permission:Melihat Laporan Pengembalian Dana']);
        Route::get('pengembalian/Excel', 'ReportController@pengembalianExcel')->name('report.pengembalian.excel')->middleware(['permission:Eksport Laporan Pengembalian Dana']);
        Route::get('pengembalian/pdf', 'ReportController@pengembalian@pengembalianPdf')->name('report.pengembalian.pdf')->middleware(['permission:Eksport Laporan Pengembalian Dana']);
    });

    Route::prefix('settings')->group(function () {

        Route::prefix('user')->group(function () {
            Route::get('index', 'UserController@index')->name('user.index')->middleware(['permission:Index User']);
            Route::get('create', 'UserController@create')->name('user.create')->middleware(['permission:Create User']);
            Route::post('store', 'UserController@store')->name('user.store')->middleware(['permission:Create User']);
            Route::get('{user}/show', 'UserController@show')->name('user.show')->middleware(['permission:Read User']);
            Route::get('{user}/edit', 'UserController@edit')->name('user.edit')->middleware(['permission:Update User']);
            Route::put('{user}/update', 'UserController@update')->name('user.update')->middleware(['permission:Update User']);
            Route::delete('{user}/delete', 'UserController@delete')->name('user.delete')->middleware(['permission:Delete User']);


            Route::get('trash', 'UserController@trash')->name('user.trash');
            Route::get('restore/{id}', 'UserController@restore')->name('user.trash.store');
            Route::get('del_permanent/{id}', 'UserController@delete')->name('user.trash.delete');
            Route::get('restore_all', 'UserController@restore_all')->name('user.trash.restoreAll');
            Route::get('delete_all', 'UserController@delete_all')->name('user.trash.deleteAll');
        });

        Route::prefix('role')->group(function () {
            Route::get('index', 'RoleController@index')->name('role.index')->middleware(['permission:Index Role']);
            Route::get('create', 'RoleController@create')->name('role.create')->middleware(['permission:Create Role']);
            Route::post('create/store', 'RoleController@store')->name('role.store')->middleware(['permission:Create Role']);
            Route::post('hasPermission', 'RoleController@hasPermission')->name('role.hasPermission');
            Route::get('show/{role}', 'RoleController@show')->name('role.show')->middleware(['permission:Read Role']);
            Route::get('delete/{role}', 'RoleController@delete')->name('role.delete')->middleware(['permission:Delete Role']);
        });

        Route::prefix('permission')->group(function () {
            Route::get('/', 'PermissionController@index')->name('permission.index')->middleware(['permission:Index Permission']);
            Route::post('store', 'PermissionController@store')->name('permission.store')->middleware(['permission:Create Permission']);
            Route::delete('{permission}/delete', 'PermissionController@delete')->name('permission.delete')->middleware(['permission:Delete Permission']);
        });

        Route::prefix('setting')->group(function () {
            Route::get('index', 'SettingController@index')->name('setting.index');
            Route::get('{setting}/edit', 'SettingController@edit')->name('setting.edit');
            Route::put('{setting}/update', 'SettingController@update')->name('setting.update');
        });
    });
});
