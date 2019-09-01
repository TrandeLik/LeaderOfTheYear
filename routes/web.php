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


Route::get('/admin', 'AdminController@index');
Route::post('/admin', 'AdminController@uploadAchievementTypesFile');

Route::get('/achievements/all', 'AdminController@getAchievementsTable');
Route::post('/achievements/all', 'AdminController@exportAchievementTable');
Route::get('/achievements/all/download/{name}', 'AdminController@downloadAchievementTable');
Route::get('/achievements/sent', 'AdminController@getAllSentAchievements');
Route::get('/achievement/{id}', 'GeneralController@achievementView');
Route::post('/achievement/{id}/reject', 'AdminController@reject');
Route::get('/achievement/{id}/confirm', 'AdminController@confirm');

Route::get('/users/all', 'AdminController@getAllUsers');
Route::get('/user/{id}/profile', 'AdminController@aboutUser');
Route::get('/user/{id}/ban', 'AdminController@ban');
Route::get('/user/{id}/unblock', 'AdminController@unblock');
Route::get('/user/{id}/promote', 'AdminController@promote');
Route::get('/user/{id}/degrade', 'AdminController@degrade');
Route::get('/users/banned', 'AdminController@showBannedUsers');

//Route::post('/achievement_type/add', 'AdminController@addType');
//Route::get('/achievement_type/add', 'AdminController@showAddType');
Route::get('/achievement_types/all', 'AdminController@getAllAchievementTypes');
Route::get('/achievement_types/all/delete', 'AdminController@deleteAll');
Route::post('/achievement_types/delete_selected', 'AdminController@deleteSelected');
Route::post('/achievement_types/all', 'AdminController@uploadAchievementTypesFile');
Route::get('/achievement_types/download_file', 'AdminController@downloadAchievementTypesFile');
Route::get('/achievement_type/{id}/delete', 'AdminController@deleteAchievementType');
//Route::get('/achievement_type/{id}/edit', 'AdminController@getEditTypeView');
//Route::post('/achievement_type/{id}/edit', 'AdminController@editAchievementType');


Route::get('/settings', 'AdminController@settingsView');
Route::post('/settings', 'AdminController@settingsUpdate');
Route::get('/leaderboard/export', 'AdminController@exportLeaderboard');



Route::get('/user', 'UserController@index');
Route::get('/achievement/add/new', 'UserController@addView');
Route::post('/achievement/add/new', 'UserController@addAchievement');
Route::get('/achievement/{id}/send', 'UserController@send');
Route::get('/achievement/{id}/return', 'UserController@return');
Route::get('/achievement/{id}/delete', 'UserController@delete');
Route::get('/achievement/{id}/edit', 'UserController@editView');
Route::post('/achievement/{id}/edit', 'UserController@edit');



Route::get('/leaderboard', 'GeneralController@leaderboard');
Route::get('/profile', 'GeneralController@profile');
Route::get('/profile/edit', 'GeneralController@profileEditView');
Route::post('/profile/edit', 'GeneralController@profileEdit');
Route::get('/profile/password_change', 'GeneralController@passwordChangeView');
Route::post('/profile/password_change', 'GeneralController@passwordChange');
Route::get('/error', 'GeneralController@error');
Route::get('/achievement/{id}/download_confirmation', 'GeneralController@downloadConfirmation');



Route::get('/alert_for_banned_users', 'GeneralController@getAlertForBannedUsers')->middleware(\App\Http\Middleware\CheckBannedUser::class);



Route::get('/', 'VisitorController@about');