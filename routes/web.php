<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	if (Auth::check()){
        return redirect(route('dashboard.read'));
	}else{
        return redirect(route('login'));
    }
    //return view('welcome');
})->name('dashboard.slash.read');

Route::get('/layouting', function () {
    return view('pages.dashboard');
});
Route::get('/foo', function () {
    return Artisan::call('make:module', [
        'name' => 'Juki'
    ]);

    //
});


Auth::routes();

Route::post('/login', 'Auth\LoginController@authenticate')->name('login.post');
Route::get('register', function () {return view('auth.register');	})->name('register');

Route::get('/insert/privileges/{id_level}/{id_menu}/{create}/{read}/{update}/{delete}', function ($id_level, $id_menu, $create, $read, $update, $delete) {
	$privileges = DB::table('previleges')->insert(
		[
			'id_level' => $id_level,
			'id_menu' => $id_menu,
			'create' => $create,
			'read' => $read,
			'update' => $update,
			'delete' => $delete,
		]
	);
	return json_encode($privileges);
})->name('privileges');

Route::get('/profile', 'HomeController@profile')->name('profile.read');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test/{id}', 'BaseController@getMenuAsLevel')->name('test');
Route::get('/levels/{id}', 'BaseController@changeLevel')->name('change-level');
Route::get('/semester/change/{id}', 'BaseController@changeSemester')->name('change-semester');

Route::get('/api/{suhu}/{ph}', 'MonitoringController@inputMonitoring')->name('api.create');

/**
 * Daftar Menu
 */

/*
User Route
 */
Route::get('/users', 'HomeController@users')->name('users.read');
Route::get('/users/delete/{id_user}', 'HomeController@deleteUser')->name('users.delete');
Route::get('/users/details/{id_user}', 'HomeController@detailsUser')->name('users.details.read');
Route::post('/users/create', 'HomeController@createUser')->name('users.create');
Route::post('/users/update', 'HomeController@updateUser')->name('users.update');


Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard.read');
Route::get('/content', 'HomeController@content')->name('contents.read');
Route::get('/content/frontend', 'HomeController@content')->name('contents.frontend.read');
// Route::get('/config/level', 'HomeController@configLevels')->name('configs.levels.read');
Route::get('/config/privileges', 'HomeController@configPrivileges')->name('configs.privileges.read');
Route::get('/config/menus', 'HomeController@configMenus')->name('configs.menus.read');
Route::get('/log', 'HomeController@configLog')->name('log.read');
Route::get('/log/get-data', 'HomeController@getData')->name('log.get-data.read');
