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

Route::group(['prefix' => 'questions', 'as' => 'questions.'], static function () {
    Route::group(['prefix' => '{question}', 'middleware' => 'verified'], static function () {
        Route::post('upvote', 'QuestionController@upvote')
            ->name('upvote');

        Route::post('downvote', 'QuestionController@downvote')
            ->name('downvote');

        Route::post('bookmark', 'Questions\\BookmarkController')
            ->name('bookmark');

        Route::post('unbookmark', 'Questions\\UnbookmarkController')
            ->name('unbookmark');

        Route::post('restore', 'QuestionController@restore')
            ->name('restore')
            ->withTrashed();

        Route::group(['prefix' => 'answers/{answer}', 'as' => 'answers.'], static function () {
            Route::delete('destroy', 'AnswerController@destroy')
                ->name('destroy')
                ->withTrashed();

            Route::post('restore', 'AnswerController@restore')
                ->name('restore')
                ->withTrashed();

            Route::post('upvote', 'AnswerController@upvote')
                ->name('upvote');

            Route::post('downvote', 'AnswerController@downvote')
                ->name('downvote');

            Route::post('solution', 'AnswerController@solution')
                ->name('solution');
        });
    });
});

Route::resource('questions.answers', 'AnswerController')
    ->only('store', 'edit', 'update')
    ->middleware('verified');

Route::resource('questions.answers', 'AnswerController')
    ->only('index');


/**
 * Users
 */
Route::resource('users', 'UserController')
    ->only('index', 'show', 'edit', 'update');

Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => 'auth'], static function () {
    Route::group(['prefix' => '{user}'], static function () {
        Route::get('bookmarks', 'Users\\BookmarkController')
            ->name('bookmarks.index');
    });
});

/**
 * Notifications
 */
Route::get('notifications/{id:uuid}', 'NotificationController@show')
    ->name('notifications.show')
    ->middleware('auth');
