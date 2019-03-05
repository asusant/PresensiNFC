<?php
namespace App\Modules\Contents\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Contents\Models\Contents;
use Yajra\Datatables\Datatables;
use App\Models\Content;
use App\Models\Log;
use DB;
use Form;

class ContentsController extends Controller
{
	protected $slug = 'contents';
	protected $module = 'Contents';
	protected $title = "Contents";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$this->column_title = array('Section', 'Content', 'Created By');
		$this->ajax_field = array(['section', 'content', 'created_by'], [0,1]);
		$this->validation = array(
			'section' => 'required|string|max:191',
			'content' => 'required|string|max:191',
		);
		$this->create_form = array(
			'section' =>	Form::text('section', old('section'), ['class' => 'form-control', 'placeholder' => 'Contoh: site-name', ] ),
			'content' =>	Form::text('content', old('content'), ['class' => 'form-control', 'placeholder' => 'Contoh: MidnightBase', ] ),
		);
		$this->update_form = array(
			'section' =>	Form::text('section', old('section'), ['class' => 'form-control', 'placeholder' => 'Contoh: site-name', 'id' => 'section'] ),
			'content' =>	Form::text('content', old('content'), ['class' => 'form-control', 'placeholder' => 'Contoh: MidnightBase', 'id' => 'content'] ),
		);
	}

	public function index()
	{
		$data['contents'] = Contents::all();
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

		return view('Contents::contents', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));


		$data =  Contents::leftJoin('users', 'contents.created_by', 'users.id')
							->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'contents.id',
							'contents.section',
							'contents.content',
							'users.name as created_by',
							'contents.created_at'
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('contents', 'contents $1')
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

		$contents = new Contents();

		$contents->section = $request->input('section');
		$contents->content = $request->input('content');
		$contents->created_by = Auth::user()->id;

		$contents->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['contents'] = Contents::find($id)->toJson();

	}

	public function postUpdate(Request $request)
	{
		$this->validate($request, $this->validation);

		$contents = Contents::find($request->input('edit_id'));

		$contents->section = $request->input('section');
		$contents->content = $request->input('content');
		$contents->updated_by = Auth::user()->id;

		$contents->save();

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		$contents = Contents::find($id);
		$contents->deleted_by = Auth::user()->id;
		$contents->save();

		Contents::destroy($id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

}
