<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
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

Route::get('clear_cache', function () {
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    dd("Cache is cleared");
});

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/home', '/admin');
Auth::routes(['register' => false]);

// Registration
Route::get('auth/registration', 'Admin\RegistrationController@registration')->name('auth.registration');
Route::post('auth/store', 'Admin\RegistrationController@store')->name('auth.store');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Services
    Route::delete('services/destroy', 'ServicesController@massDestroy')->name('services.massDestroy');
    Route::resource('services', 'ServicesController');

    // Lawyer
    Route::delete('lawyer/destroy', 'LawyerController@massDestroy')->name('lawyer.massDestroy');
    Route::resource('lawyer', 'LawyerController');

    // Clients
    Route::delete('clients/destroy', 'ClientsController@massDestroy')->name('clients.massDestroy');
    Route::resource('clients', 'ClientsController');

    // Appointments
    Route::delete('appointments/destroy', 'AppointmentsController@massDestroy')->name('appointments.massDestroy');
    Route::resource('appointments', 'AppointmentsController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
});
