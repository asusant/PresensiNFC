<?php
namespace App\Modules\PresensiPraktikum\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Praktikum\Models\Praktikum;
use App\Modules\PresensiPraktikum\Models\Pertemuan;
use App\Modules\PresensiPraktikum\Models\PresensiPraktikum;
use App\Modules\TipeKehadiran\Models\TipeKehadiran;
use App\Modules\Praktikum\Models\PesertaPraktikum;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class PresensiPraktikumController extends Controller
{
	protected $slug = 'presensipraktikum';
	protected $module = 'PresensiPraktikum';
	protected $title = "Presensi Praktikum";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$this->column_title = array('Waktu Pertemuan', 'Total Peserta', 'Jumlah Hadir', 'Dipresesnsi Oleh');
		$this->ajax_field = array(['waktu_pertemuan', 'n_total', 'n_hadir', 'created_by'], [0,1,2,3]);
		$this->validation = array(
			'presensipraktikum' => 'required|string|max:191',
		);
		$this->create_form = array(
			'presensipraktikum' =>	Form::text('presensipraktikum', old('presensipraktikum'), ['class' => 'form-control', 'placeholder' => 'Contoh: w', ] ),
		);
		$this->update_form = array(
			'presensipraktikum' =>	Form::text('presensipraktikum', old('presensipraktikum'), ['class' => 'form-control', 'placeholder' => 'Contoh: w', 'id' => 'key'] ),
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
		$data['create_route'] = route('praktikum.'.$this->slug.'.post.create.update', ['id' => $id]);
		$data['update_route'] = route('praktikum.'.$this->slug.'.post.update', ['id'=>null]);
		$data['delete_route'] = route('praktikum.'.$this->slug.'.delete', ['id'=>null]);
		$data['presensi_route'] = route('praktikum.'.$this->slug.'.details.read', ['id'=>null]);
		$data['read_route'] = route('praktikum.'.$this->slug.'.get-data.read', ['id'=>$id]);
		$data['column_title'] = $this->column_title;
		$data['ajax_field'] = $this->ajax_field;
		$data['create_form'] = $this->create_form;
		$data['update_form'] = $this->update_form;
		$data['praktikum'] = Praktikum::leftJoin('hari', 'praktikum.id_hari', 'hari.id')->where('praktikum.id', $id)->first();

		$data['create_button'] = "";
		if(Content::menuPermission('update')){
			if (session('id_level') != 3) {
				$data['create_button'] = '<a class="btn btn-sm btn-default" href="'.route('praktikum.'.$this->slug.'.post.create.update', ['id'=>$id]).'">
											<i class="fa fa-plus" aria-hidden="true"></i>
											<span class="hidden-xs">Tambah '.$this->title.'</span>
										</a>';
			}
		}

		return view('PresensiPraktikum::presensipraktikum', $data);
	}

	public function getData(Datatables $datatables, Request $request, $id)
	{
		if (session('id_level') != 1) {
			if (!$this->checkAuthorization($id)) {
				return redirect()->back()->with('message_danger', 'Anda tidak terdaftar pada Praktikum ini!');
			}
		}

		DB::statement(DB::raw('set @no=0'));

		$data =  Pertemuan::leftJoin('praktikum', 'pertemuan.id_praktikum', 'praktikum.id')
						->leftJoin('users', 'pertemuan.created_by', 'users.id')
						->where('pertemuan.id_praktikum', $id)
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'pertemuan.*',
							'praktikum.id as id_praktikum',
							'users.name as created_by'
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('presensipraktikum', 'presensipraktikum $1')
			->addColumn('n_total', function($data){
				return PesertaPraktikum::where('id_praktikum', $data->id_praktikum)->count();
			})
			->editColumn('waktu_pertemuan', function($data){
				return Content::tanggal_indo($data->waktu_pertemuan);
			})
			->addColumn('n_hadir', function($data){
				return PresensiPraktikum::where('id_pertemuan', $data->id)
										->where('id_tipe_kehadiran', 1)
										->count();
			})
			->addColumn('action', function ($data) {
				$update = "";
				$validate = "";
				$delete = "";
				if(Content::menuPermission('read')){
					$read = '<button type="button" data-target="#formEditModal" value="'. $data->id .'" data-toggle="modal" class="btn btn-sm btn-outline btn-success">
							<i class="fa fa-search" aria-hidden="true"></i> Lihat Detail Presensi
						</button>';
				}
				if(Content::menuPermission('update')){
					/*$update = '<a href="'.route('praktikum.'.$this->slug.'.get.update', ['id_pertemuan' => $data->id]).'" class="btn btn-sm btn-outline btn-warning">
							<i class="fa fa-pencil" aria-hidden="true"></i> Ubah Presensi
						</a>';*/
				}
				/*if(Content::menuPermission('delete')){
					$delete = '<button type="button" id="confirmDelete" value="'. $data->id .'" class="btn btn-outline  btn-sm btn-danger" data-target="#confirmDeleteModal" data-toggle="modal">
							<i class="fa fa-trash" aria-hidden="true"></i> Delete
						</button>';
				}*/

				return '
					<div class="btn-group" aria-label="User Action">'.
						$read.$update.$delete
						.
					'</div>' ;
			})
			->make(true);
	}

	function postCreate(Request $request, $id)
	{
		if (session('id_level') != 1) {
			if (!$this->checkAuthorization($id)) {
				return redirect()->back()->with('message_danger', 'Anda tidak terdaftar pada Praktikum ini!');
			}

			if (!$this->checkPraktikumAktif($id)) {
				return redirect()->back()->with('message_danger', 'Praktikum sudah tidak aktif!');
			}
		}

		$data['title'] = $this->title;
		$data['praktikum'] = Praktikum::leftJoin('dosen', 'praktikum.id_user_dosen', 'dosen.id_user')
										->leftJoin('users', 'dosen.id_user', 'users.id')
										->leftJoin('laboratorium', 'praktikum.id_laboratorium', 'laboratorium.id')
										->leftJoin('hari', 'praktikum.id_hari', 'hari.id')
										->where('praktikum.id', $id)
										->first([
											'praktikum.*',
										]);

		$data['presensi_route'] = route('praktikum.'.$this->slug.'.read', ['id'=>$id]);
		$data['create_route'] = route('praktikum.'.$this->slug.'.post.presensi.update', ['id'=>$id]);
		$data['pesertas'] = PesertaPraktikum::leftJoin('users', 'peserta_praktikum.id_user_mahasiswa', 'users.id')
											->leftJoin('mahasiswa', 'peserta_praktikum.id_user_mahasiswa', 'mahasiswa.id_user')
											->where('id_praktikum', $id)
											->get([
												'users.id',
												'users.name',
												'mahasiswa.nim',
											]);

		$data['tipe_kehadirans'] = TipeKehadiran::all();

		return view('PresensiPraktikum::input_presensi', $data);
	}

	public function details($id)
	{
		$data['pertemuan'] = Pertemuan::leftJoin('praktikum', 'pertemuan.id_praktikum', 'praktikum.id')
										->leftJoin('users', 'praktikum.id_user_dosen', 'users.id')
										->leftJoin('dosen', 'users.id', 'dosen.id_user')
										->leftJoin('hari', 'praktikum.id_hari', 'hari.id')
										->where('pertemuan.id', $id)
										->first();
		$data['presensi'] = PresensiPraktikum::leftJoin('pertemuan', 'presensi_praktikum.id_pertemuan', 'pertemuan.id')
											->leftJoin('praktikum', 'pertemuan.id_praktikum', 'praktikum.id')
											->leftJoin('users', 'presensi_praktikum.id_user_mahasiswa', 'users.id')
											->leftJoin('mahasiswa', 'mahasiswa.id_user', 'users.id')
											->leftJoin('tipe_kehadiran', 'presensi_praktikum.id_tipe_kehadiran', 'tipe_kehadiran.id')
											->leftJoin('hari', 'praktikum.id_hari', 'hari.id')
											->where('presensi_praktikum.id_pertemuan', $id)
											->orderBy('mahasiswa.nim')
											->get();
		return json_encode($data);

	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, $this->validation);

		$presensipraktikum = PresensiPraktikum::find($request->input('edit_id'));

		$presensipraktikum->presensipraktikum = $request->input('presensipraktikum');
		$presensipraktikum->updated_by = Auth::user()->id;

		$presensipraktikum->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$presensipraktikum = PresensiPraktikum::find($id);
		$presensipraktikum->deleted_by = Auth::user()->id;
		$presensipraktikum->save();

		PresensiPraktikum::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

	public function postCreatePresensi(Request $request, $id)
	{
		if (session('id_level') != 1) {
			if (!$this->checkAuthorization($id)) {
				return redirect()->back()->with('message_danger', 'Anda tidak terdaftar pada Praktikum ini!');
			}
			if (!$this->checkPraktikumAktif($id)) {
				return redirect()->back()->with('message_danger', 'Praktikum sudah tidak aktif!');
			}
		}

		$tipeKehadiran = TipeKehadiran::all();
		$pesertas = PesertaPraktikum::where('id_praktikum', $request->input('praktikum'))->get();

		$tipe_kehadiran = array();

    	foreach ($tipeKehadiran as $key => $tipeKe) {
			$tipe_kehadiran[$tipeKe->id] = array();
    		$tipe_kehadiran[$tipeKe->id]['id'] = $tipeKe->id;
    		$tipe_kehadiran[$tipeKe->id]['alias'] = $tipeKe->alias;
    		$tipe_kehadiran[$tipeKe->id]['tipe'] = $tipeKe->tipe;
    	}

    	$pertemuan = new Pertemuan;
    	$pertemuan->id_praktikum = $request->input('praktikum');
    	$pertemuan->waktu_pertemuan = date('Y-m-d H:i:s');
    	$pertemuan->created_by = Auth::user()->id;
    	$pertemuan->save();

    	foreach ($pesertas as $key => $peserta) {
    		$presensi = new PresensiPraktikum;
    		$presensi->id_pertemuan = $pertemuan->id;
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

		return redirect(route('praktikum.'.$this->slug.'.read', ['id'=>$request->input('praktikum')]))->with('message_sukses', 'Data presensi berhasil disimpan');
		
	}

	public function checkPraktikumAktif($id_praktikum)
	{
		$praktikum = Praktikum::where('is_aktif', 1)->where('is_pendaftaran', 0)->where('id', $id_praktikum)->first();

		if ($praktikum) {
			return true;
		}else{
			return false;
		}
	}

	public function checkAuthorization($id_praktikum)
	{
		$praktikum = Praktikum::where('id', $id_praktikum)->where('id_user_dosen', Auth::user()->id)->get();
		if ($praktikum) {
			return true;
		}else{
			return false;
		}
	}

}
