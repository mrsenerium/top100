<?php
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => 'web'], function () {
    // Authentication Routes...
    Route::get('login', 'Auth\AuthController@showLoginForm')->name('login');
    Route::post('login', 'Auth\AuthController@login');
    Route::get('logout', 'Auth\AuthController@logout')->name('logout');
    Route::get('/', 'HomeController@index')->name('home');
    Route::group(['as' => 'admin::'], function () {
      Route::get('admin', ['as' => 'index', 'uses' => 'AdminController@index']);
      Route::get('admin/reset', ['as' => 'reset', 'uses' => 'AdminController@getReset']);
      Route::post('admin/reset', ['as' => 'reset.post', 'uses' => 'AdminController@postReset']);
    });
    Route::group(['as' => 'emails::'], function () {
      Route::get('settings/emails', ['as' => 'index', 'uses' => 'EmailController@index']);
      Route::get('settings/emails/{id}/edit', ['as' => 'edit', 'uses' => 'EmailController@editEmail']);
      Route::post('settings/admin/{id}/edit', ['as' => 'edit.post', 'uses' => 'EmailController@storeEmail']);
    });
    Route::group(['as' => 'candidates::'], function () {
      Route::get('candidates', ['as' => 'index', 'uses' => 'CandidateController@index']);
      Route::get('candidates/export', ['as' => 'export', 'uses' => 'CandidateController@export']);
      Route::get('candidates/{id}/edit', ['as' => 'edit', 'uses' => 'CandidateController@edit']);
      Route::post('candidates/{id}/edit', ['as' => 'edit.save', 'uses' => 'CandidateController@save']);
      Route::get('candidates/add', ['as' => 'add', 'uses' => 'CandidateController@add']);
      Route::post('candidates/add', ['as' => 'add.save', 'uses' => 'CandidateController@saveNew']);
      Route::get('candidates/nominate', ['as' => 'nominate', 'uses' => 'CandidateController@nominate']);
      Route::post('candidates/{id}/nominate', ['as' => 'nominate.save', 'uses' => 'CandidateController@saveNominee']);
      Route::get('candidates/nominate/search', ['as' => 'nominate.search', 'uses' => 'CandidateController@searchCandidates']);
      Route::post('candidates/nominate/search', ['as' => 'nominate.search', 'uses' => 'CandidateController@searchCandidates']);
    });
    Route::group(['as' => 'import::'], function () {
        Route::get('candidates/import', ['as' => 'form', 'uses' => 'ImportController@form']);
        Route::post('candidates/import', ['as' => 'upload', 'uses' => 'ImportController@upload']);
        Route::get('candidates/import/status', ['as' => 'status', 'uses' => 'ImportController@status']);
    });
    Route::group(['as' => 'users::'], function () {
      Route::get('users', ['as' => 'index', 'uses' => 'UserController@index']);
      Route::get('users/{id}/edit', ['as' => 'edit', 'uses' => 'UserController@edit']);
      Route::post('users/{id}/edit', ['as' => 'edit.save', 'uses' => 'UserController@save']);
      Route::post('users/{id}/delete', ['as' => 'delete', 'uses' => 'UserController@delete']);
      Route::get('users/add', ['as' => 'add', 'uses' => 'UserController@add']);
      Route::post('users/add', ['as' => 'add.save', 'uses' => 'UserController@saveNew']);
      Route::get('users/judges', ['as' => 'judges', 'uses' => 'UserController@judges']);
    });
    Route::group(['as' => 'application::'], function () {
      Route::get('application/edit', ['as' => 'form', 'uses' => 'ApplicationController@getForm']);
      Route::post('application/edit', ['as' => 'form.update', 'uses' => 'ApplicationController@storeForm']);
      Route::get('application/{id?}', ['as' => 'view', 'uses' => 'ApplicationController@viewApplication']);
      Route::post('application/adminEdit', ['as' => 'form.updateForm', 'uses' => 'ApplicationController@updateForm']);
      Route::get('application/adminEdit/{id?}', ['as' => 'adminEdit', 'uses' => 'ApplicationController@adminEditApplication']);
      Route::get('application/round2/{id?}', ['as' => 'round2', 'uses' => 'ApplicationController@viewApplication']);
    });
    Route::group(['as' => 'settings::'], function () {
      Route::get('settings/application', ['as' => 'application', 'uses' => 'SettingsController@showApplicationSettings']);
      Route::post('settings/application', ['as' => 'application.update', 'uses' => 'SettingsController@storeApplicationSettings']);
      Route::get('settings/states', ['as' => 'states', 'uses' => 'SettingsController@showApplicationStates']);
      Route::get('settings/state/{id}', ['as' => 'state.get', 'uses' => 'SettingsController@getApplicationState']);
      Route::post('settings/state{id}', ['as' => 'state.update', 'uses' => 'SettingsController@storeApplicationState']);
    });
    Route::group(['as' => 'judging::'], function () {
      Route::get('judging/round-1', ['as' => 'round1', 'uses' => 'JudgeController@getRound1']);
      Route::get('judging/{candidateid}/round-1', ['as' => 'round1.rate', 'uses' => 'JudgeController@getRateForm']);
      Route::post('judging/{candidateid}/round-1', ['as' => 'round1.rate.save', 'uses' => 'JudgeController@storeRateForm']);
      Route::get('judging/round2', ['as' => 'round2', 'uses' => 'JudgeController@getRound2']);
      Route::get('judging/round-2/{candidateid}', ['as' => 'round2.rate', 'uses' => 'JudgeController@getRound2RateForm']);
      Route::post('judging/round-2/{candidateid}', ['as' => 'round2.rate.save', 'uses' => 'JudgeController@storeRound2']);
      Route::post('judging/assign', ['as' => 'assign', 'uses' => 'JudgeController@assign']);
    });
    Route::group(['as' => 'results::'], function () {
        Route::get('results/top-100', ['as' => 'top100', 'uses' => 'ResultsController@showTop100']);
        Route::get('results/round-2', ['as' => 'round2', 'uses' => 'ResultsController@showRound2']);
        Route::post('results', ['as' => 'calculate', 'uses' => 'ResultsController@calculate']);
        Route::get('results/round2totals', ['as' => 'round2totals', 'uses' => 'ResultsController@showRound2Totals']);
        Route::get('results/export', ['as' => 'export', 'uses' => 'ResultsController@export']);
    });
    Route::group(['as' => 'recommendations::'], function () {
        Route::get('recommendations', ['as' => 'index', 'uses' => 'RecommendationController@index']);
        Route::get('recommendations/search', ['as' => 'search', 'uses' => 'RecommendationController@search']);
        Route::post('recommendations/search', ['as' => 'search', 'uses' => 'RecommendationController@search']);
        Route::get('recommend/{id}', ['as' => 'recommend', 'uses' => 'RecommendationController@getForm']);
        Route::post('recommend/{id}', ['as' => 'recommend.save', 'uses' => 'RecommendationController@storeForm']);
        Route::get('recommendations/request', ['as' => 'request', 'uses' => 'RecommendationController@request']);
        Route::post('recommendations/request', ['as' => 'request', 'uses' => 'RecommendationController@emailRequest']);
        Route::get('recommendation/adminEdit/{id}/{cid}', ['as' => 'adminEdit', 'uses' => 'RecommendationController@adminEdit']);
        Route::post('recommendation/adminEdit/{id}/{cid}', ['as' => 'adminsave', 'uses' => 'RecommendationController@adminStoreForm']);
    });
    Route::group(['as' => 'guests::'], function () {
        Route::get('guests', ['as' => 'admin', 'uses' => 'GuestController@admin']);
        Route::get('guests/export', ['as' => 'export', 'uses' => 'GuestController@export']);
        Route::get('guests/manage', ['as' => 'manage', 'uses' => 'GuestController@manage']);
        Route::post('guests/manage', ['as' => 'add', 'uses' => 'GuestController@add']);
        Route::post('guests/manage/{id}', ['as' => 'delete', 'uses' => 'GuestController@delete']);
    });
});
