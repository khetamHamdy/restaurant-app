<?php

use App\Models\Setting;


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


use App\Http\Controllers\WEB\Admin\LandingPageController;
use App\Models\Cart;
use Illuminate\Support\Carbon;


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath'
    ]
], function () {
//    Route::get('/failPayment', function () {
//        return view('website.fail');
//    })->name('failPayment');
//    Route::get('/successPayment', function () {
//        return view('website.success');
//    })->name('successPayment');
//    Route::get('/payment', function () {
//        return view('website.payment');
//    })->name('payment');

//    Route::get('forgot/password', 'Auth\ForgotPasswordController@forgotPasswordForm')->name('forgotPasswordForm');
//    Route::post('sendResetLinkEmail', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('sendResetLinkEmail');
//    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.new');
//    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

    Route::get('/', 'WEB\Site\HomeController2@index')->name('home');
    Route::get('/{name}', 'WEB\Site\HomeController@index')->name('sub_home');

    Route::get('{name?}/about', 'WEB\Site\HomeController@about')->name('about');

    Route::get('{name?}/menu', 'WEB\Site\HomeController@menu')->name('menu');

    Route::get('{name}/reservation', 'WEB\Site\HomeController@reservation')->name('reservation');
    Route::post('{name}/reservation', 'WEB\Site\HomeController@reservation_store')->name('reservation.store');

    Route::get('{name}/chef', 'WEB\Site\HomeController@chef')->name('chef');
    Route::get('{name}/photos', 'WEB\Site\HomeController@gallery')->name('photos');
    Route::get('{name}/contact', 'WEB\Site\HomeController@contact')->name('contact');
    Route::post('{name}/contact', 'WEB\Site\HomeController@storeQuote')->name('contact.store');

    Route::group(['middleware' => ['auth']], function () {

    });

    //ADMIN AUTH ///
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', function () {
            return route('/login');
        });
        Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login.form');
        Route::post('/login', 'AdminAuth\LoginController@login')->name('admin.login');
        Route::get('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');
    });


    Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin', 'as' => 'admin.',], function () {
        Route::get('/', function () {
            return redirect('/admin/home');
        });
        Route::post('/changeStatus/{model}', 'WEB\Admin\HomeController@changeStatus');

        Route::get('home', 'WEB\Admin\HomeController@index')->name('admin.home');
        Route::get('homePage', 'WEB\Admin\HomePageController@index')->name('homePage.index');
        Route::post('homePage', 'WEB\Admin\HomePageController@update')->name('homePage.update');

        Route::get('/admins/{id}/edit', 'WEB\Admin\AdminController@edit')->name('admins.edit');
        Route::patch('/admins/{id}', 'WEB\Admin\AdminController@update')->name('users.update');
        Route::get('/admins/{id}/edit_password', 'WEB\Admin\AdminController@edit_password')->name('admins.edit_password');
        Route::post('/admins/{id}/edit_password', 'WEB\Admin\AdminController@update_password')->name('admins.edit_password');

        Route::get('/vendor/{id}/edit_password', 'WEB\Admin\VendorsController@edit_password')->name('admins.edit_password');
        Route::post('/vendor/{id}/edit_password', 'WEB\Admin\VendorsController@update_password')->name('admins.edit_password');

        Route::get('/admins', 'WEB\Admin\AdminController@index')->name('admins.all');
        Route::post('/admins/changeStatus', 'WEB\Admin\AdminController@changeStatus')->name('admin_changeStatus');
        Route::delete('admins/{id}', 'WEB\Admin\AdminController@destroy')->name('admins.destroy');
        Route::post('/admins', 'WEB\Admin\AdminController@store')->name('admins.store');
        Route::get('/admins/create', 'WEB\Admin\AdminController@create')->name('admins.create');
        Route::get('/editMyProfile', 'WEB\Admin\AdminController@editMyProfile')->name('admins.editMyProfile');
        Route::post('/updateProfile', 'WEB\Admin\AdminController@updateProfile')->name('admins.updateProfile');
        Route::get('/changeMyPassword', 'WEB\Admin\AdminController@changeMyPassword')->name('admins.changeMyPassword');
        Route::post('/updateMyPassword', 'WEB\Admin\AdminController@updateMyPassword')->name('admins.updateMyPassword');

        Route::resource('/vendors', 'WEB\Admin\VendorsController');
        Route::resource('/projects', 'WEB\Admin\ProjectsController');
        Route::resource('/teams', 'WEB\Admin\TeamsController');


        Route::get('/contacts', 'WEB\Admin\ContactController@index');
        Route::get('/contacts/{id}/show', 'WEB\Admin\ContactController@show');
        Route::patch('/contacts/{id}', 'WEB\Admin\ContactController@update');
        Route::get('/export/excel/contacts', 'WEB\Admin\ContactController@exportExcel');
        Route::get('/pdfContacts', 'WEB\Admin\ContactController@pdfContacts');

        Route::get('settings', 'WEB\Admin\SettingController@index')->name('settings.all');
        Route::post('settings', 'WEB\Admin\SettingController@update')->name('settings.update');

        Route::get('system_maintenance', 'WEB\Admin\SettingController@system_maintenance')->name('system.maintenance');
        Route::post('system_maintenance', 'WEB\Admin\SettingController@update_system_maintenance')->name('update.system.maintenance');

        Route::resource('/pages', 'WEB\Admin\PagesController');
        Route::resource('/roles', 'WEB\Admin\RolesController');
        Route::resource('/notifications', 'WEB\Admin\NotificationsController');
        Route::get('logs', 'WEB\Admin\LogController@index');

    });

    //ADMIN AUTH ///
    Route::group(['prefix' => 'provider'], function () {
        Route::get('/login', 'SubAdminAuth\LoginController@showLoginForm');
        Route::post('/login', 'SubAdminAuth\LoginController@login')->name('provider.login');
        Route::get('/logout', 'SubAdminAuth\LoginController@logout');
    });


    //vendor
    Route::group(['middleware' => ['web', 'subadmin'], 'prefix' => 'provider', 'as' => 'provider.',], function () {
        Route::get('/', function () {
            return redirect('/provider/home');
        });
        Route::post('/changeStatus/{model}', 'WEB\SubAdmin\HomeController@changeStatus');

        Route::get('home', 'WEB\SubAdmin\HomeController@index')->name('provider.home');

        Route::get('/editMyProfile', 'WEB\SubAdmin\SubAdminController@editMyProfile')->name('admins.editMyProfile');
        Route::post('/updateProfile', 'WEB\SubAdmin\SubAdminController@updateProfile')->name('admins.updateProfile');
        Route::resource('/pages', 'WEB\SubAdmin\PagesController');


        Route::resource('/vendors', 'WEB\SubAdmin\VendorsController');
        Route::resource('/gallery', 'WEB\SubAdmin\GalleryController');
        Route::get('/categories/{id}/meals', 'WEB\SubAdmin\CategoryController@meals');
        Route::resource('/categories', 'WEB\SubAdmin\CategoryController');
        Route::resource('/meals', 'WEB\SubAdmin\MealController');
        Route::resource('/chefs', 'WEB\SubAdmin\ChefController');
        Route::resource('/usAbout', 'WEB\SubAdmin\usAboutController');

        Route::resource('/sliders', 'WEB\SubAdmin\SliderController');
        Route::get('/contacts', 'WEB\SubAdmin\ContactController@index');
        Route::get('/contacts/{id}/show', 'WEB\SubAdmin\ContactController@show');
        Route::patch('/contacts/{id}', 'WEB\SubAdmin\ContactController@update');

        Route::get('/reservations', 'WEB\SubAdmin\ReservationController@index');
        Route::get('/reservations/{id}/show', 'WEB\SubAdmin\ReservationController@show');
        Route::patch('/reservations/{id}', 'WEB\SubAdmin\ReservationController@update');

        Route::get('/export/excel/contacts', 'WEB\SubAdmin\ContactController@exportExcel');
        Route::get('/pdfContacts', 'WEB\SubAdmin\ContactController@pdfContacts');


        Route::get('settings', 'WEB\SubAdmin\SettingController@index')->name('settings.all');
        Route::post('settings', 'WEB\SubAdmin\SettingController@update')->name('settings.update');

        Route::get('system_maintenance', 'WEB\SubAdmin\SettingController@system_maintenance')->name('system.maintenance');
        Route::post('system_maintenance', 'WEB\SubAdmin\SettingController@update_system_maintenance')->name('update.system.maintenance');

    });
});

