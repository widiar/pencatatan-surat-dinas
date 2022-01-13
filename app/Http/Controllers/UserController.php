<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $datas = User::where('is_superadmin', 0)->get();
        return view('user.index', compact('datas'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);
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
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
