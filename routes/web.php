<?php

Auth::routes();

Route::group(
    [
        'prefix'     => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'site']
    ],
    function () {
        Route::get('/', 'MainController@main');
        Route::get('/services/{id?}', 'MainController@services');
        Route::get('/blog/{id?}', 'MainController@blog');
        Route::get('/contact-us', 'MainController@contact_us');
        Route::get('/about-company', 'MainController@about_company');
        Route::get('/our-team', 'MainController@our_team');
        Route::get('/portfolio/{page?}', 'MainController@portfolio');
        Route::get('/friend_form', 'MainController@friend_form');


        Route::get('/form', 'MainController@form');

        // Catalog
        Route::get('/catalog/{name?}/{id?}', 'MainController@catalog');
        Route::post('/_tools/search_render_catalog', 'MainController@search_render_catalog');

        Route::get('/selection-request', 'MainController@selection_request');
        Route::get('/search/{page?}', 'MainController@search');

        // Favorite
        Route::get('/favorite', 'MainController@favorite');
        Route::post('/_tools/add_favorite', 'MainController@add_favorite');
        Route::post('/_tools/submit_required', 'MainController@submit_required');

        // Admin Panel
        Route::get('/admin/', 'Admin::LoginController@index');

        // Page
        Route::get('/{name?}', 'MainController@page');
    }
);
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localizationRedirect', 'localeViewPath', 'site']
    ], function () {
    Route::post('/_tools/add_favorite', 'MainController@add_favorite');
    Route::post('/_tools/submit_required', 'MainController@submit_required');
    Route::post('/_tools/search_render_catalog', 'MainController@search_render_catalog');
});