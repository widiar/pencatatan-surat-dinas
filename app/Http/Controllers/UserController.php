<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Berkunjung;
use App\Models\LaporanDinas;
use App\Models\Perjalanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('username', $request->username)->first();
        $cre = [
            'username' => $request->username,
            'password' => $request->password
        ];
        if (Auth::attempt($cre)) {
            if ($user) {
                return redirect()->route('index');
            }
        } else {
            return redirect()->route('login')->with('error', 'Username atau Password anda salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function index()
    {
        $this->authorize('view', User::class);
        $datas = User::where('is_superadmin', 0)->get();
        return view('user.index', compact('datas'));
    }

    public function create()
    {
        $this->authorize('create', User::class);
        return view('user.create');
    }

    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);
        $user = User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);
        $avatar = $request->avatar;
        if($avatar){
            $avatar->storeAs('public/profile/avatar', $avatar->hashName());
            $user->avatar = $avatar->hashName();
        }
        $user->save();
        if(isset($request->permission)) {
            foreach($request->permission as $perm) {
                $user->permission()->create([
                    'permission' => $perm
                ]);
            }
        }
        return redirect()->route('user.index')->with('success', 'Data berhasil ditambah');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = User::with('permission')->find($id);
        $this->authorize('edit', $data);
        if($data->is_superadmin == 1) abort(403);
        // dd($data->permission->toArray());
        $permission = [];
        if($data->permission) {
            foreach($data->permission as $per) {
                array_push($permission, $per->permission);
            }
        }
        // dd($permission);
        return view('user.edit', compact('data', 'permission'));
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::with('permission')->find($id);
        $this->authorize('edit', $user);
        $user->name = $request->nama;
        $user->username = $request->username;
        $avatar = $request->avatar;
        if($avatar){
            if($user->avatar) {
                Storage::disk('public')->delete('profile/avatar/' . $user->avatar);
            }
            $avatar->storeAs('public/profile/avatar', $avatar->hashName());
            $user->avatar = $avatar->hashName();
        }
        $user->save();
        $permission = [];
        if($user->permission) {
            foreach($user->permission as $per) {
                array_push($permission, $per->permission);
            }
        }
        $deleted = array_diff($permission, $request->permission);
        if(count($deleted) > 0) {
            foreach($deleted as $del) {
                $user->permission()->where('permission', $del)->delete();
            }
        }
        $added = array_diff($request->permission, $permission);
        if(count($added) > 0) {
            foreach($added as $add) {
                $user->permission()->create([
                    'permission' => $add
                ]);
            }
        }
        return redirect()->route('user.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        if($user->is_superadmin) abort(403);
        if($user->avatar) {
            Storage::disk('public')->delete('profile/avatar/' . $user->avatar);
        }
        $user->delete();
        return response()->json('Sukses');
    }

    public function dashboard()
    {
        $surat = Perjalanan::all()->count();
        $dinas = LaporanDinas::all()->count();
        $kunjungan = Berkunjung::all()->count();
        return view('index', compact('surat', 'dinas', 'kunjungan'));
    }

    public function updateProfile()
    {
        $data = User::find(Auth::user()->id);
        return view('user.updateProfile', compact('data'));
    }

    public function postProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $cek = User::where('username', $request->username)->where('id', '!=', $user->id)->count();
        if($cek > 0) return redirect()->route('update.profile')->with('error', 'Username already taken')->withInput();
        $user->name = $request->nama;
        $user->username = $request->username;
        $avatar = $request->avatar;
        if($avatar){
            if($user->avatar) {
                Storage::disk('public')->delete('profile/avatar/' . $user->avatar);
            }
            $avatar->storeAs('public/profile/avatar', $avatar->hashName());
            $user->avatar = $avatar->hashName();
        }
        $user->save();
        return redirect()->route('update.profile')->with('success', 'Berhasil ubah profile');
    }

    public function changePassword(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if(Hash::check($request->oldpassword, $user->password)){
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('update.profile')->with('success', 'Berhasil ubah password');
        } else {
            return redirect()->route('update.profile')->with('error-pw', 'Password lama salah');
        }
    }
}
