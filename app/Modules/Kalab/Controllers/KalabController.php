<?php
namespace App\Modules\Kalab\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Kalab\Models\Kalab;
use Yajra\Datatables\Datatables;
use App\Models\UserLevel;
use App\Models\Content;
use App\Models\Level;
use App\Models\Log;
use App\User;
use DB;
use Form;

class KalabController extends Controller
{
	protected $slug = 'kalab';
	protected $module = 'Kalab';
	protected $title = "Kalab";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$this->column_title = array('Nama Kepala Lab', 'NIP', 'Username', 'Email', 'Alamat', 'Nomor HP');
		$this->ajax_field = array(['nama', 'nip', 'username', 'email', 'alamat', 'phone'], [0,1,2,3,4,5]);
		$this->validation = array(
			'nama' => 'required|string|max:100',
			'nip' => 'required|numeric',
			'email' => 'required|email',
			'phone' => 'required|numeric',
			'alamat' => 'required|string',
		);
		$this->create_form = array(
			'Nama' => Form::text('nama', old('nama'), ['class' => 'form-control', 'placeholder' => 'Contoh: Sukarto S.Pd., M.Pd.', ] ),
			'NIP' => Form::number('nip', old('nip'), ['class' => 'form-control', 'placeholder' => 'Contoh: 112132450048465', ] ),
			'Username' => Form::text('username', old('username'), ['class' => 'form-control', 'placeholder' => 'Contoh: sukarto', ] ),
			'Email' => Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Contoh: sukarto@mail.com', ] ),
			'Alamat' => Form::textarea('alamat', old('alamat'), ['class' => 'form-control', 'placeholder' => 'Contoh: Jl. HR. Hardijanto No. 6', 'rows' => '5'] ),
			'Password' => Form::password('password', ['class' => 'form-control', 'placeholder' => 'Login Password', ] ),
			'Confirm Password' => Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Retype Password', ] ),
			'Nomor HP' => Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => 'Contoh: 081234567890', ] ),
		);
		$this->update_form = array(
			'Nama' => Form::text('nama', old('nama'), ['class' => 'form-control', 'placeholder' => 'Contoh: Sukarto S.Pd., M.Pd.', 'id' => 'nama'] ),
			'NIP' => Form::number('nip', old('nip'), ['class' => 'form-control', 'placeholder' => 'Contoh: 112132450048465', 'id'=>'nip'] ),
			'Username' => Form::text('username', old('username'), ['class' => 'form-control', 'placeholder' => 'Contoh: sukarto', 'id'=>'username'] ),
			'Email' => Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Contoh: sukarto@mail.com', 'id' => 'email'] ),
			'Alamat' => Form::textarea('alamat', old('alamat'), ['class' => 'form-control', 'placeholder' => 'Contoh: Jl. HR. Hardijanto No. 6', 'id' => 'alamat', 'rows' => '5'] ),
			'Password' => Form::password('password', ['class' => 'form-control', 'placeholder' => 'Login Password or Empty', 'id'=>'password'] ),
			'Confirm Password' => Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Retype Password or Empty', 'id'=>'password_confirmation'] ),
			'Nomor HP' => Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => 'Contoh: 081234567890', 'id'=>'phone'] ),
		);
	}

	public function index()
	{
		$data['kalab'] = Kalab::all();
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

		return view('Kalab::kalab', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data =  Kalab::leftJoin('users', 'kalab.id_user', 'users.id')
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'users.id as id',
							'kalab.id as id_kalab',
							'users.name as nama',
							'users.phone as phone',
							'users.username as username',
							'kalab.email as email',
							'kalab.alamat as alamat',
							'kalab.nip as nip'
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('kalab', 'kalab $1')
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
		$this->validation['username'] = 'required|string|max:50|unique:users,username';
		$this->validation['password'] = 'required|string|min:6|confirmed';
		$this->validate($request, $this->validation);

		// Add User
		// 
        $addedUser = new User;

        $addedUser->name = $request->input('nama');
        $addedUser->username = $request->input('username');
        $addedUser->password = bcrypt($request->input('password'));
        $addedUser->phone = $request->input('phone');

        $addedUser->save();

        // Add Level
        // id_level_kalab = 3  {!!!!! DILARANG DIUBAH DARI DATABASE !!!!!}
        // 
        $userLevels = new UserLevel;
    	$userLevels->id_user = $addedUser->id;
    	$userLevels->id_level = 3;
    	$userLevels->save();

    	// Add Kalab
    	//
		$kalab = new Kalab();

		$kalab->id_user = $addedUser->id;
		$kalab->nip = $request->input('nip');
		$kalab->email = $request->input('email');
		$kalab->alamat = $request->input('alamat');
		$kalab->created_by = Auth::user()->id;

		$kalab->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['kalab'] = Kalab::leftJoin('users', 'kalab.id_user', 'users.id')
									->where('users.id', $id)
									->first([
										'users.id as id',
										'users.name as nama',
										'users.phone as phone',
										'users.username as username',
										'kalab.email as email',
										'kalab.nip as nip',
										'kalab.alamat as alamat'
									])
									->toJson();

	}

	public function postUpdate(Request $request)
	{
		if (null !== $request->input('password')) {
			$this->validation['password'] = 'required|string|min:6|confirmed';
		}

		$this->validate($request, $this->validation);

		// Update User
		// 
		$user = User::find($request->input('edit_id'));

		$user->name = $request->input('nama');
        $user->username = $request->input('username');
        $user->phone = $request->input('phone');

        if (null !== $request->input('password')) {
			$user->password = bcrypt($request->input('password'));
        }

        $user->save();

		// Update Kalab
        // 
		$update['nip'] = $request->input('nip');
		$update['email'] = $request->input('email');
		$update['alamat'] = $request->input('alamat');
		$update['updated_by'] = Auth::user()->id;

		Kalab::where('id_user', $user->id)->update($update);

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		// Delete User
		// 
		User::destroy($id);
		UserLevel::where('id_user', $id)->delete();

		$kalab = Kalab::where('id_user', $id)->first();
		$kalab->deleted_by = Auth::user()->id;
		$kalab->save();

		Kalab::destroy($kalab->id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

}
