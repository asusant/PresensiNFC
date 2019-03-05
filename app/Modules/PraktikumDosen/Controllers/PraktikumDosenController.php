<?php
namespace App\Modules\PraktikumDosen\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\PraktikumDosen\Models\PraktikumDosen;
use App\Modules\PraktikumDosen\Models\PesertaPraktikum;
use App\Modules\Praktikum\Models\Praktikum;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class PraktikumDosenController extends Controller
{
	protected $slug = 'praktikumdosen';
	protected $module = 'PraktikumDosen';
	protected $title = "Praktikum Dosen";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$this->column_title = array('Praktikum', 'Laboratorium', 'Dosen', 'Hari', 'Waktu Mulai', 'Waktu Selesai');
		$this->ajax_field = array(['praktikum', 'laboratorium', 'dosen', 'hari', 'waktu_mulai', 'waktu_selesai'], [0,1,2,3,4,5]);
		$this->validation = array(
			'praktikumdosen' => 'required|string|max:191',
		);
		$this->create_form = array(
			'praktikumdosen' =>	Form::text('praktikumdosen', old('praktikumdosen'), ['class' => 'form-control', 'placeholder' => 'Contoh: w', ] ),
		);
		$this->update_form = array(
			'praktikumdosen' =>	Form::text('praktikumdosen', old('praktikumdosen'), ['class' => 'form-control', 'placeholder' => 'Contoh: w', 'id' => 'key'] ),
		);
	}

	public function index()
	{
		$data['praktikumdosen'] = PraktikumDosen::all();
		$data['title'] = $this->title;
		$data['create_route'] = route($this->slug.'.post.create');
		$data['update_route'] = route($this->slug.'.post.update', ['id'=>null]);
		$data['delete_route'] = route($this->slug.'.delete', ['id'=>null]);
		$data['detail_route'] = route($this->slug.'.details.read', ['id'=>null]);
		$data['read_route'] = route($this->slug.'.get-data.read');
		$data['nonaktif_route'] = route($this->slug.'.nonaktif.validate', ['id'=>null]);
		$data['column_title'] = $this->column_title;
		$data['ajax_field'] = $this->ajax_field;
		$data['create_form'] = $this->create_form;
		$data['update_form'] = $this->update_form;

		$data['create_button'] = "";
		if(Content::menuPermission('create')){
			$data['create_button'] = '';
		}

		return view('PraktikumDosen::praktikumdosen', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

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
					$update = '<button type="button" id="peserta" value="'. $data->id .'" class="btn btn-outline  btn-sm btn-cyan" data-target="#formEditModal" data-toggle="modal">
							<i class="fa fa-file-text-o" aria-hidden="true"></i> Daftar Peserta
						</button>';
					$update .= '<a href="'.'#route'.'" value="'. $data->id .'" class="btn btn-outline  btn-sm btn-info">
							<i class="fa fa-calendar-check-o" aria-hidden="true"></i> Presensi
						</a>';
				}
				if(Content::menuPermission('validate')){
					$validate .= '<button type="button" id="confirmNonaktif" value="'. $data->id .'" class="btn btn-outline  btn-sm btn-warning" data-target="#confirmAktifModal" data-toggle="modal">
							<i class="fa fa-warning" aria-hidden="true"></i> Selesaikan Praktikum
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

		$praktikumdosen = new PraktikumDosen();

		$praktikumdosen->praktikumdosen = $request->input('praktikumdosen');
		$praktikumdosen->created_by = Auth::user()->id;

		$praktikumdosen->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		if (!$this->checkAuthorization($id)) {
			return redirect()->back()->with('message_danger', 'Anda tidak terdaftar pada Praktikum ini!');
		}

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

	public function postUpdate(Request $request)
	{
		$this->validate($request, $this->validation);

		$praktikumdosen = PraktikumDosen::find($request->input('edit_id'));

		$praktikumdosen->praktikumdosen = $request->input('praktikumdosen');
		$praktikumdosen->updated_by = Auth::user()->id;

		$praktikumdosen->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$praktikumdosen = PraktikumDosen::find($id);
		$praktikumdosen->deleted_by = Auth::user()->id;
		$praktikumdosen->save();

		PraktikumDosen::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
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

	public function akhiriPraktikum($id)
	{
		if (!$this->checkAuthorization($id)) {
			return redirect()->back()->with('message_danger', 'Anda tidak terdaftar pada Praktikum ini!');
		}

		$praktikum = Praktikum::find($id);
		$praktikum->is_aktif = 0;
		$praktikum->updated_by = Auth::user()->id;
		$praktikum->save();

		Log::aktivitas('Mengaktifkan '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diselesaikan! Silakan cek pada menu Praktikum Nonaktif!');
	}

}
