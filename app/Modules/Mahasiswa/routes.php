<?php

$slug = strtolower($module);

Route::group(['namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug, $module) {

	Route::post('/create', $module.'Controller@postCreate')->name($slug.'.post.create');	//Create

	Route::get('/', $module.'Controller@index')->name($slug.'.read');	//Read
	Route::get('/get-data', $module.'Controller@getData')->name($slug.'.get-data.read');

	Route::get('/details/{id}', $module.'Controller@details')->name($slug.'.details.read');	//Update
	Route::post('/update', $module.'Controller@postUpdate')->name($slug.'.post.update');

	Route::get('/delete/{id}', $module.'Controller@delete')->name($slug.'.delete');	//Delete

	Route::post('/upload', $module.'Controller@postUpload')->name($slug.'.post.upload.create');	//Create

	//custom or additional route goes below

});
