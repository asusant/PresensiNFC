<?php
namespace App\Modules\Master\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\Models\Level;
use App\Models\Content;
use DB;
use App\Models\Log;


class MasterController extends Controller {

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
								return '<div class="btn-group" aria-label="User Action">
									<button type="button" data-target="#formEditAgentModal" value="'. $data->id .'" data-toggle="modal" class="btn btn-sm btn-outline btn-primary">
										<i class="fa fa-pencil" aria-hidden="true"></i> Edit
									</button>
									<button type="button" id="btnConfirmDelete" value="'. $data->id .'" class="btn btn-outline  btn-sm btn-primary" data-target="#confirmDeleteModal" data-toggle="modal">
										<i class="fa fa-trash" aria-hidden="true"></i> Delete
									</button>
								</div>' ;
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

		$added = new Level();

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














}
