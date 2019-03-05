<?php
namespace App\Modules\PesertaKuliah\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\PesertaKuliah\Models\PesertaKuliah;
use App\Modules\MataKuliah\Models\MataKuliah;
use App\Modules\Mahasiswa\Models\Mahasiswa;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class PesertaKuliahController extends Controller
{
	protected $slug = 'pesertakuliah';
	protected $module = 'PesertaKuliah';
	protected $title = "PesertaKuliah";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$this->column_title = array('Mahasiswa', 'NIM', 'Email');
		$this->ajax_field = array(['id_user_mahasiswa', 'nim', 'email'], [0]);

		$this->validation = array(
			'id_user_mahasiswa' => 'required|string|exists:users,id',
		);
	}

	public function index($id_mata_kuliah)
	{
		$data['makul'] = MataKuliah::find($id_mata_kuliah);
		$mahasiswa = Mahasiswa::leftJoin('users', 'mahasiswa.id_user', 'users.id')
								->leftJoin('peserta_kuliah', function($join) use ($id_mata_kuliah){
				                    $join->on('users.id', 'peserta_kuliah.id_user_mahasiswa')
				                    	->where('peserta_kuliah.id_mata_kuliah', $id_mata_kuliah)
				                    	->whereNull('peserta_kuliah.deleted_at');
				                })
				                ->whereNull('peserta_kuliah.id_user_mahasiswa')
								->where('mahasiswa.id_jurusan', $data['makul']->id_jurusan)
								->whereNull('users.deleted_at')
								->pluck('users.name', 'users.id')->toArray();
		$this->create_form = array(
			'Mahasiswa' =>	Form::select('id_user_mahasiswa', $mahasiswa, old('id_user_mahasiswa'), ['class' => 'form-control', 'placeholder' => '--- Pilih Mahasiswa ---', ] ),
		);
		$this->update_form = array(
			'Mahasiswa' =>	Form::select('id_user_mahasiswa', $mahasiswa, old('id_user_mahasiswa'), ['class' => 'form-control', 'placeholder' => '--- Pilih Mahasiswa ---', 'id' => 'id_user_mahasiswa'] ),
		);

		$data['title'] = $this->title;
		$data['create_route'] = route('matakuliah.'.$this->slug.'.post.create', [ 'id_mata_kuliah' => $id_mata_kuliah]);
		$data['update_route'] = route('matakuliah.'.$this->slug.'.post.update', ['id_mata_kuliah' => $id_mata_kuliah, 'id'=>null]);
		$data['delete_route'] = route('matakuliah.'.$this->slug.'.delete', ['id_mata_kuliah' => $id_mata_kuliah, 'id'=>null]);
		$data['detail_route'] = route('matakuliah.'.$this->slug.'.details.read', ['id_mata_kuliah' => $id_mata_kuliah, 'id'=>null]);
		$data['read_route'] = route('matakuliah.'.$this->slug.'.get-data.read', ['id_mata_kuliah' => $id_mata_kuliah]);
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

		return view('PesertaKuliah::pesertakuliah', $data);
	}

	public function getData($id_mata_kuliah, Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data =  PesertaKuliah::leftJoin('mata_kuliah', 'peserta_kuliah.id_mata_kuliah', 'mata_kuliah.id')
						->leftJoin('mahasiswa', 'peserta_kuliah.id_user_mahasiswa', 'mahasiswa.id_user')
						->leftJoin('users', 'mahasiswa.id_user', 'users.id')
						->where('peserta_kuliah.id_mata_kuliah', $id_mata_kuliah)
						->whereNull('users.deleted_at')
						->whereNull('mahasiswa.deleted_at')
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'peserta_kuliah.id',
							'mata_kuliah.nama_makul as id_mata_kuliah',
							'users.name as id_user_mahasiswa',
							'mahasiswa.nim',
							'mahasiswa.email',
							//DB::raw('CONCAT(users.name," (",mahasiswa.nim,")")'),
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('pesertakuliah', 'pesertakuliah $1')
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

	function postCreate($id_mata_kuliah, Request $request)
	{
		$this->validate($request, $this->validation);

		$pesertakuliah = new PesertaKuliah();

		$pesertakuliah->id_mata_kuliah = $id_mata_kuliah;
		$pesertakuliah->id_user_mahasiswa = $request->input('id_user_mahasiswa');
		$pesertakuliah->created_by = Auth::user()->id;

		$pesertakuliah->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id_mata_kuliah, $id)
	{
		return $data['pesertakuliah'] = PesertaKuliah::find($id)->toJson();

	}

	public function postUpdate($id_mata_kuliah, Request $request)
	{
		$this->validate($request, $this->validation);

		$pesertakuliah = PesertaKuliah::find($request->input('edit_id'));

		$pesertakuliah->id_mata_kuliah = $id_mata_kuliah;
		$pesertakuliah->id_user_mahasiswa = $request->input('id_user_mahasiswa');
		$pesertakuliah->updated_by = Auth::user()->id;

		$pesertakuliah->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id_mata_kuliah, $id)
	{
		$pesertakuliah = PesertaKuliah::find($id);
		$pesertakuliah->deleted_by = Auth::user()->id;
		$pesertakuliah->save();

		PesertaKuliah::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

}
