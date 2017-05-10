<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// GET
Route::get('/', function() {
    return json_encode('Phinestversion API');
});
Route::get('/songs', 'SongsController@getAllSongs');
Route::get('/songs/rankings', 'SongsController@getRankings');
Route::get('/songs/{id}', 'SongsController@getSongById')->where('id', '[0-9]+');
Route::get('/songs/{slug}', 'SongsController@getSongBySlug')->where('slug', '[a-zA-Z0-9-]+');
Route::get('/songs/rankings', 'SongsController@getRankings');
Route::get('/songs/rankings/{slug}', 'SongsController@getRankingsBySlug')->where('slug', '[a-zA-Z0-9-]+');
Route::get('/songs/search/{songname}', 'SearchController@searchSongs')->where('songname', '[a-zA-Z0-9-]+');

Route::get('/shows', 'ShowsController@getAllShows');
Route::get('/shows/{id}', 'ShowsController@getShowById')->where('id', '[0-9]+');
Route::get('/shows/{date}', 'ShowsController@getShowByDate')->where('date', '[0-9-]+');
Route::get('/shows/rankings', 'ShowsController@getAllShowRankings');
Route::get('/shows/rankings/{year}', 'ShowsController@getShowRankings')->where('year', '[0-9]{4}');
Route::get('/shows/rankings/{date}', 'ShowsController@getShowRanking')->where('date', '[0-9-]+');
Route::get('/shows/search/{showdate}', 'SearchController@searchShows')->where('showdate', '[0-9-]+');

Route::get('/years/rankings', 'ShowsController@getAllYearRankings');
Route::get('/years/rankings/{year}', 'ShowsController@getYearRanking')->where('year', '[0-9]{4}');
Route::get('/years/search/{year}', 'SearchController@searchYears')->where('year', '[0-9]+');

Route::get('/venues', 'VenuesController@getAllVenues');
Route::get('/venues/{id}', 'VenuesController@getVenueById')->where('id', '[0-9]+');
Route::get('/venues/{slug}', 'VenuesController@getVenueBySlug')->where('slug', '[a-zA-Z0-9-]+');

Route::get('/comments', 'CommentsController@getAllComments');
Route::get('/comments/{id}', 'CommentsController@getCommentById')->where('id', '[0-9]+');
Route::get('/comments/user/{id}', 'CommentsController@getCommentsByUserId')->where('id', '[0-9]+');
Route::get('/comments/submission/{id}', 'CommentsController@getCommentsBySubmissionId')->where('id', '[0-9]+');
Route::get('/comments/count/submission/{id}', 'CommentsController@getCommentsBySubmissionIdCount')->where('id', '[0-9]+');

Route::get('/submissions', 'SubmissionsController@getAllSubmissions');
Route::get('/submissions/{id}', 'SubmissionsController@getSubmissionById')->where('id', '[0-9]+');
Route::get('/submissions/song/{id}', 'SubmissionsController@getSubmissionsBySongId')->where('id', '[0-9]+');
Route::get('/submissions/slug/{slug}', 'SubmissionsController@getSubmissionsBySlug')->where('slug', '[a-zA-Z0-9-]+');
Route::get('/submissions/show/{id}', 'SubmissionsController@getSubmissionsByShowId')->where('id', '[0-9]+');
Route::get('/submissions/user/{id}', 'SubmissionsController@getSubmissionsByUserId')->where('id', '[0-9]+');
Route::get('/submissions/user/{username}', 'SubmissionsController@getSubmissionsByUserName')->where('username', '[a-zA-Z0-9-]+');
Route::get('/submissions/rankings/{date}', 'SubmissionsController@getRankingsByDate')->where('date', '[0-9-]+');

Route::get('/votes', 'VotesController@getAllVotes');
Route::get('/votes/user/{id}', 'VotesController@getVotesByUserId')->where('id', '[0-9]+');
Route::get('/votes/submission/{id}', 'VotesController@getVotesBySubmissionId')->where('id', '[0-9]+');
Route::get('/votes/type', 'VotesController@getVoteTypeBySubmissionId');

Route::get('/users', 'UsersController@getAllUsers');
Route::get('/users/rankings', 'UsersController@getUserRankings');
Route::get('/users/{id}', 'UsersController@getUserById')->where('id', '[0-9]+');
Route::get('/users/{username}', 'UsersController@getUserByUsername')->where('username', '[a-zA-Z0-9-]+');
Route::get('/users/search/{username}', 'SearchController@searchUsers')->where('username', '[a-zA-Z0-9-]+');

// POST
Route::post('/users/auth', 'UsersController@loginUser');
Route::post('/users/register', 'UsersController@registerUser');

Route::post('/submissions/save', 'SubmissionsController@saveSubmission');
Route::post('/submissions/save/score', 'SubmissionsController@saveSubmissionScore');

Route::post('/comments/save', 'CommentsController@saveComment');

Route::post('/votes/save', 'VotesController@submitVote');
