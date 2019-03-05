<?php
namespace App\Modules\Praktikum\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Praktikum\Models\Praktikum;
use App\Modules\Praktikum\Models\NilaiPraktikum;
use App\Modules\PraktikumDosen\Models\PesertaPraktikum;
use App\Modules\Laboratorium\Models\Laboratorium;
use App\Modules\Dosen\Models\Dosen;
use App\Modules\Hari\Models\Hari;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class PraktikumController extends Controller
{
	protected $slug = 'praktikum';
	protected $module = 'Praktikum';
	protected $title = "Praktikum Aktif";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$laboratorium = Laboratorium::pluck('laboratorium', 'id')->toArray();
		$dosen = Dosen::leftJoin('users', 'dosen.id_user', 'users.id')->pluck('users.name', 'dosen.id_user')->toArray();
		$hari = Hari::pluck('hari', 'id')->toArray();

		$this->column_title = array('Praktikum', 'Laboratorium', 'Dosen', 'Hari', 'Waktu Mulai', 'Waktu Selesai');
		$this->ajax_field = array(['praktikum', 'laboratorium', 'dosen', 'hari', 'waktu_mulai', 'waktu_selesai'], [0,1,2,3,4,5]);
		$this->validation = array(
			'praktikum'		=> 'required|string|max:190',
			'laboratorium'	=> 'required|exists:laboratorium,id',
			'dosen' 		=> 'required|exists:dosen,id_user',
			'hari' 			=> 'required|exists:hari,id',
			'waktu_mulai'	=> 'required|date_format:H:i',
			'waktu_selesai'	=> 'required|date_format:H:i',
		);
		$this->create_form = array(
			'Praktikum' =>	Form::text('praktikum', old('praktikum'), ['class' => 'form-control', 'placeholder' => 'Contoh: Praktikum Desain Grafis', ] ),
			'Laboratorium'	=> Form::select('laboratorium', $laboratorium, null, ['class' => 'form-control', 'placeholder' => '---Pilih Laboratorium---', ]),
			'Dosen'	=> Form::select('dosen', $dosen, null, ['class' => 'form-control', 'placeholder' => '---Pilih Dosen---', ]),
			'Hari'	=> Form::select('hari', $hari, null, ['class' => 'form-control', 'placeholder' => '---Pilih Hari---', ]),
			'Waktu Mulai' => Form::time('waktu_mulai', old('waktu_mulai'), ['class' => 'form-control', 'placeholder' => 'Contoh: 10:00 PM', 'id' => 'add_mulai'] ),
			'Waktu Selesai' => Form::time('waktu_selesai', old('waktu_selesai'), ['class' => 'form-control timepicker', 'placeholder' => 'Contoh: 10:00 PM', 'id' => 'add_selesai'] ),
		);
		$this->update_form = array(
			'Praktikum' =>	Form::text('praktikum', old('praktikum'), ['class' => 'form-control', 'placeholder' => 'Contoh: Praktikum Desain Grafis', 'id' => 'praktikum'] ),
			'Laboratorium'	=> Form::select('laboratorium', $laboratorium, null, ['class' => 'form-control', 'placeholder' => '---Pilih Laboratorium---', 'id' => 'laboratorium']),
			'Dosen'	=> Form::select('dosen', $dosen, null, ['class' => 'form-control', 'placeholder' => '---Pilih Dosen---', 'id' => 'dosen']),
			'Hari'	=> Form::select('hari', $hari, null, ['class' => 'form-control', 'placeholder' => '---Pilih Hari---', 'id' => 'hari']),
			'Waktu Mulai' => Form::time('waktu_mulai', old('waktu_mulai'), ['class' => 'form-control timepicker', 'placeholder' => 'Contoh: 10:00 PM', 'id' => 'waktu_mulai'] ),
			'Waktu Selesai' => Form::time('waktu_selesai', old('waktu_selesai'), ['class' => 'form-control timepicker', 'placeholder' => 'Contoh: 10:00 PM', 'id' => 'waktu_selesai'] ),
		);
	}

	public function index()
	{
		$data['praktikum'] = Praktikum::all();
		$data['title'] = $this->title;
		$data['create_route'] = route($this->slug.'.aktif.post.create');
		$data['update_route'] = route($this->slug.'.aktif.post.update', ['id'=>null]);
		$data['delete_route'] = route($this->slug.'.aktif.delete', ['id'=>null]);
		$data['detail_route'] = route($this->slug.'.aktif.details.read', ['id'=>null]);
		$data['peserta_route'] = route($this->slug.'.aktif.peserta.read', ['id'=>null]);
		$data['read_route'] = route($this->slug.'.aktif.get-data.read');
		$data['nonaktif_route'] = route($this->slug.'.aktif.validate', ['id' => null]);
		$data['nilai_route'] = route($this->slug.'.nilai.get.nilai.read', ['id'=>null]);
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

		return view('Praktikum::praktikum', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		if (session('id_level') == 4) {
			$data =  Praktikum::leftJoin('laboratorium', 'praktikum.id_laboratorium', 'laboratorium.id')
						->leftJoin('dosen', 'praktikum.id_user_dosen', 'dosen.id_user')
						->leftJoin('users', 'dosen.id_user', 'users.id')
						->leftJoin('hari', 'praktikum.id_hari', 'hari.id')
						->where('praktikum.is_aktif', 1)
						->where('praktikum.is_pendaftaran', 0)
						->where('praktikum.id_user_dosen', Auth::user()->id)
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
		}else{
			$data =  Praktikum::leftJoin('laboratorium', 'praktikum.id_laboratorium', 'laboratorium.id')
						->leftJoin('dosen', 'praktikum.id_user_dosen', 'dosen.id_user')
						->leftJoin('users', 'dosen.id_user', 'users.id')
						->leftJoin('hari', 'praktikum.id_hari', 'hari.id')
						->where('praktikum.is_aktif', 1)
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
		}

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('praktikum', 'praktikum $1')
			->addColumn('dosen', function ($data){
				return $data->nama_dosen.' | '.$data->nip_dosen;
			})
			->addColumn('action', function ($data) {
				$update = "";
				$validate = "";
				$delete = "";
				if(Content::menuPermission('update')){
					$update = '<button type="button" data-target="#formPesertaModal" value="'. $data->id .'" data-toggle="modal" class="btn btn-sm btn-outline btn-info">
							<i class="fa fa-search" aria-hidden="true"></i> '.(($data->is_pendaftaran == 1) ? 'Lihat Pendaftar': 'Peserta Praktikum').'
						</button>';

					$update .= '<a value="'. $data->id .'" class="btn btn-sm btn-outline btn-info" href="'.route('praktikum.presensipraktikum.read', ['id'=>$data->id]).'">
							<i class="fa fa-paste" aria-hidden="true"></i> Presensi
						</a>';

					if ($this->checkNilaiPraktikum($data->id)) {
						if (session('id_level') != 3) {
							$update .= '<a value="'. $data->id .'" class="btn btn-sm btn-outline btn-primary" href="'.route('praktikum.nilai.get.update', ['id'=>$data->id]).'">
									<i class="fa fa-file-text" aria-hidden="true"></i> Nilai Praktikum
								</a>';
						}
					}else{
						$update .= '<button type="button" data-target="#formNilaiModal" value="'. $data->id .'" data-toggle="modal" class="btn btn-sm btn-outline btn-primary">
							<i class="fa fa-search" aria-hidden="true"></i> Lihat Nilai
						</button>';
						$update .= '<a href="'.route('praktikum.nilai.print.read', ['id'=>$data->id]) .'" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline btn-info">
							<i class="fa fa-print" aria-hidden="true"></i> Print Nilai
						</a>';
					}
				}
				if(Content::menuPermission('delete')){
					$delete = '<button type="button" id="confirmDelete" value="'. $data->id .'" class="btn btn-outline  btn-sm btn-danger" data-target="#confirmDeleteModal" data-toggle="modal">
							<i class="fa fa-trash" aria-hidden="true"></i> Delete
						</button>';
				}
				if(Content::menuPermission('validate')){

					$update .= '<button type="button" data-target="#formEditModal" value="'. $data->id .'" data-toggle="modal" class="btn btn-sm btn-outline btn-primary">
							<i class="fa fa-pencil" aria-hidden="true"></i> Edit
						</button>';

					$validate = '<a class="btn btn-outline  btn-sm btn-cyan" href="'.route($this->slug.'.aktif.pendaftaran.validate', ['id'=>$data->id]).'">
						<i class="fa fa-check-circle" aria-hidden="true"></i> '.(($data->is_pendaftaran == 1) ? 'Tutup Pendaftaran': 'Buka Pendaftaran').'
					</a>';

					$validate .= '<button type="button" id="confirmNonaktif" value="'. $data->id .'" class="btn btn-outline  btn-sm btn-warning" data-target="#confirmNonaktifModal" data-toggle="modal">
							<i class="fa fa-warning" aria-hidden="true"></i> Nonaktifkan
						</button>';
				}

				return '
					'.
						$update.$validate.$delete
						.
					'' ;
			})
			->make(true);
	}

	function postCreate(Request $request)
	{
		$this->validate($request, $this->validation);

		if ($this->cekJadwal($request->input('laboratorium'), $request->input('hari'), $request->input('waktu_mulai'), $request->input('waktu_selesai'))->count() > 0) {
			return redirect()->back()->with('message_danger', $this->title.' gagal ditambahkan! Jadwal tumbukan dengan jadwal yang lain!');
		}

		$praktikum = new Praktikum();

		$praktikum->praktikum = $request->input('praktikum');
		$praktikum->id_laboratorium = $request->input('laboratorium');
		$praktikum->id_user_dosen = $request->input('dosen');
		$praktikum->id_hari = $request->input('hari');
		$praktikum->waktu_mulai = $request->input('waktu_mulai');
		$praktikum->waktu_selesai = $request->input('waktu_selesai');

		$praktikum->created_by = Auth::user()->id;

		$praktikum->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['praktikum'] = Praktikum::first([
												'id',
												'praktikum',
												'id_laboratorium as laboratorium',
												'id_user_dosen as dosen',
												'id_hari as hari',
												'waktu_mulai',
												'waktu_selesai',
											])->toJson();

	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, $this->validation);

		if ($this->cekJadwal($request->input('laboratorium'), $request->input('hari'), $request->input('waktu_mulai'), $request->input('waktu_selesai'), $request->input('edit_id'))->count() > 0) {
			return redirect()->back()->with('message_danger', $this->title.' gagal ditambahkan! Jadwal tumbukan dengan jadwal yang lain!');
		}

		$praktikum = Praktikum::find($request->input('edit_id'));

		$praktikum->praktikum = $request->input('praktikum');
		$praktikum->id_laboratorium = $request->input('laboratorium');
		$praktikum->id_user_dosen = $request->input('dosen');
		$praktikum->id_hari = $request->input('hari');
		$praktikum->waktu_mulai = $request->input('waktu_mulai');
		$praktikum->waktu_selesai = $request->input('waktu_selesai');

		$praktikum->updated_by = Auth::user()->id;

		$praktikum->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$praktikum = Praktikum::find($id);
		$praktikum->deleted_by = Auth::user()->id;
		$praktikum->save();

		Praktikum::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

	public function nonAktif($id)
	{
		$praktikum = Praktikum::find($id);
		$praktikum->is_aktif = 0;
		$praktikum->updated_by = Auth::user()->id;
		$praktikum->save();

		Log::aktivitas('Menonaktifkan '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dinonaktifkan!');
	}

	public function pendaftaran($id)
	{
		$praktikum = Praktikum::find($id);
		if ($praktikum->is_pendaftaran == 1) {
			$praktikum->is_pendaftaran = 0;
		}else{
			$praktikum->is_pendaftaran = 1;
		}
		$praktikum->updated_by = Auth::user()->id;
		$praktikum->save();

		Log::aktivitas('Mengubah status Pendaftaran '.$this->title.'.');

		return redirect()->back()->with('message_sukses', 'Status Pendaftaran '.$this->title.' berhasil diubah!');
	}

	public function pesertaPraktikum($id)
	{
		$data['praktikum'] = Praktikum::leftJoin('dosen', 'praktikum.id_user_dosen', 'dosen.id_user')
										->leftJoin('users', 'praktikum.id_user_dosen', 'users.id')
										->leftJoin('hari', 'praktikum.id_hari', 'hari.id')
										->where('praktikum.id', $id)
										->first();
		$data['peserta'] = PesertaPraktikum::leftJoin('mahasiswa', 'peserta_praktikum.id_user_mahasiswa', 'mahasiswa.id_user')
											->leftJoin('users', 'mahasiswa.id_user', 'users.id')
											->where('id_praktikum', $id)
											->orderBy('mahasiswa.nim')
											->get();
		return json_encode($data);
	}

	public function cekJadwal($id_laboratorium, $id_hari, $waktu_mulai, $waktu_selesai, $except_id = null)
	{
		if (!$except_id) {
			$cekMulai = Praktikum::where('id_hari', $id_hari)
								->where('is_aktif', 1)
								->where('id_laboratorium', $id_laboratorium)
								->where('id', '<>', $except_id)
								->whereBetween('waktu_mulai', [$waktu_mulai, $waktu_selesai])
								->get();

			if ($cekMulai->count() > 0) {
				return $cekMulai;
			}else{
				return $jadwal = Praktikum::where('id_hari', $id_hari)
									->where('is_aktif', 1)
									->where('id_laboratorium', $id_laboratorium)
									->where('id', '<>', $except_id)
									->whereBetween('waktu_selesai', [$waktu_mulai, $waktu_selesai])
									->get();
			}
		}else{
			$cekMulai = Praktikum::where('id_hari', $id_hari)
								->where('is_aktif', 1)
								->where('id_laboratorium', $id_laboratorium)
								->whereBetween('waktu_mulai', [$waktu_mulai, $waktu_selesai])
								->get();

			if ($cekMulai->count() > 0) {
				return $cekMulai;
			}else{
				return $jadwal = Praktikum::where('id_hari', $id_hari)
									->where('is_aktif', 1)
									->where('id_laboratorium', $id_laboratorium)
									->whereBetween('waktu_selesai', [$waktu_mulai, $waktu_selesai])
									->get();
			}
		}
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

	public function checkNilaiPraktikum($id_praktikum)
	{
		$praktikum = NilaiPraktikum::where('id_praktikum', $id_praktikum)->count();
		if ($praktikum > 0) {
			return false;
		}else{
			return true;
		}
	}

	public function nilaiPraktikum($id)
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
										->first();

		$data['praktikum_route'] = route($this->slug.'.aktif.read');
		$data['create_route'] = route($this->slug.'.nilai.post.update', ['id'=>$id]);

		$data['pesertas'] = PesertaPraktikum::leftJoin('users', 'peserta_praktikum.id_user_mahasiswa', 'users.id')
											->leftJoin('mahasiswa', 'peserta_praktikum.id_user_mahasiswa', 'mahasiswa.id_user')
											->where('id_praktikum', $id)
											->get([
												'users.id',
												'users.name',
												'mahasiswa.nim',
											]);

		return view('Praktikum::input_nilai', $data);
	}

	public function postNilaiPraktikum(Request $request, $id)
	{
		if (session('id_level') != 1) {
			if (!$this->checkAuthorization($id)) {
				return redirect()->back()->with('message_danger', 'Anda tidak terdaftar pada Praktikum ini!');
			}
			if (!$this->checkPraktikumAktif($id)) {
				return redirect()->back()->with('message_danger', 'Praktikum sudah tidak aktif!');
			}
		}

		$pesertas = PesertaPraktikum::where('id_praktikum', $id)->get();

		foreach ($pesertas as $key => $peserta) {
			$nilai = new NilaiPraktikum;
			
			$nilai->id_praktikum = $id;
			$nilai->id_user_mahasiswa = $peserta->id_user_mahasiswa;
			$nilai->nilai = $request->input('nilai-'.$peserta->id_user_mahasiswa);

			$nilai->created_by = Auth::user()->id;

			$nilai->save();
		}

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect(route($this->slug.'.aktif.read'))->with('message_sukses', 'Nilai berhasil diinput!');
	}

	public function getNilaiPraktikum($id)
	{
		if (session('id_level') != 1) {
			if (!$this->checkAuthorization($id)) {
				return redirect()->back()->with('message_danger', 'Anda tidak terdaftar pada Praktikum ini!');
			}
			if (!$this->checkPraktikumAktif($id)) {
				return redirect()->back()->with('message_danger', 'Praktikum sudah tidak aktif!');
			}
		}

		$data['praktikum'] = Praktikum::leftJoin('dosen', 'praktikum.id_user_dosen', 'dosen.id_user')
										->leftJoin('users', 'praktikum.id_user_dosen', 'users.id')
										->leftJoin('hari', 'praktikum.id_hari', 'hari.id')
										->where('praktikum.id', $id)
										->first();
		$data['peserta'] = NilaiPraktikum::leftJoin('users', 'nilai_praktikum.id_user_mahasiswa', 'users.id')
											->leftJoin('mahasiswa', 'users.id', 'mahasiswa.id_user')
											->where('id_praktikum', $id)
											->orderBy('mahasiswa.nim')
											->get();
		return json_encode($data);
	}

	public function printNilaiPraktikum($id)
	{
		if (session('id_level') != 1) {
			if (!$this->checkAuthorization($id)) {
				return redirect()->back()->with('message_danger', 'Anda tidak terdaftar pada Praktikum ini!');
			}
			if (!$this->checkPraktikumAktif($id)) {
				return redirect()->back()->with('message_danger', 'Praktikum sudah tidak aktif!');
			}
		}

		$data['praktikum'] = Praktikum::leftJoin('dosen', 'praktikum.id_user_dosen', 'dosen.id_user')
										->leftJoin('users', 'praktikum.id_user_dosen', 'users.id')
										->leftJoin('hari', 'praktikum.id_hari', 'hari.id')
										->where('praktikum.id', $id)
										->first();
		$data['peserta'] = NilaiPraktikum::leftJoin('users', 'nilai_praktikum.id_user_mahasiswa', 'users.id')
											->leftJoin('mahasiswa', 'users.id', 'mahasiswa.id_user')
											->where('id_praktikum', $id)
											->orderBy('mahasiswa.nim')
											->get();

		return view('Praktikum::print_nilai', $data);
	}

}
