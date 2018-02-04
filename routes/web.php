<?php
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/newGame', 'HomeController@newGame')->name('newGame');

Route::get('/board/{game_id}', 'GameController@board')->name('gameBoard');
Route::post('/play/{game_id}', 'GameController@play');
Route::post('/game-over/{game_id}', 'GameController@gameOver');
