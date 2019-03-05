<?php
namespace App\Modules\TipeKehadiran\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\TipeKehadiran\Models\TipeKehadiran;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class TipeKehadiranController extends Controller
{
	protected $slug = 'tipekehadiran';
	protected $module = 'TipeKehadiran';
	protected $title = "Tipe Kehadiran";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$this->column_title = array('Tipe Kehadiran', 'Simbol/Alias', 'CSS Class', 'Dibuat Oleh');
		$this->ajax_field = array(['tipe', 'alias', 'class', 'created_by'], [0,1]);
		$this->validation = array(
			'tipe' => 'required|string|max:191',
			'class' => 'required|string|max:20',
		);
		$this->create_form = array(
			'Tipe Kehadiran' =>	Form::text('tipe', old('tipe'), ['class' => 'form-control', 'placeholder' => 'Contoh: Sakit', ] ),
			'Simbol/Alias' =>	Form::text('alias', old('alias'), ['class' => 'form-control', 'placeholder' => 'Contoh: S', ] ),
			'CSS Class' =>	Form::text('class', old('class'), ['class' => 'form-control', 'placeholder' => 'Contoh: danger', ] ),
		);
		$this->update_form = array(
			'tipe' =>	Form::text('tipe', old('tipe'), ['class' => 'form-control', 'placeholder' => 'Contoh: Sakit', 'id' => 'tipe'] ),
			'Simbol/Alias' =>	Form::text('alias', old('alias'), ['class' => 'form-control', 'placeholder' => 'Contoh: S', 'id' => 'alias'] ),
			'CSS Class' =>	Form::text('class', old('class'), ['class' => 'form-control', 'placeholder' => 'Contoh: danger', 'id' => 'class'] ),
		);
	}

	public function index()
	{
		$data['tipekehadiran'] = TipeKehadiran::all();
		$data['title'] = $this->title;
		$data['create_route'] = route('configs.tipe-kehadiran.post.create');
		$data['update_route'] = route('configs.tipe-kehadiran.post.update', ['id'=>null]);
		$data['delete_route'] = route('configs.tipe-kehadiran.delete', ['id'=>null]);
		$data['detail_route'] = route('configs.tipe-kehadiran.details.read', ['id'=>null]);
		$data['read_route'] = route('configs.tipe-kehadiran.get-data.read');
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

		return view('TipeKehadiran::tipekehadiran', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data =  TipeKehadiran::leftJoin('users', 'tipe_kehadiran.created_by', 'users.id')
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'tipe_kehadiran.id',
							'tipe_kehadiran.alias',
							'tipe_kehadiran.tipe',
							'tipe_kehadiran.class',
							'users.name as created_by',
							'tipe_kehadiran.created_at'
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('tipekehadiran', 'tipekehadiran $1')
			->editColumn('created_at', function ($data) {
				return Content::tanggal_indo($data->created_at, true);
			})
			->editColumn('class', function ($data){
				return '<span class="label label-'.$data->class.'">'.$data->class.'</span>';
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
		$this->validation['alias'] = 'required|string|unique:tipe_kehadiran,alias';

		$this->validate($request, $this->validation);

		$tipekehadiran = new TipeKehadiran();

		$tipekehadiran->tipe = $request->input('tipe');
		$tipekehadiran->alias = $request->input('alias');
		$tipekehadiran->class = $request->input('class');

		$tipekehadiran->created_by = Auth::user()->id;

		$tipekehadiran->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['tipekehadiran'] = TipeKehadiran::find($id)->toJson();

	}

	public function postUpdate(Request $request)
	{
		$this->validation['alias'] = 'required|string';

		$this->validate($request, $this->validation);

		$tipekehadiran = TipeKehadiran::find($request->input('edit_id'));

		$tipekehadiran->tipe = $request->input('tipe');
		$tipekehadiran->alias = $request->input('alias');
		$tipekehadiran->class = $request->input('class');

		$tipekehadiran->updated_by = Auth::user()->id;

		$tipekehadiran->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$tipekehadiran = TipeKehadiran::find($id);
		$tipekehadiran->deleted_by = Auth::user()->id;
		$tipekehadiran->save();

		TipeKehadiran::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

}
