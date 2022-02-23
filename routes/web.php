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

Route::get('/', 'HomeController@index')
    ->name('home');

/**
 * Questions and answers
 */
Route::resource('questions', 'QuestionController')
    ->except('index', 'show')
    ->middleware('verified');

Route::resource('questions', 'QuestionController')
    ->only('index', 'show');

Route::group(['prefix' => 'questions/{question}', 'as' => 'questions.', 'middleware' => 'verified'], static function () {
    Route::post('upvote', 'QuestionController@upvote')
        ->name('upvote');

    Route::post('downvote', 'QuestionController@downvote')
        ->name('downvote');

    Route::resource('bookmarks', 'BookmarkController')
        ->only('store', 'destroy');

    Route::group(['prefix' => 'answers/{answer}', 'as' => 'answers.'], static function () {
        Route::post('restore', 'AnswerController@restore')
            ->name('restore');

        Route::post('upvote', 'AnswerController@upvote')
            ->name('upvote');

        Route::post('downvote', 'AnswerController@downvote')
            ->name('downvote');

        Route::post('solution', 'AnswerController@solution')
            ->name('solution');
    });
});

Route::resource('questions.answers', 'AnswerController')
    ->only('store', 'edit', 'update', 'destroy')
    ->middleware('verified');

/**
 * Search
 */
Route::get('search', 'SearchController@index')
    ->name('search');

/**
 * User
 */
Route::resource('user', 'UserController')
    ->only('index', 'show', 'edit', 'update');
