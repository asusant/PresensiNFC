<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Modules\Semester\Models\Semester;
use App\Models\Previlege;
use App\Models\UserLevel;
use App\Models\Submenu;
use App\Models\Menu;
use App\User;
use DB;

class BaseController extends Controller
{
	var $base;
    public function __construct()
    {

    }

	public static function getMenuAsLevel($id_level)
	{
		$menus = Menu::leftJoin('previleges', 'previleges.id_menu', 'menus.id')
						->where('id_level', $id_level)
						->where('previleges.read', 1)
						->whereNull('menus.deleted_at')
						->orderBy('menus.urutan')
						->get();
		//dd($menus);
		return $menus;
	}

	public static function getAccess($id_level, $route)
	{
		$elm = explode('.', $route);
		$menu = reset($elm);

		$aksi = end($elm);

		$akses = Previlege::join('menus', 'menus.id', 'previleges.id_menu')
							->where('menus.route', $menu)
							->where('previleges.id_level', $id_level)
							->first();
		return $akses[$aksi];

	}

	public function getLevels()
	{
		$id = Auth::user()->id;
		$levels = UserLevel::join('levels', 'levels.id', 'user_levels.id_level')->where('id_user', $id)->get(['level', 'id_level']);
		return $levels;
	}

	public function getMainVariables()
	{
		$this->base['menus'] = $this->getMenuAsLevel(session('id_level'));
		return $this->base;
	}

	public static function getSubmenu($id_menu)
	{
		return Submenu::where('id_menu', $id_menu)->orderBy('urutan')->get();
	}

	public static function getLevelsByIdUser($id_user)
	{
		$level = UserLevel::where('id_user', $id_user)->get();
		return end($level);
	}

	public static function getLevelsNameByIdUser($id_user)
	{
		$level = UserLevel::leftJoin('levels', 'levels.id', 'user_levels.id_level')->where('id_user', $id_user)->get();
		return end($level);
	}

	public static function getHighestLevelsByIdUser($id_user)
	{
		$level = UserLevel::leftJoin('levels', 'levels.id', 'user_levels.id_level')->where('id_user', $id_user)->orderBy('levels.id', 'asc')->first();
		// dd($level);
		return $level;
	}

	public static function setLevelSession($id_level)
	{
		session(['id_level'=> $id_level]);
	}

	public static function getLevelSession()
	{
		$level = session('id_level');
		return $level;
	}

	public function changeLevel($id_level, Request $request)
	{
		$check = UserLevel::where('id_level', $id_level)->where('id_user', Auth::user()->id)->count();
		if ($check < 1) {
			abort('404');
		}
		session(['id_level'=> $id_level]);
		return redirect(route('dashboard.read'));;
	}

	public function changeSemester($id_semester, Request $request)
	{
		$check = Semester::find($id_semester);
		if ($check->count() < 1) {
			abort('404');
		}
		session(['id_semester'=> $id_semester]);
		return redirect(route('dashboard.read'));;
	}

	public static function getSemester()
	{
		return Semester::orderBy('id', 'desc')->take(6)->get();
	}

	public static function getSemesterAktif()
	{
		return Semester::find(session('id_semester'));
	}

	public static function getLastSemester()
	{
		return Semester::orderBy('id', 'desc')->first();
	}

}
