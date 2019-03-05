<?php
namespace App\Modules\Mahasiswa\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Mahasiswa\Models\Mahasiswa;
use App\Modules\Kalab\Models\Kalab;
use App\Modules\Jurusan\Models\Jurusan;
use Yajra\Datatables\Datatables;
use App\Models\UserLevel;
use App\Models\Content;
use App\Models\Level;
use App\Models\Log;
use App\User;
use DB;
use Form;
use Session;
use Excel;
use File;

class MahasiswaController extends Controller
{
	protected $slug = 'mahasiswa';
	protected $module = 'Mahasiswa';
	protected $title = "Mahasiswa";

	protected $column_title;
	protected $ajax_field;
	protected $validation;
	protected $create_form;
	protected $update_form;
	protected $upload_form;

	public function __construct()
	{
		$jurusan = Jurusan::pluck('jurusan', 'id')->toArray();
		$this->column_title = array('Nama Mahasiswa', 'NIM', 'Jurusan', 'Username', 'Email', 'Alamat', 'Nomor HP');
		$this->ajax_field = array(['nama', 'nim', 'id_jurusan', 'username', 'email', 'alamat', 'phone'], [0,1,2,3,4,5,6]);
		$this->validation = array(
			'nama' => 'required|string|max:100',
			'id_jurusan' => 'required|exists:jurusan,id',
			'nim' => 'required|numeric',
			'email' => 'required|email',
			'phone' => 'required|numeric',
			'alamat' => 'required|string',
		);
		$this->create_form = array(
			'Nama' => Form::text('nama', old('nama'), ['class' => 'form-control', 'placeholder' => 'Contoh: Victor Sukarto', ] ),
			'Jurusan'	=> Form::select('id_jurusan', $jurusan, old('jurusan'), ['class' => 'form-control', 'placeholder' => '---Pilih Jurusan---', ]),
			'NIM' => Form::number('nim', old('nim'), ['class' => 'form-control', 'placeholder' => 'Contoh: 4611414043', ] ),
			'Username' => Form::text('username', old('username'), ['class' => 'form-control', 'placeholder' => 'Contoh: victors', ] ),
			'Email' => Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Contoh: victors@mail.com', ] ),
			'Alamat' => Form::textarea('alamat', old('alamat'), ['class' => 'form-control', 'placeholder' => 'Contoh: Jl. HR. Hardijanto No. 7', 'rows' => '5'] ),
			'Password' => Form::password('password', ['class' => 'form-control', 'placeholder' => 'Login Password', ] ),
			'Confirm Password' => Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Retype Password', ] ),
			'Nomor HP' => Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => 'Contoh: 081234567890', ] ),
		);
		$this->update_form = array(
			'Nama' => Form::text('nama', old('nama'), ['class' => 'form-control', 'placeholder' => 'Contoh: Sukarto S.Pd., M.Pd.', 'id' => 'nama'] ),
			'Jurusan'	=> Form::select('id_jurusan', $jurusan, old('jurusan'), ['class' => 'form-control', 'placeholder' => '---Pilih Jurusan---', 'id' => 'id_jurusan']),
			'NIM' => Form::number('nim', old('nim'), ['class' => 'form-control', 'placeholder' => 'Contoh: 4611414043', 'id'=>'nim'] ),
			'Username' => Form::text('username', old('username'), ['class' => 'form-control', 'placeholder' => 'Contoh: victors', 'id'=>'username'] ),
			'Email' => Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Contoh: victors@mail.com', 'id' => 'email'] ),
			'Alamat' => Form::textarea('alamat', old('alamat'), ['class' => 'form-control', 'placeholder' => 'Contoh: Jl. HR. Hardijanto No. 7', 'id' => 'alamat', 'rows' => '5'] ),
			'Password' => Form::password('password', ['class' => 'form-control', 'placeholder' => 'New Password or Empty', 'id'=>'password'] ),
			'Confirm Password' => Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Retype Password or Empty', 'id'=>'password_confirmation'] ),
			'Nomor HP' => Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => 'Contoh: 081234567890', 'id'=>'phone'] ),
		);
		$this->upload_form = array(
			'Upload File' => Form::file('file', ['class' => 'form-control', ]),
		);
	}

	public function index()
	{
		$data['mahasiswa'] = Mahasiswa::all();
		$data['title'] = $this->title;
		$data['create_route'] = route($this->slug.'.post.create');
		$data['upload_route'] = route($this->slug.'.post.upload.create');
		$data['update_route'] = route($this->slug.'.post.update', ['id'=>null]);
		$data['delete_route'] = route($this->slug.'.delete', ['id'=>null]);
		$data['detail_route'] = route($this->slug.'.details.read', ['id'=>null]);
		$data['read_route'] = route($this->slug.'.get-data.read');
		$data['column_title'] = $this->column_title;
		$data['ajax_field'] = $this->ajax_field;
		$data['create_form'] = $this->create_form;
		$data['update_form'] = $this->update_form;
		$data['upload_form'] = $this->upload_form;

		$data['create_button'] = "";
		$data['upload_button'] = "";
		if(Content::menuPermission('create')){
			$data['create_button'] = '<button class="btn btn-sm btn-default" data-target="#add" data-toggle="modal">
											<i class="fa fa-plus" aria-hidden="true"></i>
											<span class="hidden-xs">Tambah '.$this->title.'</span>
										</button>';
			$data['upload_button'] = '<button class="btn btn-sm btn-default" data-target="#addUpload" data-toggle="modal">
											<i class="fa fa-plus" aria-hidden="true"></i>
											<span class="hidden-xs">Upload '.$this->title.'</span>
										</button>';
		}

		return view('Mahasiswa::mahasiswa', $data);
	}

	public function postUpload(Request $request){
	     //validate the xls file
	  $this->validate($request, array(
	   'file'      => 'required'
	  ));

	  if($request->hasFile('file')){
	   $extension = File::extension($request->file->getClientOriginalName());
	   if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

	    $path = $request->file->getRealPath();
	    $data = Excel::load($path, function($reader) {})->get();
	    if(!empty($data) && $data->count()){
		     foreach ($data as $key => $value) {
					 if($this->checkUser($value->nim)){
						 $idu = new User;
						 $idu->name = $value->nama;
						 $idu->username = $value->nim;
						 $idu->password = bcrypt($value->nim.'-17');
						 $idu->phone = $value->nomor_hp;
						 $idu->save();

						 $userLevels = new UserLevel;
						 $userLevels->id_user = $idu->id;
						 $userLevels->id_level = 5;
						 $userLevels->save();

						 $mahasiswa = new Mahasiswa();
						 $mahasiswa->id_user = $idu->id;
						 $mahasiswa->nim = $value->nim;
						 $mahasiswa->email = $value->email;
						 $mahasiswa->alamat = $value->alamat;
						 $mahasiswa->created_by = Auth::user()->id;
						 $mahasiswa->save();
					 }else{
						 Session::flash('message_danger', 'Mahasiswa '.$value->nim.' sudah ada.');
			 	    return back();
					 }

		     }
	    }
			Session::flash('message_sukses', 'Data berhasil diinput.');
	    return back();

	   }else {
	    Session::flash('message_danger', 'File is a '.$extension.' file.!! Please upload a valid xls/csv file..!!');
	    return back();
	   }
	  }
	 }

	 public function checkUser($nim)
	 {
	 		$nims = User::pluck('username')->toArray();
			// dd($nims);
			if(in_array($nim, $nims)){
				return false;
			}else{
				return true;
			}
	 }

	public function getData(Datatables $datatables, Request $request)
	{
		DB::statement(DB::raw('set @no=0'));

		$data =  Mahasiswa::leftJoin('users', 'mahasiswa.id_user', 'users.id')
						->leftJoin('jurusan', 'mahasiswa.id_jurusan', 'jurusan.id')
						->whereNull('users.deleted_at')
						->whereNull('jurusan.deleted_at')
						->get([
							DB::raw('@no  := @no  + 1 AS no'),
							'users.id as id',
							'mahasiswa.id as id_mahasiswa',
							'users.name as nama',
							'users.phone as phone',
							'users.username as username',
							'mahasiswa.email as email',
							'mahasiswa.alamat as alamat',
							'mahasiswa.nim as nim',
							'jurusan.jurusan as id_jurusan'
						]);

		$datatables = Datatables::of($data);
			if ($keyword = $request->get('search')['value']) {
					$datatables->filterColumn('no', 'whereRaw', '@no  + 1 like ?', ["%{$keyword}%"]);
			}

		return $datatables
			->orderColumn('mahasiswa', 'mahasiswa $1')
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
        // id_level_mahasiswa = 5  {!!!!! DILARANG DIUBAH DARI DATABASE !!!!!}
        //
        $userLevels = new UserLevel;
    	$userLevels->id_user = $addedUser->id;
    	$userLevels->id_level = 5;
    	$userLevels->save();

    	// Add Mahasiswa
    	//
		$mahasiswa = new Mahasiswa();

		$mahasiswa->id_user = $addedUser->id;
		$mahasiswa->id_jurusan = $request->input('id_jurusan');
		$mahasiswa->nim = $request->input('nim');
		$mahasiswa->email = $request->input('email');
		$mahasiswa->alamat = $request->input('alamat');
		$mahasiswa->created_by = Auth::user()->id;

		$mahasiswa->save();

		Log::aktivitas('Menambah '.$this->title.'.');

		return redirect()->back()->with('message_sukses', $this->title.' berhasil ditambahkan!');
	}

	public function details($id)
	{
		return $data['mahasiswa'] = Mahasiswa::leftJoin('users', 'mahasiswa.id_user', 'users.id')
									->leftJoin('jurusan', 'mahasiswa.id_jurusan', 'jurusan.id')
									->where('users.id', $id)
									->first([
										'users.id as id',
										'users.name as nama',
										'users.phone as phone',
										'users.username as username',
										'mahasiswa.email as email',
										'mahasiswa.nim as nim',
										'mahasiswa.alamat as alamat',
										'jurusan.id as id_jurusan'
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

		// Update Mahasiswa
        //
		$update['nim'] = $request->input('nim');
		$update['id_jurusan'] = $request->input('id_jurusan');
		$update['email'] = $request->input('email');
		$update['alamat'] = $request->input('alamat');
		$update['updated_by'] = Auth::user()->id;

		Mahasiswa::where('id_user', $user->id)->update($update);

		Log::aktivitas('Mengubah '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil diubah!');
	}

	public function delete($id)
	{
		// Delete User
		//
		User::destroy($id);
		UserLevel::where('id_user', $id)->delete();

		$mahasiswa = Mahasiswa::where('id_user', $id)->first();
		$mahasiswa->deleted_by = Auth::user()->id;
		$mahasiswa->save();

		Mahasiswa::destroy($mahasiswa->id);
		Log::aktivitas('Menghapus '.$this->title.'.');
		return redirect()->back()->with('message_sukses', $this->title.' berhasil dihapus!');
	}

}
