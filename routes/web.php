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

// Route::prefix('role')->group(function(){
//     Route::get('/','RoleController@index')->name('role_list');
//     Route::get('create','RoleController@create')->name('create_role');
//     Route::post('create/store','RoleController@store')->name('store_role');
//     Route::get('show/{role}','RoleController@show')->name('show_role');
//     Route::get('edit/{role}','RoleController@edit')->name('edit_role');
//     Route::post('edit/update/{id}','RoleController@update')->name('update_role');
//     Route::get('delete/{role}','RoleController@destroy')->name('delete_role');

//     //role has permission
//     Route::get('createRoleHasPermission/','RoleController@createRoleHasPermission')->name('createRoleHasPermission');
//     Route::post('storeRoleHasPermission/','RoleController@storeRoleHasPermission')->name('storeRoleHasPermission');
// });

// Route::prefix('permission')->group(function(){
//     Route::get('/','PermissionController@index')->name('permission_list');
//     Route::get('create','PermissionController@create')->name('create_permission');
//     Route::post('create/store','PermissionController@store')->name('store_permission');
//     Route::get('show/{permission}','PermissionController@show')->name('show_permission');
//     Route::get('edit/{permission}','PermissionController@edit')->name('edit_permission');
//     Route::post('edit/update/{id}','PermissionController@update')->name('update_permission');
//     Route::get('delete/{permission}','PermissionController@destroy')->name('delete_permission');
// });
Route::prefix('home')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('{id}/edit', 'HomeController@edit')->name('home.edit');
    Route::post('{id}/update', 'HomeController@update')->name('home.edit');
    Route::get('filter', 'HomeController@filter')->name('filter');
});

//model has permission
Route::get('/user/givePermission/{id}', 'UserController@givePermission')->name('givePermission');
Route::post('/user/givePermission/storegivePermission/{id}', 'UserController@storegivePermission')->name('storegivePermission');

Route::prefix('reimburstment')->group(function () {
    Route::get('index', 'ReimbursementController@index')->name('reimburstment.index');
    Route::get('allreimburstement', 'ReimbursementController@allreimburstement')->name('reimburstment.allreimburstement');
    Route::get('create', 'ReimbursementController@create')->name('reimburstment.create');
    Route::post('create/save', 'ReimbursementController@store')->name('reimburstment.store');
    Route::get('{reimburst}/show', 'ReimbursementController@show')->name('reimburstment.show');
    Route::get('{reimburst}/edit', 'ReimbursementController@edit')->name('reimburstment.edit');
    Route::put('{reimburst}/update', 'ReimbursementController@update')->name('reimburstment.update');
    Route::delete('{reimburst}/delete', 'ReimbursementController@delete')->name('reimburstment.delete');
    Route::get('{reimburst}/terima', 'ReimbursementController@terima')->name('reimburstment.terima');
    Route::get('{reimburst}/tolak', 'ReimbursementController@tolak')->name('reimburstment.tolak');
    Route::post('getUser', 'ReimbursementController@getUser')->name('reimburstment.get.user');
    // Route::get('trash', 'ReimbursementController@trash')->name('trash');
    // Route::get('trash/show/{id}', 'ReimbursementController@show_trash')->name('show_trash');
    // Route::get('trash/restore/{id}', 'ReimbursementController@restore')->name('restore');
    // Route::get('trash/restore_all', 'ReimbursementController@restore_all')->name('restore_all');
    // Route::get('trash/delete/{id}', 'ReimbursementController@delete')->name('delete');
    // Route::get('trash/delete_all', 'ReimbursementController@delete_all')->name('delete_all');
    Route::get('total', 'ReimbursementController@total')->name('total');
});

Route::prefix('report')->group(function () {
    Route::get('index', 'ReportController@index')->name('report.index');
    Route::get('result', 'ReportController@report')->name('report.result');
    Route::get('exportExcel', 'ReportController@exportExcel')->name('report.export.excel');
    Route::get('exportPdf', 'ReportController@exportPdf')->name('report.export.pdf');
});


Route::prefix('pettyCash')->group(function () {
    Route::get('index', 'PettyCashController@index')->name('pettyCash.index');
    Route::post('store', 'PettyCashController@store')->name('pettyCash.store');
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
});
