<?php
namespace App\Modules\HistoryPraktikum\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\HistoryPraktikum\Models\HistoryPraktikum;
use App\Modules\Praktikum\Models\NilaiPraktikum;
use App\Modules\JadwalPraktikum\Models\JadwalPraktikum;
use App\Modules\JadwalPraktikum\Models\PesertaPraktikum;
use App\Modules\Praktikum\Models\Praktikum;
use App\Modules\Mahasiswa\Models\Mahasiswa;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class HistoryPraktikumController extends Controller
{
	protected $slug = 'historypraktikum';
	protected $module = 'HistoryPraktikum';
	protected $title = "History Praktikum";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$this->column_title = array('Praktikum', 'Dosen', 'Hari', 'Jam Praktikum', 'Nilai Praktikum', 'Waktu Berakhir');
		$this->ajax_field = array(['praktikum', 'dosen', 'hari', 'waktu', 'nilai', 'waktu_selesai'], [0,1,2,3,4]);
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

		return view('HistoryPraktikum::historypraktikum', $data);
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
						->where('praktikum.is_aktif', 0)
						->orderBy('praktikum.created_at', 'ASC')
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
			->addColumn('nilai', function($data){
				$nilai = NilaiPraktikum::where('id_praktikum', $data->id)->where('id_user_mahasiswa', Auth::user()->id)->first();
				return $nilai->nilai;
			})
			->addColumn('waktu_selesai', function($data){
				$nilai = NilaiPraktikum::where('id_praktikum', $data->id)->where('id_user_mahasiswa', Auth::user()->id)->first();
				return Content::tanggal_indo($nilai->created_at);
			})
			->addColumn('dosen', function ($data) {
				return $data->name.' | '.$data->nip;
			})
			->addColumn('waktu', function ($data) {
				return $data->waktu_mulai.' - '.$data->waktu_selesai;
			})
			->addColumn('action', function ($data) {
				return '<a href="'.route('historypraktikum.print.nilai.read', ['id'=>$data->id]) .'" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline btn-info">
							<i class="fa fa-print" aria-hidden="true"></i> Print Nilai
						</a>';
			})
			->make(true);
	}

	function postCreate(Request $request)
	{
		$this->validate($request, $this->validation);

		$historypraktikum = new HistoryPraktikum();

		$historypraktikum->historypraktikum = $request->input('historypraktikum');
		$historypraktikum->created_by = Auth::user()->id;

		$historypraktikum->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['historypraktikum'] = HistoryPraktikum::find($id)->toJson();

	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, $this->validation);

		$historypraktikum = HistoryPraktikum::find($request->input('edit_id'));

		$historypraktikum->historypraktikum = $request->input('historypraktikum');
		$historypraktikum->updated_by = Auth::user()->id;

		$historypraktikum->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$historypraktikum = HistoryPraktikum::find($id);
		$historypraktikum->deleted_by = Auth::user()->id;
		$historypraktikum->save();

		HistoryPraktikum::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

	public function printNilai($id)
	{
		$data['praktikum'] = Praktikum::leftJoin('dosen', 'praktikum.id_user_dosen', 'dosen.id_user')
										->leftJoin('users', 'praktikum.id_user_dosen', 'users.id')
										->leftJoin('hari', 'praktikum.id_hari', 'hari.id')
										->leftJoin('nilai_praktikum', 'praktikum.id', 'nilai_praktikum.id_praktikum')
										->where('praktikum.id', $id)
										->where('nilai_praktikum.id_user_mahasiswa', Auth::user()->id)
										->first();

		$data['mahasiswa'] = Mahasiswa::leftJoin('users', 'mahasiswa.id_user', 'users.id')
										->where('mahasiswa.id_user', Auth::user()->id)
										->first();

		return view('HistoryPraktikum::print_nilai', $data);
	}

}
