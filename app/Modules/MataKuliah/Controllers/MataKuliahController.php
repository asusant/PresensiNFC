<?php
namespace App\Modules\MataKuliah\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\MataKuliah\Models\MataKuliah;
use App\Modules\Hari\Models\Hari;
use App\Modules\Jurusan\Models\Jurusan;
use App\Modules\Dosen\Models\Dosen;
use App\Modules\RuangKuliah\Models\RuangKuliah;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class MataKuliahController extends Controller
{
	protected $slug = 'matakuliah';
	protected $module = 'MataKuliah';
	protected $title = "MataKuliah";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$this->column_title = array('Kode Mata Kuliah', 'Nama Mata Kuliah', 'Jurusan', 'Dosen 1', 'Dosen 2', 'Jadwal');
		$this->ajax_field = array(['kode_makul', 'nama_makul', 'id_jurusan', 'id_user_dosen_1', 'id_user_dosen_2', 'jadwal'], [0,1,2,3,4]);

		$this->validation = array(
			'id_jurusan' => 'required|exists:jurusan,id',
			'kode_makul' => 'required|string|max:20',
			'nama_makul' => 'required|string|max:191',
			'id_user_dosen_1' => 'required|exists:users,id',
			'id_user_dosen_2' => 'nullable|exists:users,id',
			'id_ruang_kuliah' => 'required|exists:ruang_kuliah,id',
			'id_hari' 			=> 'required|exists:hari,id',
			'waktu_mulai'	=> 'required',
			'waktu_selesai'	=> 'required',
		);
	}

	public function index()
	{
		$jurusan = Jurusan::pluck('jurusan', 'id')->toArray();
		$dosen = Dosen::leftJoin('users', 'dosen.id_user', 'users.id')->pluck("users.name", 'users.id')->toArray();
		$hari = Hari::pluck('hari', 'id')->toArray();
		$ruangKuliah = RuangKuliah::pluck('ruang', 'id')->toArray();

		$this->create_form = array(
			'Kode Mata Kuliah' =>	Form::text('kode_makul', old('kode_makul'), ['class' => 'form-control', 'placeholder' => 'Contoh: MKD10233', ] ),
			'Nama Mata Kuliah' =>	Form::text('nama_makul', old('nama_makul'), ['class' => 'form-control', 'placeholder' => 'Contoh: Algoritma dan Pemrograman', ] ),
			'Jurusan'	=> Form::select('id_jurusan', $jurusan, old('jurusan'), ['class' => 'form-control', 'placeholder' => '---Pilih Jurusan---', ]),
			'Dosen 1'	=> Form::select('id_user_dosen_1', $dosen, old('id_user_dosen_1'), ['class' => 'form-control', 'placeholder' => '---Pilih Dosen 1---', ]),
			'Dosen 2'	=> Form::select('id_user_dosen_2', $dosen, old('id_user_dosen_2'), ['class' => 'form-control', 'placeholder' => '---Pilih Dosen 2---', ]),
			'Ruang Kuliah'	=> Form::select('id_ruang_kuliah', $ruangKuliah, null, ['class' => 'form-control', 'placeholder' => '---Pilih Ruang Kuliah---', ]),
			'Hari'	=> Form::select('id_hari', $hari, null, ['class' => 'form-control', 'placeholder' => '---Pilih Hari---', ]),
			'Waktu Mulai' => Form::time('waktu_mulai', old('waktu_mulai'), ['class' => 'form-control', 'placeholder' => 'Contoh: 10:00 AM', 'id' => 'add_mulai'] ),
			'Waktu Selesai' => Form::time('waktu_selesai', old('waktu_selesai'), ['class' => 'form-control timepicker', 'placeholder' => 'Contoh: 12:00 PM', 'id' => 'add_selesai'] ),
		);
		$this->update_form = array(
			'Kode Mata Kuliah' =>	Form::text('kode_makul', old('kode_makul'), ['class' => 'form-control', 'placeholder' => 'Contoh: MKD10233', 'id' => 'kode_makul'] ),
			'Nama Mata Kuliah' =>	Form::text('nama_makul', old('nama_makul'), ['class' => 'form-control', 'placeholder' => 'Contoh: Algoritma dan Pemrograman', 'id' => 'nama_makul'] ),
			'Jurusan'	=> Form::select('id_jurusan', $jurusan, old('jurusan'), ['class' => 'form-control', 'placeholder' => '---Pilih Jurusan---', 'id' => 'id_jurusan']),
			'Dosen 1'	=> Form::select('id_user_dosen_1', $dosen, old('id_user_dosen_1'), ['class' => 'form-control', 'placeholder' => '---Pilih Dosen 1---', 'id' => 'id_user_dosen_1']),
			'Dosen 2'	=> Form::select('id_user_dosen_2', $dosen, old('id_user_dosen_2'), ['class' => 'form-control', 'placeholder' => '---Pilih Dosen 2---', 'id' => 'id_user_dosen_2']),
			'Ruang Kuliah'	=> Form::select('id_ruang_kuliah', $ruangKuliah, null, ['class' => 'form-control', 'placeholder' => '---Pilih Ruang Kuliah---', 'id' => 'id_ruang_kuliah']),
			'Hari'	=> Form::select('id_hari', $hari, null, ['class' => 'form-control', 'placeholder' => '---Pilih Hari---', 'id' => 'id_hari']),
			'Waktu Mulai' => Form::time('waktu_mulai', old('waktu_mulai'), ['class' => 'form-control timepicker', 'placeholder' => 'Contoh: 10:00 PM', 'id' => 'waktu_mulai'] ),
			'Waktu Selesai' => Form::time('waktu_selesai', old('waktu_selesai'), ['class' => 'form-control timepicker', 'placeholder' => 'Contoh: 10:00 PM', 'id' => 'waktu_selesai'] ),
		);

		$data['title'] = $this->title;
		$data['create_route'] = route($this->slug.'.post.create');
		$data['update_route'] = route($this->slug.'.post.update', ['id'=>null]);
		$data['delete_route'] = route($this->slug.'.delete', ['id'=>null]);
		$data['detail_route'] = route($this->slug.'.details.read', ['id'=>null]);
		$data['read_route'] = route($this->slug.'.get-data.read');
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

		return view('MataKuliah::matakuliah', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		$dosen = null;
		if (session('id_level') == 4) {
			$dosen = Auth::user()->id;
		}
		DB::statement(DB::raw('set @no=0'));

		$data =  MataKuliah::leftJoin('jurusan', 'mata_kuliah.id_jurusan', 'jurusan.id')
						->leftJoin('dosen as dosen_1', 'mata_kuliah.id_user_dosen_1', 'dosen_1.id_user')
						->leftJoin('users as users_1', 'mata_kuliah.id_user_dosen_1', 'users_1.id')
						->leftJoin('dosen as dosen_2', 'mata_kuliah.id_user_dosen_2', 'dosen_2.id_user')
						->leftJoin('users as users_2', 'mata_kuliah.id_user_dosen_2', 'users_2.id')
						->leftJoin('hari', 'mata_kuliah.id_hari', 'hari.id')
						->leftJoin('ruang_kuliah', 'mata_kuliah.id_ruang_kuliah', 'ruang_kuliah.id')
						->when($dosen, function ($q) use($dosen){
							return $q->where('mata_kuliah.id_user_dosen_1', $dosen)
										->orWhere('mata_kuliah.id_user_dosen_2', $dosen);
						})
						->where('id_semester', session('id_semester'))
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'mata_kuliah.id',
							'mata_kuliah.nama_makul',
							'mata_kuliah.kode_makul',
							'jurusan.jurusan as id_jurusan',
							DB::raw('CONCAT(users_1.name," (",dosen_1.nip,")") as id_user_dosen_1'),
							DB::raw('CONCAT(users_2.name," (",dosen_2.nip,")") as id_user_dosen_2'),
							DB::raw('CONCAT(hari.hari," (",waktu_mulai," - ",waktu_selesai,") | ",ruang_kuliah.ruang) as jadwal'),
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('matakuliah', 'matakuliah $1')
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
				if(Content::menuPermission('validate')){
					$validate = '<a href="'.route($this->slug.'.pesertakuliah.read', ['id_mata_kuliah' => $data->id]).'" class="btn btn-outline btn-sm btn-success"> <i class="fa fa-users" aria-hidden="true"></i> Peserta </a>';
					$validate .= '<a value="'. $data->id .'" class="btn btn-sm btn-outline btn-info" href="'.route('matakuliah.presensikuliah.read', ['id'=>$data->id]).'">
							<i class="fa fa-paste" aria-hidden="true"></i> Presensi
						</a>';
				}

				return $update.$delete.$validate;
			})
			->make(true);
	}

	function postCreate(Request $request)
	{
		$this->validate($request, $this->validation);

		$matakuliah = new MataKuliah();

		$matakuliah->kode_makul = $request->input('kode_makul');
		$matakuliah->nama_makul = $request->input('nama_makul');
		$matakuliah->id_jurusan = $request->input('id_jurusan');
		$matakuliah->id_user_dosen_1 = $request->input('id_user_dosen_1');
		if (null !== $request->input('id_user_dosen_2')) {
			$matakuliah->id_user_dosen_2 = $request->input('id_user_dosen_2');
		}
		$matakuliah->id_ruang_kuliah = $request->input('id_ruang_kuliah');
		$matakuliah->id_hari = $request->input('id_hari');
		$matakuliah->waktu_mulai = date("H:i:s", strtotime($request->input('waktu_mulai')));
		$matakuliah->waktu_selesai = date("H:i:s", strtotime($request->input('waktu_selesai')));

		$matakuliah->id_semester = session('id_semester');
		$matakuliah->created_by = Auth::user()->id;

		$matakuliah->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['matakuliah'] = MataKuliah::find($id)->toJson();

	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, $this->validation);

		$matakuliah = MataKuliah::find($request->input('edit_id'));

		$matakuliah->kode_makul = $request->input('kode_makul');
		$matakuliah->nama_makul = $request->input('nama_makul');
		$matakuliah->id_jurusan = $request->input('id_jurusan');
		$matakuliah->id_user_dosen_1 = $request->input('id_user_dosen_1');
		if (null !== $request->input('id_user_dosen_2')) {
			$matakuliah->id_user_dosen_2 = $request->input('id_user_dosen_2');
		}
		$matakuliah->id_ruang_kuliah = $request->input('id_ruang_kuliah');
		$matakuliah->id_hari = $request->input('id_hari');
		$matakuliah->waktu_mulai = date("H:i:s", strtotime($request->input('waktu_mulai')));
		$matakuliah->waktu_selesai = date("H:i:s", strtotime($request->input('waktu_selesai')));
		$matakuliah->updated_by = Auth::user()->id;

		$matakuliah->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$matakuliah = MataKuliah::find($id);
		$matakuliah->deleted_by = Auth::user()->id;
		$matakuliah->save();

		MataKuliah::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

}
