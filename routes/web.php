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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/edit/{id}', 'HomeController@edit')->name('edit_prof');
Route::post('/home/update/{id}', 'HomeController@update')->name('update_prof');
Route::get('/home/filter', 'HomeController@filter')->name('filter');

    Route::get('/user', 'UserController@index')->name('user');
    Route::get('/user/list', 'UserController@store')->name('list');
    Route::get('/user/add', 'UserController@add')->name('add_data');
    Route::post('/user/save', 'UserController@create')->name('create_user');
    Route::get('/user/edit/{id}', 'UserController@edit')->name('edit');
    Route::get('/user/delete/{id}', 'UserController@destroy')->name('destroy');
    Route::post('/user/update/{id}', 'UserController@update')->name('update');
    Route::get('/user/show/{id}', 'UserController@show')->name('show');
    Route::get('/user/trash', 'UserController@trash')->name('trash_user');
    Route::get('/user/restore/{id}', 'UserController@restore')->name('restore_user');
    Route::get('/user/del_permanent/{id}', 'UserController@delete')->name('delete_user');
    Route::get('/user/restore_all', 'UserController@restore_all')->name('restore_all_user');
    Route::get('/user/delete_all', 'UserController@delete_all')->name('delete_all_user');


//model has permission
Route::get('/user/givePermission/{id}','UserController@givePermission')->name('givePermission');
Route::post('/user/givePermission/storegivePermission/{id}','UserController@storegivePermission')->name('storegivePermission');

Route::get('/reimbursement', 'ReimbursementController@index')->name('index');
Route::get('/reimbursement/allreimburstement', 'ReimbursementController@allreimburstement')->name('allreimburstement');
Route::get('/reimbursement/create', 'ReimbursementController@create')->name('create');
Route::post('/reimbursement/create/save', 'ReimbursementController@store')->name('store');
Route::get('/reimbursement/show/{id}', 'ReimbursementController@show')->name('show');
Route::get('/reimbursement/edit/{id}', 'ReimbursementController@edit')->name('edit');
Route::post('/reimbursement/edit/update/{id}', 'ReimbursementController@update')->name('update');
Route::get('/reimbursement/destroy/{id}', 'ReimbursementController@destroy')->name('destroy');
Route::get('/reimbursement/trash', 'ReimbursementController@trash')->name('trash');
Route::get('/reimbursement/trash/show/{id}', 'ReimbursementController@show_trash')->name('show_trash');
Route::get('/reimbursement/trash/restore/{id}','ReimbursementController@restore' )->name('restore');
Route::get('/reimbursement/trash/restore_all','ReimbursementController@restore_all' )->name('restore_all');
Route::get('/reimbursement/trash/delete/{id}','ReimbursementController@delete' )->name('delete');
Route::get('/reimbursement/trash/delete_all','ReimbursementController@delete_all' )->name('delete_all');
Route::get('/reimbursement/total','ReimbursementController@total' )->name('total');

Route::get('report', 'HasilController@report');
Route::get('result', 'HasilController@result');

Route::get('/schedule', 'ScheduleController@index')->name('schedule');
Route::get('/schedule/add_schedule', 'ScheduleController@create')->name('schedule_add');
Route::post('/schedule/add_schedule/save', 'ScheduleController@store')->name('schedule_save');
Route::get('/schedule/show/{id}', 'ScheduleController@show');
Route::get('/schedule/edit/{id}', 'ScheduleController@edit');
Route::post('/schedule/edit/update/{id}', 'ScheduleController@update');
Route::get('/schedule/destroy/{id}', 'ScheduleController@destroy');
Route::get('/schedule/trash', 'ScheduleController@trash')->name('schedule_trash');
Route::get('/schedule/trash/restore/{id}', 'ScheduleController@restore');
Route::get('/schedule/trash/restore_all', 'ScheduleController@restore_all')->name('schedule_restore_all');
Route::get('/schedule/trash/delete/{id}', 'ScheduleController@delete');
Route::get('/schedule/trash/delete_all', 'ScheduleController@delete_all')->name('schedule_delete_all');

Route::get('mreport', 'MReportController@index')->name('index_report');
Route::get('mreport/create', 'MReportController@create')->name('list_mreport');
Route::post('mreport/store', 'MReportController@store')->name('add_report');
Route::get('mreport/show/{id}', 'MReportController@show')->name('show_mreport');
Route::get('mreport/download/{id}', 'MReportController@download')->name('download');
Route::get('mreport/delete/{id}', 'MReportController@destroy');
Route::get('mreport/edit/{id}', 'MReportController@edit');
Route::post('mreport/update/{id}', 'MReportController@update');
