<?php
namespace App\Modules\Laboratorium\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Laboratorium\Models\Laboratorium;
use App\Modules\Kalab\Models\Kalab;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use App\User;
use DB;
use Form;

class LaboratoriumController extends Controller
{
	protected $slug = 'laboratorium';
	protected $module = 'Laboratorium';
	protected $title = "Laboratorium";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$kalab = Kalab::leftJoin('users', 'kalab.id_user', 'users.id')->pluck('users.name', 'users.id')->toArray();

		$this->column_title = array('ID Laboratorium','Nama Lab.', 'Lokasi', 'Maksimal Peserta', 'Kepala Lab.');
		$this->ajax_field = array(['id','laboratorium', 'lokasi', 'maks_peserta', 'id_user_kepala'], [1,2,3,4]);
		$this->validation = array(
			'laboratorium'	=> 'required|string|max:191',
			'lokasi' 		=> 'required|string|max:191',
			'maks_peserta' 	=> 'required|numeric',
			'kalab'			=> 'required|exists:users,id',
		);
		$this->create_form = array(
			'Laboratorium'		=> Form::text('laboratorium', old('laboratorium'), ['class' => 'form-control', 'placeholder' => 'Contoh: Lab. Multimedia 1', ] ),
			'Kepala Lab.' 		=> Form::select('kalab', $kalab, null, ['class' => 'form-control', 'placeholder' => '---Pilih Kalab---', ]),
			'Lokasi' 			=> Form::text('lokasi', old('lokasi'), ['class' => 'form-control', 'placeholder' => 'Contoh: Gedung Serba Guna Lt. 1', ] ),
			'Maksimal Peserta' 	=> Form::number('maks_peserta', old('maks_peserta'), ['class' => 'form-control', 'placeholder' => 'Contoh: 50', ] ),
		);
		$this->update_form = array(
			'Laboratorium'		=> Form::text('laboratorium', old('laboratorium'), ['class' => 'form-control', 'placeholder' => 'Contoh: Lab. Multimedia 1', 'id' => 'laboratorium'] ),
			'Kepala Lab.' 		=> Form::select('kalab', $kalab, null, ['class' => 'form-control', 'placeholder' => '---Pilih Kalab---', 'id' => 'id_user_kepala']),
			'Lokasi' 			=> Form::text('lokasi', old('lokasi'), ['class' => 'form-control', 'placeholder' => 'Contoh: Gedung Serba Guna Lt. 1', 'id' => 'lokasi'] ),
			'Maksimal Peserta' 	=> Form::number('maks_peserta', old('maks_peserta'), ['class' => 'form-control', 'placeholder' => 'Contoh: 50', 'id' => 'maks_peserta'] ),
		);
	}

	public function index()
	{
		$data['laboratorium'] = Laboratorium::all();
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

		return view('Laboratorium::laboratorium', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data =  Laboratorium::leftJoin('users', 'laboratorium.id_user_kepala', 'users.id')
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'laboratorium.id',
							'laboratorium.laboratorium',
							'laboratorium.lokasi',
							'laboratorium.maks_peserta',
							'users.name as id_user_kepala',
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('laboratorium', 'laboratorium $1')
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

	function postCreate(Request $request)
	{
		$this->validate($request, $this->validation);

		$laboratorium = new Laboratorium();

		$laboratorium->laboratorium = $request->input('laboratorium');
		$laboratorium->id_user_kepala = $request->input('kalab');
		$laboratorium->lokasi = $request->input('lokasi');
		$laboratorium->maks_peserta = $request->input('maks_peserta');
		$laboratorium->created_by = Auth::user()->id;

		$laboratorium->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['laboratorium'] = Laboratorium::find($id)->toJson();

	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, $this->validation);

		$laboratorium = Laboratorium::find($request->input('edit_id'));

		$laboratorium->laboratorium = $request->input('laboratorium');
		$laboratorium->id_user_kepala = $request->input('kalab');
		$laboratorium->lokasi = $request->input('lokasi');
		$laboratorium->maks_peserta = $request->input('maks_peserta');
		$laboratorium->updated_by = Auth::user()->id;

		$laboratorium->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$laboratorium = Laboratorium::find($id);
		$laboratorium->deleted_by = Auth::user()->id;
		$laboratorium->save();

		Laboratorium::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

}
