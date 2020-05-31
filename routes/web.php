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

Route::get('/', 'HomeController@index')->name('home');

Route::resource('questions', 'QuestionController');
Route::resource('questions/{question}/answers', 'AnswerController')->only(
    ['store', 'edit', 'update', 'destroy']
);

Route::post('questions/{question}/answers/{answer}/restore', 'AnswerController@restore')
    ->name('answers.restore');

Route::post('questions/{question}/answers/{answer}/upvote', 'AnswerController@upvote')
    ->name('answers.upvote');

Route::post('questions/{question}/answers/{answer}/downvote', 'AnswerController@downvote')
    ->name('answers.downvote');

Route::get('search', 'SearchController@index')->name('search');
