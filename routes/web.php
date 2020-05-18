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
        Route::get('create', 'ReimbursementController@create')->name('reimburstment.create');
        Route::post('store', 'ReimbursementController@store')->name('reimburstment.store');
        Route::get('{reimburst}/show', 'ReimbursementController@show')->name('reimburstment.show');
        Route::get('{reimburst}/edit', 'ReimbursementController@edit')->name('reimburstment.edit');
        Route::put('{reimburst}/update', 'ReimbursementController@update')->name('reimburstment.update');
        Route::delete('{reimburst}/delete', 'ReimbursementController@delete')->name('reimburstment.delete');
        Route::put('{reimburst}/terima', 'ReimbursementController@terima')->name('reimburstment.terima');
        Route::put('{reimburst}/tolak', 'ReimbursementController@tolak')->name('reimburstment.tolak');
        Route::post('getUser', 'ReimbursementController@getUser')->name('reimburstment.get.user');
        Route::get('{reimburst}/sendEmail', 'ReimbursementController@sendEmail')->name('reimburstment.send.email');
    });

    Route::prefix('pengembalian')->group(function () {
        Route::get('index', 'PengembalianController@index')->name('pengembalian.index');
        Route::get('create', 'PengembalianController@create')->name('pengembalian.create');
        Route::post('store', 'PengembalianController@store')->name('pengembalian.store');
        Route::get('{pengembalian}/show', 'PengembalianController@show')->name('pengembalian.show');
        Route::get('{pengembalian}/edit', 'PengembalianController@edit')->name('pengembalian.edit');
        Route::put('{pengembalian}/update', 'PengembalianController@update')->name('pengembalian.update');
        Route::put('{pengembalian}/terima', 'PengembalianController@terima')->name('pengembalian.terima');
        Route::put('{pengembalian}/tolak', 'PengembalianController@tolak')->name('pengembalian.tolak');
        Route::delete('{pengembalian}/delete', 'PengembalianController@delete')->name('pengembalian.delete');
    });

    Route::prefix('report')->group(function () {
        Route::get('reimburstment/index', 'ReportController@index')->name('report.reimburstment.index');
        Route::get('reimburstment/result', 'ReportController@report')->name('report.reimburstment.result');
        Route::get('reimburstment/exportExcel', 'ReportController@exportExcel')->name('report.reimburstment.excel');
        Route::get('pengembalian/index', 'ReportController@pengembalianIndex')->name('report.pengembalian.index');
        Route::get('exportPdf', 'ReportController@exportPdf')->name('report.export.pdf');
    });

    Route::prefix('settings')->group(function () {

        Route::prefix('user')->group(function () {
            Route::get('index', 'UserController@index')->name('user.index');
            Route::get('create', 'UserController@create')->name('user.create');
            Route::post('store', 'UserController@store')->name('user.store');
            Route::get('{user}/show', 'UserController@show')->name('user.show');
            Route::get('{user}/edit', 'UserController@edit')->name('user.edit');
            Route::put('{user}/update', 'UserController@update')->name('user.update');
            Route::delete('{user}/delete', 'UserController@delete')->name('user.delete');


            Route::get('trash', 'UserController@trash')->name('user.trash');
            Route::get('restore/{id}', 'UserController@restore')->name('user.trash.store');
            Route::get('del_permanent/{id}', 'UserController@delete')->name('user.trash.delete');
            Route::get('restore_all', 'UserController@restore_all')->name('user.trash.restoreAll');
            Route::get('delete_all', 'UserController@delete_all')->name('user.trash.deleteAll');
        });

        Route::prefix('role')->group(function () {
            Route::get('index', 'RoleController@index')->name('role.index');
            Route::get('create', 'RoleController@create')->name('role.create');
            Route::post('create/store', 'RoleController@store')->name('role.store');
            Route::post('hasPermission', 'RoleController@hasPermission')->name('role.hasPermission');
            Route::get('show/{role}', 'RoleController@show')->name('role.show');
            Route::get('delete/{role}', 'RoleController@delete')->name('role.delete');
        });

        Route::prefix('permission')->group(function () {
            Route::get('/', 'PermissionController@index')->name('permission.index');
            Route::post('store', 'PermissionController@store')->name('permission.store');
            Route::delete('{permission}/delete', 'PermissionController@delete')->name('permission.delete');
        });

        Route::prefix('setting')->group(function () {
            Route::get('index', 'SettingController@index')->name('setting.index');
            Route::get('{setting}/edit', 'SettingController@edit')->name('setting.edit');
            Route::put('{setting}/update', 'SettingController@update')->name('setting.update');
        });
    });
});
