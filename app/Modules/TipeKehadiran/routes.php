<?php

$slug = strtolower($module);

Route::group(['namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug, $module) {

	Route::post('/create', $module.'Controller@postCreate')->name('configs.tipe-kehadiran.post.create');	//Create

	Route::get('/', $module.'Controller@index')->name('configs.tipe-kehadiran.read');	//Read
	Route::get('/get-data', $module.'Controller@getData')->name('configs.tipe-kehadiran.get-data.read');

	Route::get('/details/{id}', $module.'Controller@details')->name('configs.tipe-kehadiran.details.read');	//Update
	Route::post('/update', $module.'Controller@postUpdate')->name('configs.tipe-kehadiran.post.update');

	Route::get('/delete/{id}', $module.'Controller@delete')->name('configs.tipe-kehadiran.delete');	//Delete

	//custom or additional route goes below

});
