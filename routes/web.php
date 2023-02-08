<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'MainController@index');
Route::get('/login', 'MainController@login');
Route::post('/login/process', 'MainController@login_process')->name('login.process');
Route::get('/logout', 'MainController@logout');

Route::resource('/batch', 'BatchController')->names([
	'store' => 'batch.store',
	'show' => 'batch.show',
	'update' => 'batch.update',
	'destroy' => 'batch.destroy'
]);
Route::resource('/criteria', 'CriteriaController')->names([
	'store' => 'criteria.store',
	'show' => 'criteria.show',
	'update' => 'criteria.update',
	'destroy' => 'criteria.destroy'
]);
Route::get('/criteria/create/{id}', 'CriteriaController@create');
Route::post('/criteria/batch', 'CriteriaController@batch');
Route::get('/criteria_value/detail/{id}', 'CriteriaValueController@detail');
Route::get('/criteria_value/create/{id}', 'CriteriaValueController@create');
Route::resource('/criteria_value', 'CriteriaValueController')->names([
	'store' => 'criteria_value.store',
	'show' => 'criteria_value.show',
	'update' => 'criteria_value.update',
	'destroy' => 'criteria_value.destroy'
]);
Route::get('/criteria_sub/detail/{id}', 'CriteriaSubController@detail');
Route::get('/criteria_sub/create/{id}', 'CriteriaSubController@create');
Route::resource('/criteria_sub', 'CriteriaSubController')->names([
	'store' => 'criteria_sub.store',
	'show' => 'criteria_sub.show',
	'update' => 'criteria_sub.update',
	'destroy' => 'criteria_sub.destroy'
]);


Route::resource('/candidate', 'CandidateController')->names([
	'store' => 'candidate.store',
	'show' => 'candidate.show',
	'update' => 'candidate.update',
	'destroy' => 'candidate.destroy'
]);
Route::post('/candidate/batch', 'CandidateController@batch');
Route::get('/candidate/create/{id}', 'CandidateController@create');
Route::get('/candidate_criteria/detail/{id}', 'CandidateCriteriaController@detail');
Route::get('/candidate_criteria/create/{id}', 'CandidateCriteriaController@create');
Route::resource('/candidate_criteria', 'CandidateCriteriaController')->names([
	'store' => 'candidate_criteria.store',
	'show' => 'candidate_criteria.show',
	'update' => 'candidate_criteria.update',
	'destroy' => 'candidate_criteria.destroy'
]);

Route::get('/fuzzy', 'FuzzyController@index');
Route::post('/fuzzy/batch', 'FuzzyController@batch');
Route::post('/fuzzy/output/store', 'FuzzyController@output_store');
Route::post('/fuzzy/output/update', 'FuzzyController@output_update');
Route::get('/fuzzy/output/delete/{id}', 'FuzzyController@output_delete');
Route::post('/fuzzy/rule_update', 'FuzzyController@rule_update');
Route::post('/fuzzy/pdf', 'FuzzyController@pdf');
Route::post('/fuzzy/result', 'FuzzyController@result_insert');
Route::post('/fuzzy/result_truncate', 'FuzzyController@result_truncate');

Route::get('/smarter', 'SmarterController@index');
Route::post('/smarter/batch', 'SmarterController@batch');
Route::post('/smarter/pdf', 'SmarterController@pdf');
Route::post('/smarter/result', 'SmarterController@result_insert');
Route::post('/smarter/result_truncate', 'SmarterController@result_truncate');

Route::get('/comparison', 'ComparisonController@index');
Route::post('/comparison/batch', 'ComparisonController@batch');
Route::post('/comparison/pdf', 'ComparisonController@pdf');