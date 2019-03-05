<?php

$slug = strtolower($module);

Route::group(['namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug, $module) {

	Route::post('/create', $module.'Controller@postCreate')->name('praktikum.nonaktif.post.create');	//Create

	Route::get('/', $module.'Controller@index')->name('praktikum.nonaktif.read');	//Read
	Route::get('/get-data', $module.'Controller@getData')->name('praktikum.nonaktif.get-data.read');

	Route::get('/details/{id}', $module.'Controller@details')->name('praktikum.nonaktif.details.read');	//Update
	Route::post('/update', $module.'Controller@postUpdate')->name('praktikum.nonaktif.post.update');

	Route::get('/delete/{id}', $module.'Controller@delete')->name('praktikum.nonaktif.delete');	//Delete

	Route::get('/aktif/{id}', $module.'Controller@aktif')->name('praktikum.nonaktif.validate');	//Delete

	//custom or additional route goes below

});
