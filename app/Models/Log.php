<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Log extends Model
{
		use SoftDeletes;

	  protected $dates = ['deleted_at'];
    protected $table = 'log';
  	protected $fillable = ['*'];

		public static function log($action, $objek, $id_objek)
		{
				// $id_user = Auth::user()->id;
				// $user = User::find($id_user);
				//
				// $log = new Log();
				// $log->id_user = $id_user;
				// $log->nama_tabel = $objek;
				// $log->id_objek = $id_objek;
				// $log->aktivitas = $action;
				// // $log->created_by = 9999; //GOD's user id;
				// if($action == 'c'){
				// 	$log->kalimat = $user->name.' menambahkan '
				// }elseif ($action == 'u') {
				// 	$log->kalimat = $user->name.' memperbarui '
				// }elseif ($action == 'd') {
				// 	$log->kalimat = $user->name.' menghapus '
				// }
				//
				// $log->save();

				// This activity is done by GOD

		}

		public static function aktivitas($aktivitas)
		{
			$data = new Log();
	        $data->id_user = Auth::user()->id;
	        $data->aktivitas = $aktivitas;
	        $data->created_by = Auth::user()->id;
	        $data->save();
		}

		public static function timeElapsed($datetime, $full = false) {
		    $now = new DateTime;
		    $ago = new DateTime($datetime);
		    $diff = $now->diff($ago);

		    $diff->w = floor($diff->d / 7);
		    $diff->d -= $diff->w * 7;

		    $string = array(
		        'y' => 'year',
		        'm' => 'month',
		        'w' => 'week',
		        'd' => 'day',
		        'h' => 'hour',
		        'i' => 'minute',
		        's' => 'second',
		    );
		    foreach ($string as $k => &$v) {
		        if ($diff->$k) {
		            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		        } else {
		            unset($string[$k]);
		        }
		    }

		    if (!$full) $string = array_slice($string, 0, 1);
		    return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

}
