<?php
namespace App\Modules\PresensiKuliah\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\PresensiKuliah\Models\PertemuanKuliah;
use App\Modules\PresensiKuliah\Models\PresensiKuliah;
use App\Modules\TipeKehadiran\Models\TipeKehadiran;
use App\Modules\PesertaKuliah\Models\PesertaKuliah;
use App\Modules\MataKuliah\Models\MataKuliah;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class PresensiKuliahController extends Controller
{
	protected $slug = 'presensikuliah';
	protected $module = 'PresensiKuliah';
	protected $title = "Presensi Kuliah";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{

		$this->column_title = array('Waktu Pertemuan', 'Total Mahasiswa', 'Jumlah Hadir', 'Dipresesnsi Oleh');
		$this->ajax_field = array(['waktu_pertemuan', 'n_total', 'n_hadir', 'created_by'], [0,1,2,3]);

		$this->validation = array(
			'presensikuliah' => 'required|string|max:191',
		);
		$this->create_form = array(
			'presensikuliah' =>	Form::text('presensikuliah', old('presensikuliah'), ['class' => 'form-control', 'placeholder' => 'Contoh: w', ] ),
		);
		$this->update_form = array(
			'presensikuliah' =>	Form::text('presensikuliah', old('presensikuliah'), ['class' => 'form-control', 'placeholder' => 'Contoh: w', 'id' => 'key'] ),
		);
	}

	public function index($id)
	{
		if (session('id_level') != 1) {
			if (!$this->checkAuthorization($id)) {
				return redirect()->back()->with('message_danger', 'Anda tidak terdaftar pada Praktikum ini!');
			}
		}

		$data['title'] = $this->title;
		$data['create_route'] = route('matakuliah.'.$this->slug.'.post.validate', ['id'=>$id]);
		$data['update_route'] = route('matakuliah.'.$this->slug.'.post.update', ['id'=>null]);
		$data['delete_route'] = route('matakuliah.'.$this->slug.'.delete', ['id'=>null]);
		$data['detail_route'] = route('matakuliah.'.$this->slug.'.details.read', ['id'=>null]);
		$data['read_route'] = route('matakuliah.'.$this->slug.'.get-data.read', ['id'=>$id]);
		$data['presensi_route'] = route('matakuliah.'.$this->slug.'.details.read', ['id'=>null]);
		$data['column_title'] = $this->column_title;
		$data['ajax_field'] = $this->ajax_field;
		$data['create_form'] = $this->create_form;
		$data['update_form'] = $this->update_form;
		$data['mata_kuliah'] = MataKuliah::leftJoin('hari', 'mata_kuliah.id_hari', 'hari.id')->where('mata_kuliah.id', $id)->where('mata_kuliah.id_semester', session('id_semester'))->first();

		$data['create_button'] = "";
		if(Content::menuPermission('validate')){
			$data['create_button'] = '<a class="btn btn-sm btn-default" href="'.route('matakuliah.'.$this->slug.'.post.validate', ['id'=>$id]).'">
											<i class="fa fa-plus" aria-hidden="true"></i>
											<span class="hidden-xs">Tambah '.$this->title.'</span>
										</a>';
		}

		return view('PresensiKuliah::presensikuliah', $data);

	}

	public function getData(Datatables $datatables, Request $request, $id)
	{
		if (session('id_level') != 1) {
			if (!$this->checkAuthorization($id)) {
				return redirect()->back()->with('message_danger', 'Anda tidak terdaftar pada Praktikum ini!');
			}
		}

		DB::statement(DB::raw('set @no=0'));

		$data =  PertemuanKuliah::leftJoin('mata_kuliah', 'pertemuan_kuliah.id_mata_kuliah', 'mata_kuliah.id')
						->leftJoin('users', 'pertemuan_kuliah.created_by', 'users.id')
						->where('pertemuan_kuliah.id_mata_kuliah', $id)
						->where('mata_kuliah.id_semester', session('id_semester'))
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'pertemuan_kuliah.*',
							'mata_kuliah.id as id_mata_kuliah',
							'users.name as created_by',
							'users.name as created_at',
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('presensikuliah', 'presensikuliah $1')
			->editColumn('created_at', function ($data) {
				return Content::tanggal_indo($data->created_at, true);
			})
			->addColumn('n_total', function($data){
				return PesertaKuliah::where('id_mata_kuliah', $data->id_mata_kuliah)->count();
			})
			->editColumn('waktu_pertemuan', function($data){
				return Content::tanggal_indo($data->waktu_pertemuan);
			})
			->addColumn('n_hadir', function($data){
				return PresensiKuliah::where('id_pertemuan_kuliah', $data->id)
										->where('id_tipe_kehadiran', 1)
										->count();
			})
			->addColumn('action', function ($data) {
				$read = "";
				$update = "";
				$validate = "";
				$delete = "";
				if(Content::menuPermission('read')){
					$read = '<button type="button" data-target="#formEditModal" value="'. $data->id .'" data-toggle="modal" class="btn btn-sm btn-outline btn-success">
							<i class="fa fa-search" aria-hidden="true"></i> Lihat Detail Presensi
						</button>';
				}

				return '
					<div class="btn-group" aria-label="User Action">'.
						$read.$update.$delete.$validate
						.
					'</div>' ;
			})
			->make(true);
	}

	function postCreate(Request $request, $id)
	{
		if (!$this->checkAuthorization($id)) {
			return redirect()->back()->with('message_danger', 'Anda tidak terdaftar pada Praktikum ini!');
		}

		$data['title'] = $this->title;
		$data['mata_kuliah'] = MataKuliah::leftJoin('dosen as dosen_1', 'mata_kuliah.id_user_dosen_1', 'dosen_1.id_user')
										->leftJoin('users as user_1', 'dosen_1.id_user', 'user_1.id')
										->leftJoin('dosen as dosen_2', 'mata_kuliah.id_user_dosen_2', 'dosen_2.id_user')
										->leftJoin('users as user_2', 'dosen_2.id_user', 'user_2.id')
										->leftJoin('ruang_kuliah', 'mata_kuliah.id_ruang_kuliah', 'ruang_kuliah.id')
										->leftJoin('hari', 'mata_kuliah.id_hari', 'hari.id')
										->where('mata_kuliah.id', $id)
										->where('mata_kuliah.id_semester', session('id_semester'))
										->first([
											'mata_kuliah.*',
										]);

		$data['presensi_route'] = route('matakuliah.'.$this->slug.'.read', ['id'=>$id]);
		$data['create_route'] = route('matakuliah.'.$this->slug.'.post.presensi.validate', ['id'=>$id]);
		$data['pesertas'] = PesertaKuliah::leftJoin('users', 'peserta_kuliah.id_user_mahasiswa', 'users.id')
											->leftJoin('mahasiswa', 'peserta_kuliah.id_user_mahasiswa', 'mahasiswa.id_user')
											->where('id_mata_kuliah', $id)
											->get([
												'users.id',
												'users.name',
												'mahasiswa.nim',
											]);

		$data['tipe_kehadirans'] = TipeKehadiran::all();

		return view('PresensiKuliah::input_presensi', $data);
	}

	public function details($id)
	{
		$data['pertemuan'] = PertemuanKuliah::leftJoin('mata_kuliah', 'pertemuan_kuliah.id_mata_kuliah', 'mata_kuliah.id')
										->leftJoin('users as user_1', 'mata_kuliah.id_user_dosen_1', 'user_1.id')
										->leftJoin('dosen as dosen_1', 'user_1.id', 'dosen_1.id_user')
										->leftJoin('users as user_2', 'mata_kuliah.id_user_dosen_2', 'user_2.id')
										->leftJoin('dosen as dosen_2', 'user_2.id', 'dosen_2.id_user')
										->leftJoin('hari', 'mata_kuliah.id_hari', 'hari.id')
										->where('pertemuan_kuliah.id', $id)
										->where('mata_kuliah.id_semester', session('id_semester'))
										->get([
											'mata_kuliah.nama_makul',
											'user_1.name as name_1',
											'dosen_1.nip as nip_1',
											'user_2.name as name_2',
											'dosen_2.nip as nip_2',
											'pertemuan_kuliah.waktu_pertemuan',
										])->first();
		$data['presensi'] = PresensiKuliah::leftJoin('pertemuan_kuliah', 'presensi_kuliah.id_pertemuan_kuliah', 'pertemuan_kuliah.id')
											->leftJoin('mata_kuliah', 'pertemuan_kuliah.id_mata_kuliah', 'mata_kuliah.id')
											->leftJoin('users', 'presensi_kuliah.id_user_mahasiswa', 'users.id')
											->leftJoin('mahasiswa', 'mahasiswa.id_user', 'users.id')
											->leftJoin('tipe_kehadiran', 'presensi_kuliah.id_tipe_kehadiran', 'tipe_kehadiran.id')
											->leftJoin('hari', 'mata_kuliah.id_hari', 'hari.id')
											->where('mata_kuliah.id_semester', session('id_semester'))
											->where('presensi_kuliah.id_pertemuan_kuliah', $id)
											->orderBy('mahasiswa.nim')
											->get();
		return json_encode($data);
	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, $this->validation);

		$presensikuliah = PresensiKuliah::find($request->input('edit_id'));

		$presensikuliah->presensikuliah = $request->input('presensikuliah');
		$presensikuliah->updated_by = Auth::user()->id;

		$presensikuliah->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$presensikuliah = PresensiKuliah::find($id);
		$presensikuliah->deleted_by = Auth::user()->id;
		$presensikuliah->save();

		PresensiKuliah::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}


	public function postCreatePresensi(Request $request, $id)
	{
		if (!$this->checkAuthorization($id)) {
			return redirect()->back()->with('message_danger', 'Anda tidak terdaftar pada Praktikum ini!');
		}

		$tipeKehadiran = TipeKehadiran::all();
		$pesertas = PesertaKuliah::where('id_mata_kuliah', $request->input('mata_kuliah'))->get();

		$tipe_kehadiran = array();

    	foreach ($tipeKehadiran as $key => $tipeKe) {
			$tipe_kehadiran[$tipeKe->id] = array();
    		$tipe_kehadiran[$tipeKe->id]['id'] = $tipeKe->id;
    		$tipe_kehadiran[$tipeKe->id]['alias'] = $tipeKe->alias;
    		$tipe_kehadiran[$tipeKe->id]['tipe'] = $tipeKe->tipe;
    	}

    	$pertemuan = new PertemuanKuliah;
    	$pertemuan->id_mata_kuliah = $request->input('mata_kuliah');
    	$pertemuan->waktu_pertemuan = date('Y-m-d H:i:s');
    	$pertemuan->created_by = Auth::user()->id;
    	$pertemuan->save();

    	foreach ($pesertas as $key => $peserta) {
    		$presensi = new PresensiKuliah;
    		$presensi->id_pertemuan_kuliah = $pertemuan->id;
    		$presensi->id_user_mahasiswa = $request->input('peserta-'.$peserta->id_user_mahasiswa);
    		$presensi->id_tipe_kehadiran = $request->input('kehadiran-'.$peserta->id_user_mahasiswa);

    		if (null !== $request->input('keterangan-'.$peserta->id_user_mahasiswa)) {
    			$presensi->keterangan = $request->input('keterangan-'.$peserta->id_user_mahasiswa);
    		}else{
    			$presensi->keterangan = '-';
    		}

    		$presensi->created_by = Auth::user()->id;
    		$presensi->save();
    	}

    	Log::aktivitas('Menambah '.$this->title.'.');

		return redirect(route('matakuliah.'.$this->slug.'.read', ['id'=>$request->input('mata_kuliah')]))->with('message_sukses', 'Data presensi berhasil disimpan');
		
	}

	public function checkAuthorization($id_mata_kuliah)
	{
		$user = Auth::user();
		$mata_kuliah = MataKuliah::where('id', $id_mata_kuliah)
									->where('id_semester', session('id_semester'))
									->where(function($q) use ($user) {
										$q->where('id_user_dosen_1', $user->id)
											->orWhere('id_user_dosen_1', $user->id);
									})->get();
		if ($mata_kuliah) {
			return true;
		}else{
			return false;
		}
	}

}
