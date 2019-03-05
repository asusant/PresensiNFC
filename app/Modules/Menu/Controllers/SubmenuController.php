<?php
namespace App\Modules\Menu\Controllers;

use Illuminate\Http\Request;
use App\Modules\Menu\Models\Privileges;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\Models\Submenu;
use App\Models\Content;
use App\Models\Level;
use App\Models\Menu;
use App\Models\Log;
use DB;

class SubmenuController extends Controller
{
	protected $slug = 'menu';
	protected $module = 'Submenu';
	protected $title = "Submenu";

	public function index($id_menu)
	{
		$data['menu'] = Menu::all();
		$data['title'] = $this->title;
		$data['this_menu'] = $data['menu'][0]->menu;
		$data['create_route'] = route('configs.'.$this->slug.'.submenus.post.create', ['id_menu' => $id_menu]);
		$data['update_route'] = route('configs.'.$this->slug.'.submenus.post.update', ['id'=>null]);
		$data['delete_route'] = route('configs.'.$this->slug.'.submenus.delete', ['id'=>null]);
		$data['detail_route'] = route('configs.'.$this->slug.'.submenus.details.read', ['id'=>null]);
		$data['read_route'] = route('configs.'.$this->slug.'.submenus.get-data.read', ['id_menu' => $id_menu] );

		$data['create_button'] = "";
		if(Content::menuPermission('create')){
			$data['create_button'] = '<button class="btn btn-sm btn-default" data-target="#add" data-toggle="modal">
											<i class="fa fa-plus" aria-hidden="true"></i>
											<span class="hidden-xs">Tambah '.$this->title.'</span>
										</button>';
		}

		return view('Menu::submenu', $data);
	}

	public function getData($id_menu, Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data = Submenu::leftJoin('users', 'submenus.created_by', 'users.id')
						->leftJoin('menus', 'menus.id', 'submenus.id_menu')
						->where('menus.id', $id_menu)
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'menus.id as id_menu',
							'submenus.id as id',
							'submenus.submenu',
							'submenus.urutan',
							'submenus.routing',
							'submenus.created_at as created_at',
							'users.name as created_by',
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('submenu', 'submenu $1')
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
					<div class="btn-group" aria-label="User Action">'
						.$update.$delete.
					'</div>' ;
			})
			->make(true);
	}

	function postCreate($id_menu, Request $request)
	{
		$this->validate($request, [
			'submenu' => 'required|string|max:191',
			'routing' => 'required|string|max:191',
			'urutan' => 'required|numeric',
		]);

		$submenu = new Submenu();

		$submenu->id_menu = $id_menu;
		$submenu->submenu = $request->input('submenu');
		$submenu->routing = strtolower($request->input('routing'));
		$submenu->urutan = $request->input('urutan');
		$submenu->created_by = Auth::user()->id;

		$submenu->save();

		Log::aktivitas('Menambah '.$this->title.' '.$submenu->submenu.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['submenus'] = Submenu::find($id)->toJson();
	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, [
			'submenu' => 'required|string|max:191',
			'routing' => 'required|string|max:191',
			'urutan' => 'required|numeric',
		]);

		$submenu = Submenu::find($request->input('edit_id'));

		$submenu->submenu = $request->input('submenu');
		$submenu->routing = strtolower($request->input('routing'));
		$submenu->urutan = $request->input('urutan');
		$submenu->updated_by = Auth::user()->id;

		$submenu->save();

		Log::aktivitas('Menambah '.$this->title.' '.$submenu->submenu.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$submenu = Subenu::find($id);
		$submenu->deleted_by = Auth::user()->id;
		$submenu->save();

		Submenu::destroy($id);

		Log::aktivitas('Menghapus '.$this->title.' '.$subumenu->submenu.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}
}
