<?php

Route::get('/logout', function(){
    Auth::logout();
    return redirect('/');
});

Auth::routes();
Route::group(['middleware'=>['auth']],function () {  
// Route::get('/', 'DashboardController@index');
Route::get('/', 'ClubController@index');

//club paths
Route::get('/create-club', 'ClubController@index');
Route::get('/club-stats/{id}/{admin?}', 'ClubController@club_stats');
Route::get('/club-info/{token}', 'ClubController@club_info');
Route::get('/club-info/{token}/awards', 'ClubController@awards');
Route::get('/clubs', 'ClubController@ownclubs');

//movie discussion 
Route::get('/movie/discussion/{title}', 'MovieController@discussion');

//ajax handler path
Route::post('/ajaxhandler', 'AjaxHandler@index');

Route::get('/awards', 'Stats@index');

Route::get('/create-and-pick', function () {
    return view('create-club-pick');
});

});
