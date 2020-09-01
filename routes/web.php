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




Auth::routes();
Route::get('/', 'HomeController@home')->name('index');
Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => ['auth']], function () {
	Route::get('/employee/create','EmployeeController@createEmployee')->name('employee.create');

	Route::post('/employee/save','EmployeeController@saveEmployee')->name('employee.save');


	Route::get('/employee/list','EmployeeController@list')->name('employee.list');

	Route::get('/get-employee-data','EmployeeController@getEmployeeData')->name('employee.data.get');

	Route::get('/employee/edit/{id}','EmployeeController@editEmployee')->name('employee.edit');

	Route::get('/employee/delete/{id}','EmployeeController@deleteEmployee')->name('employee.delete');
});