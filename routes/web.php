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

Route::prefix('user')->group(function () {
    Route::get('/', 'UserController@index')->name('user');
    Route::get('list', 'UserController@store')->name('list');
    Route::get('add', 'UserController@add')->name('add_data');
    Route::post('save', 'UserController@create')->name('create_user');
    Route::get('edit/{id}', 'UserController@edit')->name('edit');
    Route::get('delete/{id}', 'UserController@destroy')->name('destroy');
    Route::post('update/{id}', 'UserController@update')->name('update');
    Route::get('show/{id}', 'UserController@show')->name('show');
    Route::get('trash', 'UserController@trash')->name('trash_user');
    Route::get('restore/{id}', 'UserController@restore')->name('restore_user');
    Route::get('del_permanent/{id}', 'UserController@delete')->name('delete_user');
    Route::get('restore_all', 'UserController@restore_all')->name('restore_all_user');
    Route::get('delete_all', 'UserController@delete_all')->name('delete_all_user');
});


//model has permission
Route::get('/user/givePermission/{id}', 'UserController@givePermission')->name('givePermission');
Route::post('/user/givePermission/storegivePermission/{id}', 'UserController@storegivePermission')->name('storegivePermission');

Route::prefix('reimburstment')->group(function () {
    Route::get('/', 'ReimbursementController@index')->name('reimburstment');
    Route::get('allreimburstement', 'ReimbursementController@allreimburstement')->name('allreimburstement');
    Route::get('create', 'ReimbursementController@create')->name('reimburstment.create');
    Route::post('create/save', 'ReimbursementController@store')->name('reimburstment.store');
    Route::get('show/{id}', 'ReimbursementController@show')->name('reimburstment.view');
    Route::get('edit/{id}', 'ReimbursementController@edit')->name('reimburstment.edit');
    Route::post('edit/update/{id}', 'ReimbursementController@update')->name('reimburstment.update');
    Route::get('destroy/{id}', 'ReimbursementController@destroy')->name('reimburstment.delete');
    Route::get('trash', 'ReimbursementController@trash')->name('trash');
    Route::get('trash/show/{id}', 'ReimbursementController@show_trash')->name('show_trash');
    Route::get('trash/restore/{id}', 'ReimbursementController@restore')->name('restore');
    Route::get('trash/restore_all', 'ReimbursementController@restore_all')->name('restore_all');
    Route::get('trash/delete/{id}', 'ReimbursementController@delete')->name('delete');
    Route::get('trash/delete_all', 'ReimbursementController@delete_all')->name('delete_all');
    Route::get('total', 'ReimbursementController@total')->name('total');
});


Route::get('report', 'HasilController@report');
Route::get('result', 'HasilController@result');

Route::prefix('pettyCash')->group(function () {
    Route::get('/', 'PettyCashController@index')->name('pettyCash');
    Route::post('store', 'PettyCashController@store')->name('pettyCash.store');
});
