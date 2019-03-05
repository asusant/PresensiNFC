<?php

$slug = strtolower($module);

Route::group(['namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug, $module) {

	Route::get('/{id}/create', $module.'Controller@postCreate')->name('praktikum.'.$slug.'.post.create.update');	//Create

	Route::post('/{id}/create/post', $module.'Controller@postCreatePresensi')->name('praktikum.'.$slug.'.post.presensi.update');	//Create

	Route::get('/{id}', $module.'Controller@index')->name('praktikum.'.$slug.'.read');	//Read
	Route::get('/{id}/get-data', $module.'Controller@getData')->name('praktikum.'.$slug.'.get-data.read');

	Route::get('/details/{id}', $module.'Controller@details')->name('praktikum.'.$slug.'.details.read');	//Update
	Route::post('/update', $module.'Controller@postUpdate')->name('praktikum.'.$slug.'.post.update');

	Route::get('/delete/{id}', $module.'Controller@delete')->name('praktikum.'.$slug.'.delete');	//Delete

	Route::get('/update/{id}', $module.'Controller@getUpdate')->name('praktikum.'.$slug.'.get.update');	//Delete

	//custom or additional route goes below

});
