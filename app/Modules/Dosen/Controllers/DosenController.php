<?php
namespace App\Modules\Dosen\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Dosen\Models\Dosen;
use Yajra\Datatables\Datatables;
use App\Models\UserLevel;
use App\Models\Content;
use App\Models\Level;
use App\Models\Log;
use App\User;
use DB;
use Form;

class DosenController extends Controller
{
	protected $slug = 'dosen';
	protected $module = 'Dosen';
	protected $title = "Dosen";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;

	public function __construct()
	{
		$this->column_title = array('ID Dosen','Nama Dosen', 'NIP', 'Username', 'Email', 'Alamat', 'Nomor HP');
		$this->ajax_field = array(['id','nama', 'nip', 'username', 'email', 'alamat', 'phone'], [1,2,3,4,5,6]);
		$this->validation = array(
			'nama' => 'required|string|max:100',
			'nip' => 'required|numeric',
			'email' => 'required|email',
			'phone' => 'required|numeric',
			'alamat' => 'required|string',
		);
		$this->create_form = array(
			'Nama' => Form::text('nama', old('nama'), ['class' => 'form-control', 'placeholder' => 'Contoh: Sukaryo S.Pd., M.Pd.', ] ),
			'NIP' => Form::number('nip', old('nip'), ['class' => 'form-control', 'placeholder' => 'Contoh: 112132450048465', ] ),
			'Username' => Form::text('username', old('username'), ['class' => 'form-control', 'placeholder' => 'Contoh: sukaryo', ] ),
			'Email' => Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Contoh: sukaryo@mail.com', ] ),
			'Alamat' => Form::textarea('alamat', old('alamat'), ['class' => 'form-control', 'placeholder' => 'Contoh: Jl. HR. Hardijanto No. 6', 'rows' => '5'] ),
			'Password' => Form::password('password', ['class' => 'form-control', 'placeholder' => 'Login Password', ] ),
			'Confirm Password' => Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Retype Password', ] ),
			'Nomor HP' => Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => 'Contoh: 081234567890', ] ),
		);
		$this->update_form = array(
			'Nama' => Form::text('nama', old('nama'), ['class' => 'form-control', 'placeholder' => 'Contoh: Sukaryo S.Pd., M.Pd.', 'id' => 'nama'] ),
			'NIP' => Form::number('nip', old('nip'), ['class' => 'form-control', 'placeholder' => 'Contoh: 112132450048465', 'id'=>'nip'] ),
			'Username' => Form::text('username', old('username'), ['class' => 'form-control', 'placeholder' => 'Contoh: sukaryo', 'id'=>'username'] ),
			'Email' => Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Contoh: sukaryo@mail.com', 'id' => 'email'] ),
			'Alamat' => Form::textarea('alamat', old('alamat'), ['class' => 'form-control', 'placeholder' => 'Contoh: Jl. HR. Hardijanto No. 6', 'id' => 'alamat', 'rows' => '5'] ),
			'Password' => Form::password('password', ['class' => 'form-control', 'placeholder' => 'Login Password or Empty', 'id'=>'password'] ),
			'Confirm Password' => Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Retype Password or Empty', 'id'=>'password_confirmation'] ),
			'Nomor HP' => Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => 'Contoh: 081234567890', 'id'=>'phone'] ),
		);
	}

	public function index()
	{
		$data['dosen'] = Dosen::all();
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

		return view('Dosen::dosen', $data);
	}

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data =  Dosen::leftJoin('users', 'dosen.id_user', 'users.id')
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'users.id as id',
							'dosen.id as id_dosen',
							'users.name as nama',
							'users.phone as phone',
							'users.username as username',
							'dosen.email as email',
							'dosen.alamat as alamat',
							'dosen.nip as nip'
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('dosen', 'dosen $1')
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

				return $update.$delete.$validate;
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
        // id_level_dosen = 4  {!!!!! DILARANG DIUBAH DARI DATABASE !!!!!}
        //
        $userLevels = new UserLevel;
    	$userLevels->id_user = $addedUser->id;
    	$userLevels->id_level = 4;
    	$userLevels->save();

    	// Add Dosen
    	//
		$dosen = new Dosen();

		$dosen->id_user = $addedUser->id;
		$dosen->nip = $request->input('nip');
		$dosen->email = $request->input('email');
		$dosen->alamat = $request->input('alamat');
		$dosen->created_by = Auth::user()->id;

		$dosen->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['dosen'] = Dosen::leftJoin('users', 'dosen.id_user', 'users.id')
									->where('users.id', $id)
									->first([
										'users.id as id',
										'users.name as nama',
										'users.phone as phone',
										'users.username as username',
										'dosen.email as email',
										'dosen.nip as nip',
										'dosen.alamat as alamat'
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

		// Update Dosen
        //
		$update['nip'] = $request->input('nip');
		$update['email'] = $request->input('email');
		$update['alamat'] = $request->input('alamat');
		$update['updated_by'] = Auth::user()->id;

		Dosen::where('id_user', $user->id)->update($update);

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		// Delete User
		//
		User::destroy($id);
		UserLevel::where('id_user', $id)->delete();

		$dosen = Dosen::where('id_user', $id)->first();
		$dosen->deleted_by = Auth::user()->id;
		$dosen->save();

		Dosen::destroy($dosen->id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

}
