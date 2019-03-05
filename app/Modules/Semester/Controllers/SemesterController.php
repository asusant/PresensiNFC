<?php
namespace App\Modules\Semester\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Semester\Models\Semester;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class SemesterController extends Controller
{
	protected $slug = 'semester';
	protected $module = 'Semester';
	protected $title = "Semester";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$this->column_title = array('Semester', 'Dibuat Pada', 'Dibuat Oleh');
		$this->ajax_field = array(['semester', 'created_at', 'created_by'], [0]);
		$this->validation = array(
			'semester' => 'required|string|max:191',
		);
		$this->create_form = array(
			'semester' =>	Form::text('semester', old('semester'), ['class' => 'form-control', 'placeholder' => 'Contoh: Ganjil 2018/2019', ] ),
		);
		$this->update_form = array(
			'semester' =>	Form::text('semester', old('semester'), ['class' => 'form-control', 'placeholder' => 'Contoh: Ganjil 2018/2019', 'id' => 'semester'] ),
		);
	}

	public function index()
	{
		$data['semester'] = Semester::all();
		$data['title'] = $this->title;
		$data['create_route'] = route('configs.'.$this->slug.'.post.create');
		$data['update_route'] = route('configs.'.$this->slug.'.post.update', ['id'=>null]);
		$data['delete_route'] = route('configs.'.$this->slug.'.delete', ['id'=>null]);
		$data['detail_route'] = route('configs.'.$this->slug.'.details.read', ['id'=>null]);
		$data['read_route'] = route('configs.'.$this->slug.'.get-data.read');
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

		return view('Semester::semester', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data =  Semester::leftJoin('users', 'semester.created_by', 'users.id')
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'semester.id',
							'semester.created_at',
							'semester.semester',
							'users.name as created_by',
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('semester', 'semester $1')
			->editColumn('created_at', function ($data) {
				return Content::tanggal_indo($data->created_at, true);
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
		$this->validate($request, $this->validation);

		$semester = new Semester();

		$semester->semester = $request->input('semester');
		$semester->created_by = Auth::user()->id;

		$semester->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['semester'] = Semester::find($id)->toJson();

	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, $this->validation);

		$semester = Semester::find($request->input('edit_id'));

		$semester->semester = $request->input('semester');
		$semester->updated_by = Auth::user()->id;

		$semester->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$semester = Semester::find($id);
		$semester->deleted_by = Auth::user()->id;
		$semester->save();

		Semester::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

}
