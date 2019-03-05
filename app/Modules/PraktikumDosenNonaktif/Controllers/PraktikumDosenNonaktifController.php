<?php
namespace App\Modules\PraktikumDosenNonaktif\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\PraktikumDosenNonaktif\Models\PraktikumDosenNonaktif;
use App\Modules\Praktikum\Models\Praktikum;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class PraktikumDosenNonaktifController extends Controller
{
	protected $slug = 'praktikumdosennonaktif';
	protected $module = 'PraktikumDosenNonaktif';
	protected $title = "PraktikumDosenNonaktif";

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
			'praktikumdosennonaktif' => 'required|string|max:191',
		);
		$this->create_form = array(
			'praktikumdosennonaktif' =>	Form::text('praktikumdosennonaktif', old('praktikumdosennonaktif'), ['class' => 'form-control', 'placeholder' => 'Contoh: w', ] ),
		);
		$this->update_form = array(
			'praktikumdosennonaktif' =>	Form::text('praktikumdosennonaktif', old('praktikumdosennonaktif'), ['class' => 'form-control', 'placeholder' => 'Contoh: w', 'id' => 'key'] ),
		);
	}

	public function index()
	{
		$data['title'] = $this->title;
		$data['create_route'] = route('praktikumdosen.nonaktif.post.create');
		$data['update_route'] = route('praktikumdosen.nonaktif.post.update', ['id'=>null]);
		$data['delete_route'] = route('praktikumdosen.nonaktif.delete', ['id'=>null]);
		$data['detail_route'] = route('praktikumdosen.nonaktif.details.read', ['id'=>null]);
		$data['read_route'] = route('praktikumdosen.nonaktif.get-data.read');
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

		return view('PraktikumDosenNonaktif::praktikumdosennonaktif', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data =  Praktikum::leftJoin('laboratorium', 'praktikum.id_laboratorium', 'laboratorium.id')
						->leftJoin('dosen', 'praktikum.id_user_dosen', 'dosen.id_user')
						->leftJoin('users', 'dosen.id_user', 'users.id')
						->leftJoin('hari', 'praktikum.id_hari', 'hari.id')
						->where('praktikum.is_aktif', 0)
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
				if(Content::menuPermission('validate')){
					
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

		$praktikumdosennonaktif = new PraktikumDosenNonaktif();

		$praktikumdosennonaktif->praktikumdosennonaktif = $request->input('praktikumdosennonaktif');
		$praktikumdosennonaktif->created_by = Auth::user()->id;

		$praktikumdosennonaktif->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['praktikumdosennonaktif'] = PraktikumDosenNonaktif::find($id)->toJson();

	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, $this->validation);

		$praktikumdosennonaktif = PraktikumDosenNonaktif::find($request->input('edit_id'));

		$praktikumdosennonaktif->praktikumdosennonaktif = $request->input('praktikumdosennonaktif');
		$praktikumdosennonaktif->updated_by = Auth::user()->id;

		$praktikumdosennonaktif->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$praktikumdosennonaktif = PraktikumDosenNonaktif::find($id);
		$praktikumdosennonaktif->deleted_by = Auth::user()->id;
		$praktikumdosennonaktif->save();

		PraktikumDosenNonaktif::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

}
