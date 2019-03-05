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
	
	Route::post('/submenus/create/{id_menu}', 'SubmenuController@postCreate')->name('configs.'.$slug.'.submenus.post.create');	//Create
	Route::get('/submenus/get-data/{id_menu}', 'SubmenuController@getData')->name('configs.'.$slug.'.submenus.get-data.read');
	Route::post('/submenus/update', 'SubmenuController@postUpdate')->name('configs.'.$slug.'.submenus.post.update');

	Route::get('/submenus/{id_menu}', 'SubmenuController@index')->name('configs.'.$slug.'.submenus.read');	//Read Submenus

	Route::get('/submenus/details/{id}', 'SubmenuController@details')->name('configs.'.$slug.'.submenus.details.read');	//Update

	Route::get('/submenus/delete/{id}', 'SubmenuController@delete')->name('configs.'.$slug.'.submenus.delete');	//Delete

});