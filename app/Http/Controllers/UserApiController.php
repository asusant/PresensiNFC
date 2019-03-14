<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\UserLevel;
use App\Modules\Semester\Models\Semester;
use App\Modules\PresensiKuliah\Models\PertemuanKuliah;
use App\Modules\PresensiKuliah\Models\PresensiKuliah;
use App\Modules\PesertaKuliah\Models\PesertaKuliah;
use App\Modules\TipeKehadiran\Models\TipeKehadiran;
use App\Modules\MataKuliah\Models\MataKuliah;
use App\Modules\Mahasiswa\Models\Mahasiswa;
use App\Modules\Hari\Models\Hari;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\User;
use JWTAuthException;
use DB;

class UserApiController extends Controller
{   
    private $user;
    
    public function __construct(User $user){
        $this->user = $user;
    }
    
    public function login(Request $request){
        $credentials = $request->only('username', 'password');
        $token = null;
        $return['status'] = "success";
        try {
           if (!$token = JWTAuth::attempt($credentials)) {
            $return['message'] = "invalid_email_or_password";
            return response()->json($return, 422);
           }
        } catch (JWTAuthException $e) {
            $return['message'] = "failed_to_create_token";
            return response()->json($return, 500);
        }

        $user = JWTAuth::toUser($token);
        if (!UserLevel::isDosen($user->id)) {
            $return['message'] = "invalid_email_or_password";
            return response()->json($return, 422);
        }

        $return['status'] = "success";
        $return['message'] = "Login Successfully";
        DB::statement(DB::raw('set @path="'.asset('uploads').'"'));
        $return['data']['user'] = User::leftJoin('dosen', 'users.id', 'dosen.id_user')
                                        ->where('users.id', $user->id)
                                        ->get([
                                            'users.id',
                                            'users.name',
                                            'users.username',
                                            'users.phone',
                                            'dosen.nip',
                                            'dosen.alamat',
                                            'dosen.email',
                                            DB::raw('CONCAT(@path, "/", users.photo) as photo'),
                                        ])->first();
        $return['data']['token'] = $token;

        return response()->json($return);
    }

    public function getAuthUser(Request $request){
        return response()->json(JWTAuth::toUser($request->token));
        $user = JWTAuth::toUser($request->token);
        
        $return['status'] = "success";
        $return['message'] = "Data loaded successfully.";
        $return['data'] = User::leftJoin('dosen', 'users.id', 'dosen.id_user')
                                ->where('users.id', $user->id)
                                ->get([
                                    'users.id',
                                    'users.name',
                                    'users.username',
                                    'users.phone',
                                    'dosen.nip',
                                    'dosen.alamat',
                                    'dosen.email',
                                ])->first();

        return response()->json($return);
    }

    public function getMataKuliah(Request $request)
    {
        $user = JWTAuth::toUser($request->token);

        $return['status'] = "success";
        $return['message'] = "Data loaded successfully";

        $lastSemester = Semester::orderBy('id', 'desc')
                            ->get([
                                'id',
                                'semester',
                            ])->first();

        $return['data'] = MataKuliah::leftJoin('jurusan', 'mata_kuliah.id_jurusan', 'jurusan.id')
                                    ->leftJoin('dosen as dosen_1', 'mata_kuliah.id_user_dosen_1', 'dosen_1.id_user')
                                    ->leftJoin('users as user_1', 'mata_kuliah.id_user_dosen_1', 'user_1.id')
                                    ->leftJoin('dosen as dosen_2', 'mata_kuliah.id_user_dosen_2', 'dosen_2.id_user')
                                    ->leftJoin('users as user_2', 'mata_kuliah.id_user_dosen_2', 'user_2.id')
                                    ->leftJoin('ruang_kuliah', 'mata_kuliah.id_ruang_kuliah', 'ruang_kuliah.id')
                                    ->leftJoin('hari', 'mata_kuliah.id_hari', 'hari.id')
                                    ->where(function ($query) use ($user){
                                        $query->where('mata_kuliah.id_user_dosen_1', $user->id)
                                              ->orWhere('mata_kuliah.id_user_dosen_2', $user->id);
                                    })
                                    ->where('id_semester', $lastSemester->id)
                                    ->get([
                                        'mata_kuliah.id',
                                        'mata_kuliah.kode_makul',
                                        'mata_kuliah.nama_makul',
                                        'mata_kuliah.id_user_dosen_1',
                                        'mata_kuliah.id_user_dosen_2',
                                        'user_1.name as dosen_1',
                                        'user_2.name as dosen_2',
                                        'ruang_kuliah.ruang',
                                        'hari.hari',
                                        'mata_kuliah.waktu_mulai',
                                        'mata_kuliah.waktu_selesai',
                                    ]);

        return response()->json($return);

    }

    public function newPertemuan(Request $request) # {id_mata_kuliah}
    {
        $user = JWTAuth::toUser($request->token);

        $pertemuan = new PertemuanKuliah;
        $pertemuan->id_mata_kuliah = $request->id_mata_kuliah;
        $pertemuan->waktu_pertemuan = date('Y-m-d H-i-s');
        $pertemuan->created_by = $user->id;
        $pertemuan->save();

        $return['status'] = "success";
        $return['message'] = "Success";
        $return['data'] = $pertemuan;

        return response()->json($return);
    }

    public function checkPresensi($id_pertemuan_kuliah, $id_user)
    {
        if (PresensiKuliah::where('id_pertemuan_kuliah', $id_pertemuan_kuliah)
                            ->where('id_user_mahasiswa', $id_user)->count() > 0){
            return true;
        }
        return false;
    }

    public function insertPresensi(Request $request) # {id, nim, id_tipe_kehadiran, kehadiran = null, keterangan = null}
    {
        $pertemuan = PertemuanKuliah::find($request->id);

        $mhs = Mahasiswa::leftJoin('peserta_kuliah', 'mahasiswa.id_user', 'peserta_kuliah.id_user_mahasiswa')->where('mahasiswa.nim', $request->nim)->where('peserta_kuliah.id_mata_kuliah', $pertemuan->id_mata_kuliah)->get(['mahasiswa.id_user'])->first();

        if (!$mhs) {
            $return['status'] = "failed";
            $return['message'] = "Mahasiswa tidak terdaftar.";
            
            return response()->json($return);
        }

        if ($this->checkPresensi($request->id, $mhs->id_user)) {
            $return['status'] = "failed";
            $return['message'] = "Presensi already inserted.";
            $return['data'] = "";

            return response()->json($return);
        }

        $user = JWTAuth::toUser($request->token);

        $presensi = new PresensiKuliah;
        $presensi->id_pertemuan_kuliah = $request->id;
        $presensi->id_user_mahasiswa = $mhs->id_user;
        $presensi->id_tipe_kehadiran = 1; # hadir
        if ($request->kehadiran) {
            if ($request->kehadiran == "A") {
                $presensi->id_tipe_kehadiran = 4; # alpa
            }elseif ($request->kehadiran == "S") {
                $presensi->id_tipe_kehadiran = 2; # sakit
            }elseif ($request->kehadiran == "I") {
                $presensi->id_tipe_kehadiran = 2; # izin
            }
        }
        $presensi->keterangan = "-";
        if (isset($request->keterangan) && $request->keterangan) {
            $presensi->keterangan = $request->keterangan;
        }
        $presensi->created_by = $user->id;
        $presensi->save();

        $return['status'] = "success";
        $return['message'] = "Presensi successfully added.";
        $return['data'] = $presensi;

        return response()->json($return);
    }

    public function getSudahPresensi(Request $request) # {id_pertemuan_kuliah}
    {
        $id_pertemuan_kuliah = $request->id_pertemuan_kuliah;
        $pertemuan = PertemuanKuliah::find($id_pertemuan_kuliah);
        $makul = MataKuliah::where('id', $pertemuan->id_mata_kuliah)->first();

        $return['status'] = "success";
        $return['message'] = "Data loaded successfully.";
        $return['data'] = PesertaKuliah::leftJoin('users', 'peserta_kuliah.id_user_mahasiswa', 'users.id')
                                            ->leftJoin('mahasiswa', 'peserta_kuliah.id_user_mahasiswa', 'mahasiswa.id_user')
                                            ->leftJoin('presensi_kuliah', function($join) use ($id_pertemuan_kuliah) {
                                                $join->on('peserta_kuliah.id_user_mahasiswa', 'presensi_kuliah.id_user_mahasiswa')
                                                    ->where('presensi_kuliah.id_pertemuan_kuliah', $id_pertemuan_kuliah)
                                                    ->groupBy('presensi_kuliah.id_user_mahasiswa');
                                            })
                                            ->where('id_mata_kuliah', $makul->id)
                                            ->whereNull('presensi_kuliah.deleted_at')
                                            ->whereNotNull('presensi_kuliah.id')
                                            ->get([
                                                'users.id',
                                                'mahasiswa.nim',
                                                'users.name as nama_mahasiswa',
                                                DB::raw('date_format(presensi_kuliah.created_at, "%H:%i") as waktu_presensi')
                                            ]);

        return response()->json($return);
    }

    public function getBelumPresensi(Request $request) # {id_pertemuan_kuliah}
    {
        $id_pertemuan_kuliah = $request->id_pertemuan_kuliah;
        $pertemuan = PertemuanKuliah::find($id_pertemuan_kuliah);
        $makul = MataKuliah::where('id', $pertemuan->id_mata_kuliah)->first();

        $return['status'] = "success";
        $return['message'] = "Data loaded successfully.";
        $return['data'] = PesertaKuliah::leftJoin('users', 'peserta_kuliah.id_user_mahasiswa', 'users.id')
                                            ->leftJoin('mahasiswa', 'peserta_kuliah.id_user_mahasiswa', 'mahasiswa.id_user')
                                            ->leftJoin('presensi_kuliah', function($join) use ($id_pertemuan_kuliah) {
                                                $join->on('peserta_kuliah.id_user_mahasiswa', 'presensi_kuliah.id_user_mahasiswa')
                                                    ->where('presensi_kuliah.id_pertemuan_kuliah', $id_pertemuan_kuliah)
                                                    ->groupBy('presensi_kuliah.id_user_mahasiswa');
                                            })
                                            ->where('id_mata_kuliah', $makul->id)
                                            ->whereNull('presensi_kuliah.deleted_at')
                                            ->whereNull('presensi_kuliah.id')
                                            ->get([
                                                'users.id',
                                                'mahasiswa.nim',
                                                'users.name as nama_mahasiswa',
                                                DB::raw('date_format(presensi_kuliah.created_at, "%H:%i") as waktu_presensi')
                                            ]);

        return response()->json($return);
    }

    public function selesaiPresensi(Request $request) # {id_pertemuan_kuliah}
    {
        $user = JWTAuth::toUser($request->token);
        
        $id_pertemuan_kuliah = $request->id_pertemuan_kuliah;
        $pertemuan = PertemuanKuliah::find($id_pertemuan_kuliah);
        $makul = MataKuliah::where('id', $pertemuan->id_mata_kuliah)->first();

        $belum = PesertaKuliah::leftJoin('users', 'peserta_kuliah.id_user_mahasiswa', 'users.id')
                                ->leftJoin('mahasiswa', 'peserta_kuliah.id_user_mahasiswa', 'mahasiswa.id_user')
                                ->leftJoin('presensi_kuliah', function($join) use ($id_pertemuan_kuliah) {
                                    $join->on('peserta_kuliah.id_user_mahasiswa', 'presensi_kuliah.id_user_mahasiswa')
                                        ->where('presensi_kuliah.id_pertemuan_kuliah', $id_pertemuan_kuliah)
                                        ->groupBy('presensi_kuliah.id_user_mahasiswa');
                                })
                                ->where('id_mata_kuliah', $makul->id)
                                ->whereNull('presensi_kuliah.deleted_at')
                                ->whereNull('presensi_kuliah.id')
                                ->get([
                                    'users.id as id_user_mahasiswa',
                                ]);

        # {id_pertemuan_kuliah, id_user_mahasiswa, id_tipe_kehadiran, keterangan = null}
        # 
        foreach ($belum as $key => $row) {
            $presensi = new PresensiKuliah;
            $presensi->id_pertemuan_kuliah = $id_pertemuan_kuliah;
            $presensi->id_user_mahasiswa = $row->id_user_mahasiswa;
            $presensi->id_tipe_kehadiran = 4; # Alpa
            $presensi->keterangan = "-";
            $presensi->created_by = $user->id;
            $presensi->save();
        }

        $return['status'] = "success";
        $return['message'] = "Presensi Complete.";
        $return['data'] = "";

        return response()->json($return);
    }

    public function getTipeKehadiran(Request $request)
    {
        $return['status'] = "success";
        $return['message'] = "Data loaded successfully.";
        $return['data'] = TipeKehadiran::get([
                                            'id',
                                            'alias',
                                            'tipe',
                                        ]);

        return response()->json($return);
    }

    public function getHari(Request $request)
    {
        $return['status'] = "success";
        $return['message'] = "Data loaded successfully.";
        $return['data'] = Hari::get([
                                    'id',
                                    'hari',
                                ]);

        return response()->json($return);
    }
}  