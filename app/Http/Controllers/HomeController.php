<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\UserLevel;
use App\Models\Country;
use Yajra\Datatables\Datatables;
use App\Models\Log;
use App\Models\Level;
use App\Models\Content;
use App\User;
use DB;

class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
		$data['user'] = Auth::user();
		$data['level'] = Level::find(session('id_level'));

        return view('pages.dashboard', $data);
    }

    /**
     * [users -> Show Users]
     * @return [type] [description]
     */
	public function users()
	{
		$data['users'] = User::where('id', '<>', 3)->get();
		$data['levels'] = Level::all();
		$data['level_form'] = Level::where('id', '<>', 1)->get();
		$data['delete_route'] = route('users.delete', ['id_user'=>null]);
		$data['detail_route'] = route('users.details.read', ['id_user'=>null]);
		//dd($data['users']);
		foreach ($data['users'] as $key => $user) {
			$data['users'][$key]->level = UserLevel::leftJoin('levels', 'levels.id', 'user_levels.id_level')->where('id_user', $user->id)->get();
		}
		//dd($data['users'][0]->level);
		return view('pages.users', $data);
	}

	/**
	 * [checkLevelAction Check Action for User Trying to read / make change higher user]
	 * @param  [type] $id_level_checker [Id Lever user that want to do an action]
	 * @param  [type] $id_user_action   [Id user that will be change/read]
	 * @return [type]                   [True if allow]
	 */
	public function checkLevelAction($id_level_checker, $id_user_action)
	{
		$checkedUserLevel = UserLevel::where('id_user', $id_user_action)->get();
		$allow = 1;
		foreach ($checkedUserLevel as $checkedUser) {
			if ($checkedUser->id_level < $id_level_checker) {
				$allow = 0;
			}
		}

		if ($allow == 0) {
			return false;
		}else{
			return true;
		}
	}

	/**
	 * [detailsUser description]
	 * @param  [type] $id_user [description]
	 * @return [type]          [description]
	 */
	public function detailsUser($id_user)
	{
		if (!$this->checkLevelAction(session('id_level'), $id_user)) {
			abort('404');
		}
		$data['user'] = User::where('id', $id_user)->first();
		$data['user']['levels'] = UserLevel::leftjoin('levels', 'user_levels.id_level', 'levels.id')->where('id_user', $id_user)->get();
		return json_encode($data['user']);
	}

	/**
	 * [createUser -> Insert New User by Form]
	 * @param  Request $reuest [description]
	 * @return [type]          [description]
	 */
	public function createUser(Request $request)
	{
		$this->validate($request, [
            'name' => 'required|string|max:191',
            'username' => 'required|string|max:191|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'level' => 'required|array',
            'phone' => 'required|numeric',
        ]);

        if (in_array(session('id_level'), $request->input('level')) || in_array('1', $request->input('level'))){
        	abort('404', "What are You even trying?");
        }

        $addedUser = new User;

        $addedUser->name = $request->input('name');
        $addedUser->username = $request->input('username');
        $addedUser->password = bcrypt($request->input('password'));
        $addedUser->phone = $request->input('phone');

        $addedUser->save();

        foreach ($request->input('level') as $row) {
        	$userLevels = new UserLevel;
        	$userLevels->id_user = $addedUser->id;
        	$userLevels->id_level = $row;
        	$userLevels->save();
        }

        return redirect(route('users.read'))->with('message_sukses', 'User Successfully Added!');
	}

	/**
	 * [updateUser description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function updateUser(Request $request)
	{
		$id = $request->input('edit_id_user');
		$this->validate($request, [
            'edit_id_user' => 'required|integer|exists:users,id',
            'edit_name' => 'required|string|max:191',
            'username' => 'required|unique:users,username,'.$id,
            'edit_level' => 'required|array',
            'password' => 'nullable|string|min:6|confirmed',
            'edit_phone' => 'required|numeric',
        ]);

		if (!$this->checkLevelAction(session('id_level'), $request->input('edit_id_user'))) {
			abort('404');
		}

		$user = User::find($request->input('edit_id_user'));

        $user->name = $request->input('edit_name');
        $user->username = $request->input('username');
        $user->phone = $request->input('edit_phone');

		if (null !== $request->input('password')) {
			$user->password = bcrypt($request->input('password'));
        }

        $user->save();

        $levelNow = UserLevel::where('id_user', '=', $request->input('edit_id_user'))->get(['id_level']);

        $arrayLevelDelete = array();
        $arrayLevelInsert = array();
        $arrayNowOneD = array();

        foreach ($levelNow as $level) {
        	array_push($arrayNowOneD, $level['id_level']);
        	if (!in_array($level['id_level'], $request->input('edit_level'))) {
        		array_push($arrayLevelDelete, $level['id_level']);
        	}
        }

        foreach ($request->input('edit_level') as $level) {
        	if (!in_array($level, $arrayNowOneD)) {
        		array_push($arrayLevelInsert, $level);
        	}
        }

        foreach ($arrayLevelDelete as $deleteLevel) {
        	UserLevel::where('id_level', $deleteLevel)
			    	->where('id_user', $request->input('edit_id_user'))
			    	->delete();
        }

        foreach ($arrayLevelInsert as $insertLevel) {
        	$newUserLevel = new UserLevel;
        	$newUserLevel->id_user = $request->input('edit_id_user');
        	$newUserLevel->id_level = $insertLevel;
        	$newUserLevel->save();
        }
				if($request->input('edit_id_user') == Auth::user()->id){
					 	return redirect(route('profile.read'))->with('message_sukses', 'Profil berhasil diperbarui!');
				}else{
						return redirect(route('users.read'))->with('message_sukses', 'User Successfully Changed!');
				}


	}

	/**
	 * [deleteUser -> Delete User by ID]
	 * @param  [type] $id_user [description]
	 * @return [type]          [description]
	 */
	public function deleteUser($id_user)
	{
		//dd('Deleted!');
		$userLevels = UserLevel::where('id_user', $id_user)->where('id_level', 1)->count();
		if ($userLevels > 0) {
			abort('404', "What are You even trying?");
		}

		User::destroy($id_user);
		UserLevel::where('id_user', $id_user)->delete();

		return redirect(route('users.read'))->with('message_sukses', 'User Has Been Deleted!');
	}

	// public function dashboard()
	// {
	// 	// session(['id_level' => 1]);
	// 	return view('pages.dashboard');
	// }

	public function content()
	{
		// dd(session('id_level'));
		return view('pages.contents');
	}

	public function exampleExpandableTable()
	{
		// dd(session('id_level'));
		return view('layouts.sublayout.table-expand');
	}

	public function exampleNormalTable()
	{
		// dd(session('id_level'));
		return view('layouts.sublayout.table-normal');
	}

	public function exampleForm()
	{
		// dd(session('id_level'));
		return view('layouts.sublayout.form');
	}

	public function exampleFormAdvance()
	{
		// dd(session('id_level'));
		return view('layouts.sublayout.form-advance');
	}

	public function configLevels()
	{
			$data['level'] = Level::all();

			return view('pages.level', $data);
	}

	public function configLog()
	{
			return view('pages.log');
	}

	public function getData(Datatables $datatables, Request $request)
	{
			DB::statement(DB::raw('set @no=0'));

			$data = Log::leftJoin('users', 'log.id_user', 'users.id')
														->get([
																DB::raw('@no  := @no  + 1 AS no'),
																'users.name',
																'log.aktivitas',
																'log.created_at as created_at'
															]);

			$datatables = Datatables::of($data);
					if ($keyword = $request->get('search')['value']) {
							$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
					}

			return $datatables
					->orderColumn('user', 'user $1')
					->editColumn('created_at', function ($data) {

						return Content::tanggal_indo($data->created_at, true);
					})
					->make(true);
	}




}
