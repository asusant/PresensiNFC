<?php
namespace App\Modules\Level\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\Models\Level;
use App\Models\Content;
use App\Models\Menu;
use App\Modules\Level\Models\Privileges;
use DB;
use App\Models\Log;


class LevelController extends Controller {

	protected $slug = 'level';
	protected $module = 'Level';
	protected $title = "User Level";

	public function index()
	{
		$data['level'] = Level::all();
		$data['title'] = $this->title;
		$data['create_route'] = route('configs.'.$this->slug.'.post.create');
		$data['update_route'] = route('configs.'.$this->slug.'.post.update', ['id_'.$this->slug =>null]);
		$data['delete_route'] = route('configs.'.$this->slug.'.delete', ['id_'.$this->slug =>null]);
		$data['detail_route'] = route('configs.'.$this->slug.'.details.read', ['id_'.$this->slug =>null]);
		$data['request_route'] = route('configs.'.$this->slug.'.get-data.read');

		$data['create_button'] = "";
		if(Content::menuPermission('update')){
			$data['create_button'] = '<button class="btn btn-sm btn-default" data-target="#add" data-toggle="modal">
									    <i class="fa fa-plus" aria-hidden="true"></i>
									    <span class="hidden-xs">Tambah '.$this->title.'</span>
									  </button>';
		}

		return view('Level::level', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data = Level::leftJoin('users', 'levels.created_by', 'users.id')
						->get([
								DB::raw('@no  := @no  + 1 AS no'),
								'level',
								'levels.created_at as created_at',
								'users.name as created_by',
								'levels.id as id',
							]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('level', 'level $1')
			->editColumn('created_at', function ($data) {
				return Content::tanggal_indo($data->created_at, true);
			})
			->addColumn('action', function ($data) {
				$update = "";
				$validate = "";
				$delete = "";
				if(Content::menuPermission('update')){
					$update = '<button type="button" data-target="#formEditAgentModal" value="'. $data->id .'" data-toggle="modal" class="btn btn-sm btn-outline btn-primary">
							<i class="fa fa-pencil" aria-hidden="true"></i> Edit
						</button>';
				}
				if(Content::menuPermission('delete')){
					$delete = '<button type="button" id="btnConfirmDelete" value="'. $data->id .'" class="btn btn-outline  btn-sm btn-danger" data-target="#confirmDeleteModal" data-toggle="modal">
							<i class="fa fa-trash" aria-hidden="true"></i> Delete
						</button>';
				}
				if(Content::menuPermission('validate')){
					$validate = '<a href="'.route('configs.'.$this->slug.'.privileges.validate', ['id_level' => $data->id]).'" class="btn btn-outline btn-sm btn-warning"> <i class="fa fa-cogs" aria-hidden="true"></i> Privileges </a>';
				}

				return '
					<div class="btn-group" aria-label="User Action">'.
						$update.$delete.$validate.
					'</div>' ;
			})
			->make(true);
	}

	function postCreate(Request $request)
	{
		$this->validate($request, [
				'level' => 'required|string|max:191',
		]);

		$added = new Level();

		$added->level = $request->input('level');
		$added->created_by = Auth::user()->id;

		$added->save();

		$menus = Menu::all();

		foreach ($menus as $key => $menu) {
			$privilege = new Privileges;
			$privilege->id_level = $added->id;
			$privilege->id_menu = $menu->id;
			$privilege->save();
		}

		Log::aktivitas('Menambah '.$this->title.': '.$added->level);

		return redirect(route('configs.'.$this->slug.'.read'))->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['level'] = Level::find($id)->toJson();

	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, [
				'level' => 'required|string|max:191',
		]);

		$added = Level::find($request->input('edit_id'));

		$added->level = $request->input('level');
		$added->updated_by = Auth::user()->id;

		$added->save();

		Log::aktivitas('Mengubah '.$this->title.': '.$added->level);
		return redirect(route('configs.'.$this->slug.'.read'))->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$level = Level::find($id);
		$level->deleted_by = Auth::user()->id;
		$level->save();

		Level::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.': '.$level->level);
		return redirect(route('configs.'.$this->slug.'.read'))->with('message_sukses', $this->title.' berhasil dihapus!');
	}

	public function getPrivileges($id_level)
	{
		$data['title'] = "Privileges";
		$data['level'] = Level::where('id', $id_level)->first();
		$data['request_route'] = route('configs.'.$this->slug.'.privileges.data.validate', ['id_level' => $id_level]);
		$data['level_route'] = route('configs.'.$this->slug.'.read');

		return view('Level::privileges', $data);
	}

	public function getDataPrivilege(Datatables $datatables, Request $request, $id_level)
	{

		DB::statement(DB::raw('set @no=0'));
		$data = Menu::leftJoin('previleges', 'menus.id', 'previleges.id_menu')
						->where('previleges.id_level', $id_level)
						->whereNull('previleges.deleted_at')
						->orderBy('menus.urutan')
						->select([
							DB::raw('@no  := @no  + 1 AS no'), 'menus.id as id', 'menus.id as id_menu', 'menus.menu as menu', 'previleges.id_level as id_level', 'previleges.read as read', 'previleges.create as create', 'previleges.update as update', 'previleges.delete as delete', 'previleges.validate as validate', 'previleges.id as id_privilege'
						]);

		$datatables = Datatables::of($data);
		if ($keyword = $request->get('search')['value']) {
			$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
		}

		return $datatables
			->addColumn('menu', function ($data) { return $data->menu; })
			->addColumn('create', function ($data) {
				if ($data->create == 1) {
					$class = "active";
					$aria = "true";
					$value = "on";
				}else{
					$class = "";
					$aria = "false";
					$value = "off";
				}
				return '<button type="button" id-menu="'.$data->id_menu.'" param="create" id="change" id-level="'.$data->id_level.'" id-privilege="'.$data->id_privilege.'" value="'.$value.'" class="btn btn-sm btn-toggle btn-success '.$class.'" data-toggle="button" aria-pressed="'.$aria.'" autocomplete="off">
							<div class="handle"></div>
						</button>';
			})
			->addColumn('read', function ($data) {
				if ($data->read == 1) {
					$class = "active";
					$aria = "true";
					$value = "on";
				}else{
					$class = "";
					$aria = "false";
					$value = "off";
				}
				return '<button type="button" id-menu="'.$data->id_menu.'" param="read" id="change" id-level="'.$data->id_level.'" id-privilege="'.$data->id_privilege.'" value="'.$value.'"  class="btn btn-sm btn-toggle btn-success '.$class.'" data-toggle="button" aria-pressed="'.$aria.'" autocomplete="off">
							<div class="handle"></div>
						</button>';
			})
			->addColumn('update', function ($data) {
				if ($data->update == 1) {
					$class = "active";
					$aria = "true";
					$value = "on";
				}else{
					$class = "";
					$aria = "false";
					$value = "off";
				}
				return '<button type="button" id-menu="'.$data->id_menu.'" param="update" id="change" id-level="'.$data->id_level.'" id-privilege="'.$data->id_privilege.'" class="btn btn-sm btn-toggle btn-success '.$class.'" data-toggle="button" value="'.$value.'" aria-pressed="'.$aria.'" autocomplete="off">
							<div class="handle"></div>
						</button>';
			})
			->addColumn('delete', function ($data) {
				if ($data->delete == 1) {
					$class = "active";
					$aria = "true";
					$value = "on";
				}else{
					$class = "";
					$aria = "false";
					$value = "off";
				}
				return '<button type="button" id-menu="'.$data->id_menu.'" param="delete" id="change" id-level="'.$data->id_level.'" id-privilege="'.$data->id_privilege.'" class="btn btn-sm btn-toggle btn-success '.$class.'" data-toggle="button" aria-pressed="'.$aria.'" value="'.$value.'" autocomplete="off">
							<div class="handle"></div>
						</button>';
			})
			->addColumn('validate', function ($data) {
				if ($data->validate == 1) {
					$class = "active";
					$aria = "true";
					$value = "on";
				}else{
					$class = "";
					$aria = "false";
					$value = "off";
				}
				return '<button type="button" id-menu="'.$data->id_menu.'"  param="validate" id="change" id-level="'.$data->id_level.'" id-privilege="'.$data->id_privilege.'" class="btn btn-sm btn-toggle btn-success '.$class.'" data-toggle="button" value="'.$value.'" aria-pressed="'.$aria.'" autocomplete="off">
							<div class="handle"></div>
						</button>';
			})
			->make(true);
	}

	public function changePrivileges($param, $id_level, $id_menu, $access)
	{
		$privilege = Privileges::where('id_level', $id_level)->where('id_menu', $id_menu)->first();

		$access = strtolower($access);

		if ($access == 'true') {
			$access = 1;
		}elseif ($access == 'false') {
			$access = 0;
		}

		if ($privilege){
			$privilege->$param = $access;
			$privilege->save();
		}else{
			$privilege = new Privileges;
			$privilege->id_level = $id_level;
			$privilege->id_menu = $id_menu;
			$privilege->$param = $access;
			$privilege->save();
		}

		return "true";
	}

}
