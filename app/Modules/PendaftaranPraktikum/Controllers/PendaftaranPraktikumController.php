<?php
namespace App\Modules\PendaftaranPraktikum\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\PendaftaranPraktikum\Models\PendaftaranPraktikum;
use App\Modules\PendaftaranPraktikum\Models\PesertaPraktikum;
use App\Modules\Praktikum\Models\Praktikum;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class PendaftaranPraktikumController extends Controller
{
	protected $slug = 'pendaftaranpraktikum';
	protected $module = 'PendaftaranPraktikum';
	protected $title = "Pendaftaran Praktikum";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;
	protected $is_penuh = false;

	public function __construct()
	{
		$this->column_title = array('Praktikum', 'Laboratorium', 'Dosen', 'Hari', 'Waktu Mulai', 'Waktu Selesai', 'Kuota');
		$this->ajax_field = array(['praktikum', 'laboratorium', 'dosen', 'hari', 'waktu_mulai', 'waktu_selesai', 'kuota'], [0,1,2,3,4,5,6]);
		$this->validation = array(
			'pendaftaranpraktikum' => 'required|string|max:191',
		);
		$this->create_form = array(
			'pendaftaranpraktikum' =>	Form::text('pendaftaranpraktikum', old('pendaftaranpraktikum'), ['class' => 'form-control', 'placeholder' => 'Contoh: w', ] ),
		);
		$this->update_form = array(
			'pendaftaranpraktikum' =>	Form::text('pendaftaranpraktikum', old('pendaftaranpraktikum'), ['class' => 'form-control', 'placeholder' => 'Contoh: w', 'id' => 'key'] ),
		);
	}

	public function index()
	{
		#$data['pendaftaranpraktikum'] = PendaftaranPraktikum::all();
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

		return view('PendaftaranPraktikum::pendaftaranpraktikum', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data =  Praktikum::leftJoin('laboratorium', 'praktikum.id_laboratorium', 'laboratorium.id')
						->leftJoin('dosen', 'praktikum.id_user_dosen', 'dosen.id_user')
						->leftJoin('users', 'dosen.id_user', 'users.id')
						->leftJoin('hari', 'praktikum.id_hari', 'hari.id')
						->where('praktikum.is_aktif', 1)
						->where('praktikum.is_pendaftaran', 1)
						->orderBy('is_aktif', 'DESC')
						->orderBy('id', 'ASC')
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'praktikum.id',
							'praktikum.praktikum',
							'laboratorium.laboratorium',
							'users.name as nama_dosen',
							'dosen.nip as nip_dosen',
							'hari.hari',
							'praktikum.waktu_mulai',
							'praktikum.waktu_selesai',
							'praktikum.is_pendaftaran',
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('praktikum', 'praktikum $1')
			->addColumn('dosen', function ($data){
				return $data->nama_dosen.' | '.$data->nip_dosen;
			})
			->addColumn('kuota', function($data){
				
				$this->is_penuh = false;

				$praktikum = Praktikum::leftJoin('laboratorium', 'praktikum.id_laboratorium', 'laboratorium.id')
								->where('praktikum.id', $data->id)
								->first();

				$count_pendaftar = PesertaPraktikum::where('id_praktikum', $data->id)->count();

				if ($praktikum->maks_peserta <= $count_pendaftar) {
					$this->is_penuh = true;
				}

				return $count_pendaftar.' / '.$praktikum->maks_peserta;

			})
			->addColumn('action', function ($data) {
					$create = "";
				if(Content::menuPermission('create')){

					$peserta = $this->pesertaPraktikum($data->id, Auth::user()->id);
					if ($peserta) {
						$create = '<a id="confirmDaftar" value="'. $data->id .'" class="btn btn-outline  btn-sm btn-danger" href="'.route($this->slug.'.batal.create', ['id'=>$data->id]).'">
							<i class="fa fa-sign-out" aria-hidden="true"></i> Batalkan Daftar
						</a>';
					}else{
						if ($this->is_penuh) {
							$create = '<span class="label label-danger d-inline-block text-center"> Kuota Penuh </span>';
						}else{
							$create = '<a id="confirmDaftar" value="'. $data->id .'" class="btn btn-outline  btn-sm btn-success" href="'.route($this->slug.'.daftar.create', ['id'=>$data->id]).'">
									<span class="fa fa-sign-in" aria-hidden="true"> Daftar Praktikum</span>
								</a>';
						}
					}

				}
				
				return '
					<div class="btn-group" aria-label="User Action">'.
						$create
						.
					'</div>' ;
			})
			->make(true);
	}

	function postCreate(Request $request)
	{
		$this->validate($request, $this->validation);

		$pendaftaranpraktikum = new PendaftaranPraktikum();

		$pendaftaranpraktikum->pendaftaranpraktikum = $request->input('pendaftaranpraktikum');
		$pendaftaranpraktikum->created_by = Auth::user()->id;

		$pendaftaranpraktikum->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['pendaftaranpraktikum'] = PendaftaranPraktikum::find($id)->toJson();

	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, $this->validation);

		$pendaftaranpraktikum = PendaftaranPraktikum::find($request->input('edit_id'));

		$pendaftaranpraktikum->pendaftaranpraktikum = $request->input('pendaftaranpraktikum');
		$pendaftaranpraktikum->updated_by = Auth::user()->id;

		$pendaftaranpraktikum->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$pendaftaranpraktikum = PendaftaranPraktikum::find($id);
		$pendaftaranpraktikum->deleted_by = Auth::user()->id;
		$pendaftaranpraktikum->save();

		PendaftaranPraktikum::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

	public function daftar($id_praktikum)
	{
		if ($this->pesertaPraktikum($id_praktikum, Auth::user()->id)) {
			return redirect()->back()->with('message_danger', 'Anda sudah terdaftar pada Praktikum tersebut!');
		}

		if (!$this->checkPendaftaran($id_praktikum)) {
			return redirect()->back()->with('message_danger', 'Praktikum tidak aktif atau pendaftaran praktikum belum/telah diakhiri!');
		}

		$peserta_praktikum = new PesertaPraktikum;
		$peserta_praktikum->id_praktikum = $id_praktikum;
		$peserta_praktikum->id_user_mahasiswa = Auth::user()->id;

		$peserta_praktikum->save();

		Log::aktivitas('Mendaftar '.$this->title.'.');

		return redirect()->back()->with('message_sukses', 'Pendaftaran berhasil dilakukan!');
	}

	public function batal($id_praktikum)
	{
		if (!$this->checkPendaftaran($id_praktikum)) {
			return redirect()->back()->with('message_danger', 'Praktikum tidak aktif atau pendaftaran praktikum belum/telah diakhiri!');
		}

		$peserta_praktikum = $this->pesertaPraktikum($id_praktikum, Auth::user()->id);

		if ($peserta_praktikum->count() == 0) {
			return redirect()->back()->with('message_danger', 'Anda belum terdaftar pada Praktikum tersebut!');
		}

		$peserta_praktikum->deleted_by = Auth::user()->id;
		$peserta_praktikum->save();

		PesertaPraktikum::destroy($peserta_praktikum->id);

		Log::aktivitas('Membatalkan Pendaftaran Praktikum.');

		return redirect()->back()->with('message_sukses', 'Berhasil membatalkan pendaftaran!');
	}

	public function checkKuotaPraktikum($id_praktikum)
	{
		$praktikum = Praktikum::leftJoin('laboratorium', 'praktikum.id_laboratorium', 'laboratorium.id')
								->where('praktikum.id', $id)
								->first();

		$count_pendaftar = PesertaPraktikum::where('id_praktikum', $id_praktikum)->count();

		if ($praktikum->maks_peserta > $count_pendaftar) {
			return true;
		}else{
			return false;
		}
	}

	public function pesertaPraktikum($id_praktikum, $id_user_mahasiswa)
	{
		return PesertaPraktikum::where('id_praktikum', $id_praktikum)->where('id_user_mahasiswa', $id_user_mahasiswa)->first();
	}

	public function checkPendaftaran($id_praktikum)
	{
		$praktikum = Praktikum::find($id_praktikum);

		if ($praktikum->is_aktif == 1 && $praktikum->is_pendaftaran == 1) {
			return true;
		}else{
			return false;
		}
	}

}
