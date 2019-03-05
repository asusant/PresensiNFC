<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Stok;
use Illuminate\Support\Facades\Route;
use App\Models\Previlege;

class Content extends Model
{
		use SoftDeletes;

	  protected $dates = ['deleted_at'];

		public static function content($key)
		{
			$data = Content::where('section', $key)->first();
			$count = Content::where('section', $key)->count();
			if ($count == 0) {
				return "";
			}else{
				return $data->content;
			}
		}

	public static function tanggal_indo($tanggal, $cetak_hari = false)
	{
		$hari = array ( 1 =>    'Senin',
			'Selasa',
			'Rabu',
			'Kamis',
			'Jumat',
			'Sabtu',
			'Minggu'
		);

	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
		$split1 	  = explode('-', $tanggal);
		if (strlen($split1[2]) != 2) {
			$split = array();
			foreach ($split1 as $key => $value) {
				if ($key==2) {
					$a	  = explode(' ', $value);
					$split[] = array_push($split, $a[0],$a[1]);
				}else{
					$split[] = $value;
				}
			}
			$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0].' | '. $split[3];
		}else{
			$split	  = explode('-', $tanggal);
			$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
		}

		if ($cetak_hari) {
			$num = date('N', strtotime($tanggal));
			return $hari[$num] . ', ' . $tgl_indo;
		}

		return $tgl_indo;
	}

	public static function menuPermission($action)
	{
		$route = Route::currentRouteName();
		$elm = explode('.', $route);
		$menu = reset($elm);

		// dd($menu);
		// userdd(session('id_level'));

		$previlege = Previlege::leftJoin('menus', 'previleges.id_menu', 'menus.id')->where('menus.route', $menu)->where('previleges.id_level', session('id_level'))->first();
		// dd($previlege);
		if ($previlege->$action == 1) {
			return true;
		}else{
			return false;
		}
	}
}