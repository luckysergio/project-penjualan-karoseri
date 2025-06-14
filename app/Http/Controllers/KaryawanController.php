<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('user')->get();
        return view('pages-admin.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('pages-admin.karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nik' => 'required|unique:karyawans,nik',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2,
            ]);

            Karyawan::create([
                'user_id' => $user->id,
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);
        });

        return back()->with('success', 'Data karyawan berhasil dibuat');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);
        return view('pages-admin.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $user = $karyawan->user;

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'nik' => 'required|unique:karyawans,nik,' . $karyawan->id,
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        DB::transaction(function () use ($request, $user, $karyawan) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);

            $karyawan->update([
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);
        });

        return back()->with('success', 'Data karyawan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $user = $karyawan->user;

        DB::transaction(function () use ($karyawan, $user) {
            $karyawan->delete();
            $user->delete(); // ikut hapus akun user
        });

        return back()->with('success', 'Data karyawan berhasil dihapus');
    }
}
