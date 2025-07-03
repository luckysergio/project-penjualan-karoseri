<?php

namespace App\Http\Controllers;

use App\Models\Chassis;
use App\Models\JenisDump;
use App\Models\product;
use App\Models\TypeDump;
use Illuminate\Http\Request;

class TypeDumpController extends Controller
{
    public function index()
    {
        $type_dumps = TypeDump::all();
        return view('pages-admin.typedump.index', [
            'type_dumps' => $type_dumps,
        ]);
    }

    public function create()
    {
        return view('pages-admin.typedump.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'kapasitas' => ['required', 'string', 'max:50'],
            'harga' => ['required'],
            'deskripsi' => ['required', 'string', 'max:250'],
        ]);

        $validated['harga'] = preg_replace('/[^0-9]/', '', $request->harga);

        TypeDump::create($validated);
        return back()->with('success', 'Data berhasil ditambah');
    }

    public function edit($id)
    {
        $type_dump = TypeDump::findOrFail($id);
        return view('pages-admin.typedump.edit', [
            'type_dump' => $type_dump,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'kapasitas' => ['required', 'string', 'max:50'],
            'harga' => ['required'],
            'deskripsi' => ['required', 'string', 'max:250'],
        ]);

        $validated['harga'] = preg_replace('/[^0-9]/', '', $request->harga);

        $type_dump = TypeDump::findOrFail($id);
        $type_dump->update($validated);
        return back()->with('success', 'Data Berhasil diubah');
    }

    public function destroy($id)
    {
        $type_dump = TypeDump::findOrFail($id);
        $type_dump->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    // public function home()
    // {
    //     $data = [
    //         'products' => Product::latest()->take(8)->get(),
    //         'jenis_dumps' => JenisDump::latest()->take(12)->get(),
    //         'type_dumps' => TypeDump::latest()->take(12)->get(),
    //         'chassis' => Chassis::latest()->take(12)->get(),
    //     ];

    //     return view('home', $data);
    // }
}
