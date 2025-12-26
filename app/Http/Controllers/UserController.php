<?php

namespace App\Http\Controllers;

use App\Models\AksesMenu;
use App\Models\AksesProses;
use App\Models\JenisUser;
use App\Models\Menu;
use App\Models\Proses;
use App\Models\Role;
use App\Models\Seksi;
use App\Models\Submenu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index', [
            'title' => 'User',
            'user' => User::all(),
        ]);
    }

    // public function getDataUser()
    // {
    //     $dt_user = User::query()->orderBy('role_id','ASC')->with(['role']);
    //     return datatables()->of($dt_user)
    //                     ->addColumn('action', function($data){
    //                         $button = '<button type="button" class="btn btn-sm btn-primary edit_user" data-bs-toggle="modal" data-bs-target="#modal_edit_user" user_id="'.$data->id.'"><i class="bx bx-cloud-upload"></i></button>';
    //                         $button .= '&nbsp;&nbsp;';   
    //                         return $button;
    //                     })
    //                     ->rawColumns(['action'])        
    //                     ->addIndexColumn()
    //                     ->make(true);
    // }

    public function addUser()
    {
        $validator = request()->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'confirmed'],
                'role' => ['required'],
            ],
            [
                'name.required' => 'Nama tidak boleh kosong',
                'name.string' => 'Nama hanya boleh hufuf dan angka',
                'name.max' => 'Nama maksimal 255 karakter',
                'username.required' => 'Username tidak boleh kosong',
                'username.string' => 'Username hanya boleh hufuf dan angka',
                'username.max' => 'Username maksimal 255 karakter',
                'username.unique' => 'Username yang sama sudah terdaftar',
                'password.required' => 'Password tidak boleh kosong',
                'password.string' => 'Password hanya boleh hufuf dan angka',
                'password.confirmed' => 'Password tidak sama',
                'role.required' => 'Role harus diisi',

            ]
        );


        // if ($validator->fails())
        // {
        //     return response()->json(['errors'=>$validator->errors()->all()]);
        // }

        $user = User::create([
            'name' => request('name'),
            'username' => request('username'),
            'password' => bcrypt(request('password')),
            'role' => request('role'),
            'aktif' => 1,
        ]);



        return redirect()->back()->with('success', 'Data user berhasil dibuat');
    }

    public function gantiPassword()
    {
        return view('user.ganti_password', [
            'title' => 'Ganti Password'
        ]);
    }

    public function editPassword(Request $request)
    {
        if (!(Hash::check($request->old_password, Auth::user()->password))) {
            return redirect(route('gantiPassword'))->with('error', 'Password saat ini tidak cocok');
        }
        $validator = request()->validate(
            [
                'password' => ['required', 'string', 'confirmed'],
                'old_password' => ['required']

            ],
            [
                'password.required' => 'Password tidak boleh kososng',
                'password.string' => 'Password hanya boleh hufuf dan angka',
                'password.confirmed' => 'Password tidak sama',
            ]
        );

        User::where('id', Auth::user()->id)->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect(route('gantiPassword'))->with('success', 'Password berhasil diganti');
    }

    public function getUser($id)
    {
        $data  = User::where('id', $id)->first();
        return response()->json($data);
    }

    public function editUser(Request $request)
    {
        User::where('id', $request->id)->update([
            'name' => $request->name,
            'role' => $request->role,
            'aktif' => $request->aktif,
        ]);


        return redirect()->back()->with('success', 'Data user berhasil diubah');
    }
}
