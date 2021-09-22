<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    //Redirrecciona a login de la plataforma web
    return redirect()->route('login');
    /* return view('welcome'); */
});

Auth::routes();

Route::middleware('auth:web')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Profile routes 
    Route::get('my-profile', 'ProfileController@show')->name('profile');
    Route::post('profile-update', 'ProfileController@update')->name('profile.update');
    Route::post('password-update', 'ProfileController@changePassword')->name('profile.password');
    Route::post('avatar-update', 'ProfileController@changeAvatar')->name('profile.avatar');

    //Users groups routes
    Route::get('users/{user}/groups', 'GroupController@index')->middleware('can:view,user')->name('my.groups');

    //Groups devices routes
    Route::get('devices/{device}', 'DeviceController@show')->name('devices.show');
    Route::get('devices/{device}/show-location', 'DeviceController@showLocation')->name('devices.location'); //mostrar localizacion de un dispositivo

    Route::group(['middleware' => ['role:admin']], function () {
        Route::post('users/{user}/groups', 'GroupController@store')->middleware('can:update,user')->name('groups.create'); //Crear un grupo
        Route::get('groups/{group}', 'GroupController@destroy')->middleware('can:delete,group')->name('groups.delete'); //Eliminar un grupo
        //Se busca el sensor mediante un serial number
        Route::post('devices-search', 'DeviceController@search')->name('devices.search');
        //Elimina un dispositivo de un grupo
        Route::get('groups/{group}/devices/{device}', 'DeviceController@destroy')->middleware('can:update,group')->name('devices.delete');
        //Para añadir personal de mantenimiento
        Route::get('groups/{group}/add-maintenance', 'MaintenanceController@create')->middleware('can:update,group')->name('maintenance.create');
        //Para eliminar personal de mantenimiento
        Route::get('groups/{group}/show-maintenance', 'MaintenanceController@show')->middleware('can:update,group')->name('maintenance.show');
        //Buscar al usuario de mantenimiento
        Route::post('search-maintenance', 'MaintenanceController@search')->name('maintenance.search');
        //guardar usuario de mantenimiento 
        Route::post('create-maintenance', 'MaintenanceController@store')->name('maintenance.store');
        //Eliminar usuario de un grupo
        Route::get('groups/{group}/users/{user}', 'MaintenanceController@delete')->middleware('can:update,group')->name('maintenance.delete');
        //Muestra las reglas de un dispositivo
        Route::get('devices/{device}/rules', 'RuleController@index')->name('devices.rules');
        //Añadir regla al dispositivo
        Route::post('devices/{device}/add-rule', 'RuleController@store')->name('devices.add-rule');
        //Borrar una regla
        Route::get('rule/{rule}', 'RuleController@destroy')->name('rule.delete');
        //Todos los dispositivos del usuario
        Route::get('users/{user}/devices', 'DeviceController@index')->name('devices.index');
    });

    //Retorna las alertas producidas por los valores recibidos del sensor
    Route::get('devices/{device}/alerts', 'AlertController@index')->name('devices.alerts');
});
