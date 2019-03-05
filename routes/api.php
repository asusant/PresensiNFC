<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('login', 'UserApiController@login');
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('user', 'UserApiController@getAuthUser');
    Route::get('mata-kuliah', 'UserApiController@getMataKuliah');

    Route::get('new-pertemuan', 'UserApiController@newPertemuan'); # {id_mata_kuliah}

    Route::get('presensi-done', 'UserApiController@getSudahPresensi'); # {id_pertemuan_kuliah}
    Route::get('presensi-wait', 'UserApiController@getBelumPresensi'); # {id_pertemuan_kuliah}
    Route::get('presensi-manual', 'UserApiController@insertPresensi'); # {id, nim, kehadiran = null | {A,S,I}, keterangan = null}

	Route::get('tipe-kehadiran', 'UserApiController@getTipeKehadiran');    
	Route::get('hari', 'UserApiController@getHari');    

    Route::post('presensi/insert', 'UserApiController@insertPresensi'); # {id, nim, keterangan = null}
    Route::post('presensi/finish', 'UserApiController@selesaiPresensi'); # {id_pertemuan_kuliah}
});