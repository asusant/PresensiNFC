<?php

$slug = strtolower($module);

Route::group(['namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug, $module) {

	Route::post('/{id_mata_kuliah}/create', $module.'Controller@postCreate')->name('matakuliah.'.$slug.'.post.create');	//Create

	Route::get('/{id_mata_kuliah}/', $module.'Controller@index')->name('matakuliah.'.$slug.'.read');	//Read
	Route::get('/{id_mata_kuliah}/get-data', $module.'Controller@getData')->name('matakuliah.'.$slug.'.get-data.read');

	Route::get('/{id_mata_kuliah}/details/{id}', $module.'Controller@details')->name('matakuliah.'.$slug.'.details.read');	//Update
	Route::post('/{id_mata_kuliah}/update', $module.'Controller@postUpdate')->name('matakuliah.'.$slug.'.post.update');

	Route::get('/{id_mata_kuliah}/delete/{id}', $module.'Controller@delete')->name('matakuliah.'.$slug.'.delete');	//Delete

	//custom or additional route goes below

});
