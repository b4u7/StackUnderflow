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

Route::get('/', 'HomeController@index')->name('home');


/**
 * Questions
 */
Route::resource('questions', 'QuestionController');

Route::resource('questions.bookmarks', 'BookmarkController')->only('store', 'destroy');

Route::group(['prefix' => 'questions', 'as' => 'questions.'], static function () {
    Route::post('questions/{question}/upvote', 'QuestionController@upvote')
        ->name('upvote');

    Route::post('questions/{question}/downvote', 'QuestionController@downvote')
        ->name('downvote');
});

/**
 * Answers
 */
Route::resource('questions/{question}/answers', 'AnswerController')->only(
    ['store', 'edit', 'update', 'destroy']
);

Route::group(['prefix' => 'answers', 'as' => 'answers.'], static function () {
    Route::post('questions/{question}/answers/{answer}/restore', 'AnswerController@restore')
        ->name('restore');

    Route::post('questions/{question}/answers/{answer}/upvote', 'AnswerController@upvote')
        ->name('upvote');

    Route::post('questions/{question}/answers/{answer}/downvote', 'AnswerController@downvote')
        ->name('downvote');

    Route::post('questions/{question}/answers/{answer}/solution', 'AnswerController@solution')
        ->name('solution');
});


/**
 * Search
 */
Route::get('search', 'SearchController@index')->name('search');


/**
 * User
 */
Route::resource('user', 'UserController')->only(
    ['index', 'show', 'edit', 'update']
);
