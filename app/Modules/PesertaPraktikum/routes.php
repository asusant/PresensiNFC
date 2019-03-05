<?php

$slug = strtolower($module);

Route::group(['namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug, $module) {

	Route::post('/create', $module.'Controller@postCreate')->name('praktikum.'.$slug.'.post.create');	//Create

	Route::get('/', $module.'Controller@index')->name('praktikum.'.$slug.'.read');	//Read
	Route::get('/get-data/{id}', $module.'Controller@getData')->name('praktikum.'.$slug.'.get-data.read');

	Route::get('/details/{id}', $module.'Controller@details')->name('praktikum.'.$slug.'.details.read');	//Update
	Route::post('/update', $module.'Controller@postUpdate')->name('praktikum.'.$slug.'.post.update');

	Route::get('/delete/{id}', $module.'Controller@delete')->name('praktikum.'.$slug.'.delete');	//Delete

	//custom or additional route goes below

});
