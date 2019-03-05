<?php

$slug = strtolower($module);

Route::group(['namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug, $module) {

	Route::post('/create', $module.'Controller@postCreate')->name('praktikumdosen.nonaktif.post.create');	//Create

	Route::get('/', $module.'Controller@index')->name('praktikumdosen.nonaktif.read');	//Read
	Route::get('/get-data', $module.'Controller@getData')->name('praktikumdosen.nonaktif.get-data.read');

	Route::get('/details/{id}', $module.'Controller@details')->name('praktikumdosen.nonaktif.details.read');	//Update
	Route::post('/update', $module.'Controller@postUpdate')->name('praktikumdosen.nonaktif.post.update');

	Route::get('/delete/{id}', $module.'Controller@delete')->name('praktikumdosen.nonaktif.delete');	//Delete

	//custom or additional route goes below

});
