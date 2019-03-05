<?php

$slug = strtolower($module);

Route::group(['namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug, $module) {

	Route::post('/create', $module.'Controller@postCreate')->name($slug.'.post.create');	//Create

	Route::get('/', $module.'Controller@index')->name($slug.'.read');	//Read
	Route::get('/get-data', $module.'Controller@getData')->name($slug.'.get-data.read');

	Route::get('/details/{id}', $module.'Controller@details')->name($slug.'.details.read');	//Update
	Route::post('/update', $module.'Controller@postUpdate')->name($slug.'.post.update');

	Route::get('/delete/{id}', $module.'Controller@delete')->name($slug.'.delete');	//Delete

	Route::get('/daftar/{id}', $module.'Controller@daftar')->name($slug.'.daftar.create');	//Daftar

	Route::get('/batal/daftar/{id}', $module.'Controller@batal')->name($slug.'.batal.create');	//Daftar

	//custom or additional route goes below

});
