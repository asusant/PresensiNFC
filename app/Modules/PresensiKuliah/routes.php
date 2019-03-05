<?php

$slug = strtolower($module);

Route::group(['namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug, $module) {

	Route::get('/{id}/create', $module.'Controller@postCreate')->name('matakuliah.'.$slug.'.post.validate');	//Create

	Route::post('/{id}/create/post', $module.'Controller@postCreatePresensi')->name('matakuliah.'.$slug.'.post.presensi.validate');	//Create

	Route::get('/{id}', $module.'Controller@index')->name('matakuliah.'.$slug.'.read');	//Read
	Route::get('/{id}/get-data', $module.'Controller@getData')->name('matakuliah.'.$slug.'.get-data.read');

	Route::get('/details/{id}', $module.'Controller@details')->name('matakuliah.'.$slug.'.details.read');	//Update
	Route::post('/update', $module.'Controller@postUpdate')->name('matakuliah.'.$slug.'.post.update');

	Route::get('/delete/{id}', $module.'Controller@delete')->name('matakuliah.'.$slug.'.delete');	//Delete

	Route::get('/update/{id}', $module.'Controller@getUpdate')->name('matakuliah.'.$slug.'.get.validate');

	//custom or additional route goes below
	//
	
});
