<?php
namespace App\Modules\Menu\Controllers;

use Illuminate\Http\Request;
use App\Modules\Menu\Models\Privileges;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Level;
use App\Models\Menu;
use App\Models\Log;
use DB;

class MenuController extends Controller
{
	protected $slug = 'menu';
	protected $module = 'Menu';
	protected $title = "Menu";

	public function index()
	{
		$data['menu'] = Menu::all();
		$data['title'] = $this->title;
		$data['create_route'] = route('configs.'.$this->slug.'.post.create');
		$data['update_route'] = route('configs.'.$this->slug.'.post.update', ['id'=>null]);
		$data['delete_route'] = route('configs.'.$this->slug.'.delete', ['id'=>null]);
		$data['detail_route'] = route('configs.'.$this->slug.'.details.read', ['id'=>null]);
		$data['read_route'] = route('configs.'.$this->slug.'.get-data.read');

		$data['create_button'] = "";
		if(Content::menuPermission('create')){
			$data['create_button'] = '<button class="btn btn-sm btn-default" data-target="#add" data-toggle="modal">
											<i class="fa fa-plus" aria-hidden="true"></i>
											<span class="hidden-xs">Tambah '.$this->title.'</span>
										</button>';
		}

		return view('Menu::menu', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data = Menu::leftJoin('users', 'menus.created_by', 'users.id')
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'menu',
							'route',
							'icon',
							'urutan',
							'menus.created_at as created_at',
							'users.name as created_by',
							'menus.id as id',
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('menu', 'menu $1')
			->editColumn('created_at', function ($data) {
				return Content::tanggal_indo($data->created_at, true);
			})
			->addColumn('action', function ($data) {
				$update = "";
				$delete = "";
				if(Content::menuPermission('update')){
					$update = '<button type="button" data-target="#formEditModal" value="'. $data->id .'" data-toggle="modal" class="btn btn-sm btn-outline btn-primary">
							<i class="fa fa-pencil" aria-hidden="true"></i> Edit
						</button>';
				}
				if(Content::menuPermission('delete')){
					$delete = '<button type="button" id="btnConfirmDelete" value="'. $data->id .'" class="btn btn-outline  btn-sm btn-danger" data-target="#confirmDeleteModal" data-toggle="modal">
							<i class="fa fa-trash" aria-hidden="true"></i> Delete
						</button>';
				}

				return '
					<div class="btn-group" aria-label="User Action">
						<a href="'.route('configs.'.$this->slug.'.submenus.read', ['id_menu'=>$data->id]).'" class="btn btn-outline  btn-sm btn-warning"><i class="fa fa-user-md" aria-hidden="true"></i> Submenus</a>
					'.
						$update.$delete.
					'</div>' ;
			})
			->make(true);
	}

	function postCreate(Request $request)
	{
		$this->validate($request, [
			'menu' => 'required|string|max:191',
			'route' => 'required|string|max:191|unique:menus,menu',
			'icon' => 'required|string|max:191',
			'urutan' => 'required|numeric',
		]);

		$menu = new Menu();

		$menu->menu = $request->input('menu');
		$menu->route = strtolower($request->input('route'));
		$menu->routing = $menu->route.'.read';
		$menu->icon = $request->input('icon');
		$menu->urutan = $request->input('urutan');
		$menu->created_by = Auth::user()->id;

		$menu->save();

		$levels = Level::all();

		foreach ($levels as $key => $level) {
			$privilege = new Privileges();
			$privilege->id_level = $level->id;
			$privilege->id_menu = $menu->id;
			$privilege->save();
		}

		Log::aktivitas('Menambah '.$this->title.' '.$menu->menu.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['menu'] = Menu::find($id)->toJson();
	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, [
			'menu' => 'required|string|max:191',
			'icon' => 'required|string|max:191',
			'urutan' => 'required|numeric',
		]);

		$menu = Menu::find($request->input('edit_id'));

		$menu->menu = $request->input('menu');
		$menu->route = strtolower($request->input('route'));
		$menu->routing = $menu->route.'.read';
		$menu->icon = $request->input('icon');
		$menu->urutan = $request->input('urutan');
		$menu->updated_by = Auth::user()->id;

		$menu->save();

		Log::aktivitas('Menambah '.$this->title.' '.$menu->menu.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$menu = Menu::find($id);
		$menu->deleted_by = Auth::user()->id;
		$menu->save();

		Menu::destroy($id);
		Privileges::where('id_menu', $menu->id)->delete();

		Log::aktivitas('Menghapus '.$this->title.' '.$menu->menu.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}
}
