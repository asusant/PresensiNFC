<?php
namespace App\Modules\RuangKuliah\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\RuangKuliah\Models\RuangKuliah;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class RuangKuliahController extends Controller
{
	protected $slug = 'ruangkuliah';
	protected $module = 'RuangKuliah';
	protected $title = "RuangKuliah";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$this->column_title = array('Nama Ruang', 'Dibuat Pada', 'Dibuat Oleh');
		$this->ajax_field = array(['ruang', 'created_at', 'created_by'], [0]);
		$this->validation = array(
			'ruang' => 'required|string|max:191',
		);
		$this->create_form = array(
			'ruang' =>	Form::text('ruang', old('ruang'), ['class' => 'form-control', 'placeholder' => 'Contoh: D1-314', ] ),
		);
		$this->update_form = array(
			'ruang' =>	Form::text('ruang', old('ruang'), ['class' => 'form-control', 'placeholder' => 'Contoh: D1-314', 'id' => 'ruang'] ),
		);
	}

	public function index()
	{
		$data['ruangkuliah'] = RuangKuliah::all();
		$data['title'] = $this->title;
		$data['create_route'] = route('configs.'.$this->slug.'.post.create');
		$data['update_route'] = route('configs.'.$this->slug.'.post.update', ['id'=>null]);
		$data['delete_route'] = route('configs.'.$this->slug.'.delete', ['id'=>null]);
		$data['detail_route'] = route('configs.'.$this->slug.'.details.read', ['id'=>null]);
		$data['read_route'] = route('configs.'.$this->slug.'.get-data.read');
		$data['column_title'] = $this->column_title;
		$data['ajax_field'] = $this->ajax_field;
		$data['create_form'] = $this->create_form;
		$data['update_form'] = $this->update_form;

		$data['create_button'] = "";
		if(Content::menuPermission('create')){
			$data['create_button'] = '<button class="btn btn-sm btn-default" data-target="#add" data-toggle="modal">
											<i class="fa fa-plus" aria-hidden="true"></i>
											<span class="hidden-xs">Tambah '.$this->title.'</span>
										</button>';
		}

		return view('RuangKuliah::ruangkuliah', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data =  RuangKuliah::leftJoin('users', 'ruang_kuliah.created_by', 'users.id')
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'ruang_kuliah.id',
							'ruang_kuliah.ruang',
							'ruang_kuliah.created_at',
							'users.name as created_by',
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('ruangkuliah', 'ruangkuliah $1')
			->editColumn('created_at', function ($data) {
				return Content::tanggal_indo($data->created_at, true);
			})
			->addColumn('action', function ($data) {
				$update = "";
				$validate = "";
				$delete = "";
				if(Content::menuPermission('update')){
					$update = '<button type="button" data-target="#formEditModal" value="'. $data->id .'" data-toggle="modal" class="btn btn-sm btn-outline btn-primary">
							<i class="fa fa-pencil" aria-hidden="true"></i> Edit
						</button>';
				}
				if(Content::menuPermission('delete')){
					$delete = '<button type="button" id="confirmDelete" value="'. $data->id .'" class="btn btn-outline  btn-sm btn-danger" data-target="#confirmDeleteModal" data-toggle="modal">
							<i class="fa fa-trash" aria-hidden="true"></i> Delete
						</button>';
				}

				return '
					<div class="btn-group" aria-label="User Action">'.
						$update.$delete.$validate
						.
					'</div>' ;
			})
			->make(true);
	}

	function postCreate(Request $request)
	{
		$this->validate($request, $this->validation);

		$ruangkuliah = new RuangKuliah();

		$ruangkuliah->ruang = $request->input('ruang');
		$ruangkuliah->created_by = Auth::user()->id;

		$ruangkuliah->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['ruangkuliah'] = RuangKuliah::find($id)->toJson();

	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, $this->validation);

		$ruangkuliah = RuangKuliah::find($request->input('edit_id'));

		$ruangkuliah->ruang = $request->input('ruang');
		$ruangkuliah->updated_by = Auth::user()->id;

		$ruangkuliah->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$ruangkuliah = RuangKuliah::find($id);
		$ruangkuliah->deleted_by = Auth::user()->id;
		$ruangkuliah->save();

		RuangKuliah::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

}
