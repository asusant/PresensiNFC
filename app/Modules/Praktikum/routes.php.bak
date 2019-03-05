<?php

$slug = strtolower($module);

Route::group(['namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug, $module) {

	Route::post('/create', $module.'Controller@postCreate')->name($slug.'.aktif.post.create');	//Create

	Route::get('/', $module.'Controller@index')->name($slug.'.aktif.read');	//Read
	Route::get('/get-data', $module.'Controller@getData')->name($slug.'.aktif.get-data.read');

	Route::get('/details/{id}', $module.'Controller@details')->name($slug.'.aktif.details.read');	//Update
	Route::get('/peserta/{id}', $module.'Controller@pesertaPraktikum')->name($slug.'.aktif.peserta.read');	//Update
	Route::post('/update', $module.'Controller@postUpdate')->name($slug.'.aktif.post.update');

	Route::get('/delete/{id}', $module.'Controller@delete')->name($slug.'.aktif.delete');	//Delete

	Route::get('/nonaktif/{id}', $module.'Controller@nonAktif')->name($slug.'.aktif.validate');	//Nonaktif
	
	Route::get('/pendaftaran/{id}', $module.'Controller@pendaftaran')->name($slug.'.aktif.pendaftaran.validate');	//Pendaftaran

	// Nilai
	Route::get('/nilai/get/{id}', $module.'Controller@getNilaiPraktikum')->name($slug.'.nilai.get.nilai.read');	//Read

	Route::get('/nilai/create/{id}', $module.'Controller@nilaiPraktikum')->name($slug.'.nilai.get.update');	//Read

	Route::post('/nilai/create/post/{id}', $module.'Controller@postNilaiPraktikum')->name($slug.'.nilai.post.update');	//Read

	Route::get('/nilai/print/{id}', $module.'Controller@printNilaiPraktikum')->name($slug.'.nilai.print.read');	//Read

});
