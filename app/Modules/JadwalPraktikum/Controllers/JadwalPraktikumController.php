<?php
namespace App\Modules\JadwalPraktikum\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\JadwalPraktikum\Models\JadwalPraktikum;
use App\Modules\JadwalPraktikum\Models\PesertaPraktikum;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class JadwalPraktikumController extends Controller
{
	protected $slug = 'jadwalpraktikum';
	protected $module = 'JadwalPraktikum';
	protected $title = "JadwalPraktikum";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$this->column_title = array('Praktikum', 'Dosen', 'Hari', 'Jam Praktikum');
		$this->ajax_field = array(['praktikum', 'dosen', 'hari', 'waktu'], [0,1,2,3]);
		$this->validation = array(
			'jadwalpraktikum' => 'required|string|max:191',
		);
		$this->create_form = array(
			'jadwalpraktikum' =>	Form::text('jadwalpraktikum', old('jadwalpraktikum'), ['class' => 'form-control', 'placeholder' => 'Contoh: w', ] ),
		);
		$this->update_form = array(
			'jadwalpraktikum' =>	Form::text('jadwalpraktikum', old('jadwalpraktikum'), ['class' => 'form-control', 'placeholder' => 'Contoh: w', 'id' => 'key'] ),
		);
	}

	public function index()
	{
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
			$data['create_button'] = '';
		}

		return view('JadwalPraktikum::jadwalpraktikum', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data =  PesertaPraktikum::leftJoin('praktikum', 'peserta_praktikum.id_praktikum', 'praktikum.id')
						->leftJoin('users', 'praktikum.id_user_dosen', 'users.id')
						->leftJoin('dosen', 'praktikum.id_user_dosen', 'dosen.id_user')
						->leftJoin('hari', 'praktikum.id_hari', 'hari.id')
						->where('peserta_praktikum.id_user_mahasiswa', Auth::user()->id)
						->where('praktikum.is_pendaftaran', 0)
						->where('praktikum.is_aktif', 1)
						->orderBy('hari.id', 'ASC')
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'praktikum.id',
							'praktikum.praktikum',
							'praktikum.waktu_mulai',
							'praktikum.waktu_selesai',
							'hari.hari',
							'users.name',
							'dosen.nip',
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('jadwalpraktikum', 'jadwalpraktikum $1')
			->addColumn('dosen', function ($data) {
				return $data->name.' | '.$data->nip;
			})
			->addColumn('waktu', function ($data) {
				return $data->waktu_mulai.' - '.$data->waktu_selesai;
			})

			->make(true);
	}

	function postCreate(Request $request)
	{
		$this->validate($request, $this->validation);

		$jadwalpraktikum = new JadwalPraktikum();

		$jadwalpraktikum->jadwalpraktikum = $request->input('jadwalpraktikum');
		$jadwalpraktikum->created_by = Auth::user()->id;

		$jadwalpraktikum->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['jadwalpraktikum'] = JadwalPraktikum::find($id)->toJson();

	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, $this->validation);

		$jadwalpraktikum = JadwalPraktikum::find($request->input('edit_id'));

		$jadwalpraktikum->jadwalpraktikum = $request->input('jadwalpraktikum');
		$jadwalpraktikum->updated_by = Auth::user()->id;

		$jadwalpraktikum->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$jadwalpraktikum = JadwalPraktikum::find($id);
		$jadwalpraktikum->deleted_by = Auth::user()->id;
		$jadwalpraktikum->save();

		JadwalPraktikum::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

}
