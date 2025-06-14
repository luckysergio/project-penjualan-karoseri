<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::with('user')->get();
        return view('pages-admin.pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pages-admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp'    => 'required',
            'instansi' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role_id'  => 3,
            ]);

            Pelanggan::create([
                'user_id'  => $user->id,
                'no_hp'    => $request->no_hp,
                'instansi' => $request->instansi,
            ]);
        });

        return back()->with('success', 'Data pelanggan berhasil dibuat');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::with('user')->findOrFail($id);
        return view('pages-admin.pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $user = $pelanggan->user;

        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'no_hp'    => 'required',
            'instansi' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $user, $pelanggan) {
            $user->update([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);

            $pelanggan->update([
                'no_hp'    => $request->no_hp,
                'instansi' => $request->instansi,
            ]);
        });

        return back()->with('success', 'Data pelanggan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $user = $pelanggan->user;

        DB::transaction(function () use ($pelanggan, $user) {
            $pelanggan->delete();
            $user->delete(); // ikut hapus akun user
        });

        return back()->with('success', 'Data pelanggan berhasil dihapus');
    }

    public function profileView()
    {
        $user = Auth::user();
        $pelanggan = Pelanggan::where('user_id', $user->id)->first();

        return view('profile', compact('pelanggan', 'user'));
    }

    public function profileupdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'no_hp' => 'nullable|string|max:255',
            'instansi' => 'nullable|string|max:255',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->id != $id) {
            abort(403, 'Unauthorized action.');
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save(); // ini sudah dikenali sekarang

        Pelanggan::updateOrCreate(
            ['user_id' => $user->id],
            [
                'no_hp' => $request->input('no_hp'),
                'instansi' => $request->input('instansi'),
            ]
        );

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
