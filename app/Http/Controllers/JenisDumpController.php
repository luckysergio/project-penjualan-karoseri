<?php

namespace App\Http\Controllers;

use App\Models\JenisDump;
use Illuminate\Http\Request;

class JenisDumpController extends Controller
{
    public function index()
    {
        $jenis_dumps = JenisDump::all();
        return view('pages-admin.jenisdump.index',[
            'jenis_dumps' => $jenis_dumps,
        ]);
    }

    public function create()
    {
        return view('pages-admin.jenisdump.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'deskripsi' => ['required', 'string', 'max:255']
        ]);

        JenisDump::create($validatedData);
        return redirect('/jenis/create')->with('success', 'Data berhasil ditambah');
    }

    public function edit($id)
    {
        $jenis_dump = JenisDump::findOrFail($id);
        return view('pages-admin.jenisdump.edit',[
            'jenis_dump' => $jenis_dump,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'deskripsi' => ['required', 'string', 'max:255']
        ]);

        $jenis_dump = JenisDump::findOrFail($id);

        $jenis_dump->update($validated);

        return back()->with('success', 'Jenis berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jenis_dump = JenisDump::findOrFail($id);
        $jenis_dump->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function home()
    {
        $jenis_dumps = JenisDump::latest()->take(12)->get();
        return view('home', compact('jenis_dumps'));
    }
}
