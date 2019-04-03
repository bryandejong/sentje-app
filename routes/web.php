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
    return redirect("login");
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email Verification Routes...
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');



Route::middleware(['auth', 'locale'])->group(function () {
    // uses 'auth' middleware
    Route::get('/home', 'HomeController@index')->name("home");

    Route::get('/accounts', 'BankAccountController@index')->name('accounts');
    Route::get('/accounts/add', 'BankAccountController@create')->name('accounts.add');
    Route::post('/accounts/add/finish', 'BankAccountController@store')->name('accounts.store');
    Route::post('/accounts/update', 'BankAccountController@update')->name('accounts.update');

    Route::get('/transactions/sent', 'TransactionRequestController@indexSent')->name('transactions.sent');
    Route::get('/transactions/received', 'TransactionRequestController@indexReceived')->name('transactions.received');
    Route::get('/transactions/new', 'TransactionRequestController@new')->name('transactions.new');

    Route::get('/transactions/pay/{id}', 'TransactionRequestController@pay')->name('transactions.pay');
    Route::post('/transactions/store', 'TransactionRequestController@store')->name('transactions.store');
    Route::post('/transactions/destroy', 'TransactionRequestController@destroy')->name('transactions.destroy');
    Route::post('/transactions/completePayment', 'TransactionRequestController@completePayment')->name('transactions.completePayment');

    Route::get('/contacts', 'ContactController@index')->name('contacts');
    Route::get('/contacts/add', 'ContactController@create')->name('contact.add');
    Route::post('/contacts/add/finish', 'ContactController@store')->name('contacts.store');
    Route::delete('/contacts/delete', 'ContactController@delete')->name('contacts.delete');

    Route::post('/settings/lang', 'SettingsController@setLanguage')->name('settings.lang');
});
