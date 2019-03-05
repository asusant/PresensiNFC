<?php

$slug = strtolower($module);

Route::group(['namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug, $module) {

	Route::post('/create', $module.'Controller@postCreate')->name('configs.'.$slug.'.post.create');	//Create

	Route::get('/', $module.'Controller@index')->name('configs.'.$slug.'.read');	//Read
	Route::get('/get-data', $module.'Controller@getData')->name('configs.'.$slug.'.get-data.read');

	Route::get('/details/{id}', $module.'Controller@details')->name('configs.'.$slug.'.details.read');	//Update
	Route::post('/update', $module.'Controller@postUpdate')->name('configs.'.$slug.'.post.update');

	Route::get('/delete/{id}', $module.'Controller@delete')->name('configs.'.$slug.'.delete');	//Delete

	//custom or additional route goes below

});
