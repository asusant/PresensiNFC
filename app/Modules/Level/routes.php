<?php

$slug = strtolower($module);

Route::group(['namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug, $module) {

	Route::get('/', $module.'Controller@index')->name('configs.'.$slug.'.read');
	Route::get('/details/{id}', $module.'Controller@details')->name('configs.'.$slug.'.details.read');
	Route::get('/get-data', $module.'Controller@getData')->name('configs.'.$slug.'.get-data.read');
	Route::post('/update', $module.'Controller@postUpdate')->name('configs.'.$slug.'.post.update');
	Route::get('/delete/{id}', $module.'Controller@delete')->name('configs.'.$slug.'.delete');
	Route::post('/create', $module.'Controller@postCreate')->name('configs.'.$slug.'.post.create');

	Route::get('privilege/{id_level}', $module.'Controller@getPrivileges')->name('configs.'.$slug.'.privileges.validate');
	Route::get('privilege/get-data/{id_level}', $module.'Controller@getDataPrivilege')->name('configs.'.$slug.'.privileges.data.validate');
	Route::get('privilege/{param}/{id_level}/{id_menu}/{access}', $module.'Controller@changePrivileges')->name('configs.'.$slug.'.privileges.change.validate');
	

});