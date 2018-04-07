<?php

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| Endpoint: /auth
|
*/
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('auth.login');
    Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('auth.reset');

    Route::post('/login', 'LoginController@login')->middleware('recaptcha');
    Route::post('/login/checkpoint', 'LoginCheckpointController@index')->name('auth.checkpoint');
    Route::post('/password', 'ForgotPasswordController@sendResetLinkEmail')->middleware('recaptcha');
    Route::post('/password/reset', 'ResetPasswordController@reset')->name('auth.reset.post')->middleware('recaptcha');
    Route::post('/password/reset/{token}', 'ForgotPasswordController@sendResetLinkEmail')->middleware('recaptcha');
});

/*
|--------------------------------------------------------------------------
| Routes Accessable only when logged in
|--------------------------------------------------------------------------
|
| Endpoint: /auth
|
*/
Route::get('/logout', 'LoginController@logout')->name('auth.logout')->middleware('auth');
