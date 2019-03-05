<?php
namespace App\Modules\Modul\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Modul\Models\Modul;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class ModulController extends Controller
{
	protected $slug = 'modul';
	protected $module = 'Modul';
	protected $title = "Modul";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$this->column_title = array('Nama Modul', 'File', 'Dibuat Pada', 'Dibuat Oleh');
		$this->ajax_field = array(['modul', 'file', 'created_at', 'created_by'], [0]);
		$this->validation = array(
			'modul' => 'required|string|max:191',
		);
		$this->create_form = array(
			'Nama Modul' =>	Form::text('modul', old('modul'), ['class' => 'form-control', 'placeholder' => 'Panduan Penggunaan Sistem Laboratorium', ] ),
			'File' =>	Form::file('file', ['class' => 'form-control', ] ),
		);
		$this->update_form = array(
			'modul' =>	Form::text('modul', old('modul'), ['class' => 'form-control', 'placeholder' => 'Panduan Penggunaan Sistem Laboratorium', 'id' => 'key'] ),
			'File' =>	Form::file('file', ['class' => 'form-control', ] ),
		);
	}

	public function index()
	{
		$data['modul'] = Modul::all();
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

		return view('Modul::modul', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data =  Modul::leftJoin('users', 'modul.created_by', 'users.id')
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'modul.id',
							'modul.modul',
							'modul.file',
							'modul.created_at',
							'users.name as created_by',
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('modul', 'modul $1')
			->editColumn('created_at', function ($data) {
				return Content::tanggal_indo($data->created_at, true);
			})
			->editColumn('file', function ($data){
				return '<a href="'.asset('uploads/'.$data->file).'" target="_blank" rel="noopener noreferrer" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> Download</a>';
			})
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
		$this->validation['file'] = 'required|mimes:pdf,doc,docx';
		$this->validate($request, $this->validation);

		$modul = new Modul();

		$filename = time().'.'.$request->file->getClientOriginalExtension();
		$request->file->move(public_path('uploads'), $filename);
		
		$modul->modul = $request->input('modul');
		$modul->file = $filename;
		$modul->created_by = Auth::user()->id;

		$modul->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['modul'] = Modul::find($id)->toJson();

	}

	public function postUpdate(Request $request)
	{
		$this->validation['file'] = 'nullable|mimes:pdf,doc,docx';
		$this->validate($request, $this->validation);

		$modul = Modul::find($request->input('edit_id'));

		if ($request->file) {
			$filename = time().'.'.$request->file->getClientOriginalExtension();
			$request->file->move(public_path('uploads'), $filename);
			$modul->file = $filename;
		}
		
		$modul->modul = $request->input('modul');
		$modul->updated_by = Auth::user()->id;

		$modul->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$modul = Modul::find($id);
		$modul->deleted_by = Auth::user()->id;
		$modul->save();

		Modul::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

}
