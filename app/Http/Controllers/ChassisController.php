<?php

namespace App\Http\Controllers;

use App\Models\Chassis;
use Illuminate\Http\Request;

class ChassisController extends Controller
{
    public function index()
    {
        $chassis = Chassis::all();
        return view('pages-admin.chassis.index',[
            'chassis' => $chassis,
        ]);
    }

    public function create()
    {
        return view('pages-admin.chassis.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'deskripsi' => ['required', 'string', 'max:255']
        ]);

        Chassis::create($validatedData);
        return redirect('/chassis/create')->with('success', 'Data berhasil ditambah');
    }

    public function edit($id)
    {
        $chassis = chassis::findOrFail($id);
        return view('pages-admin.chassis.edit',[
            'chassis' => $chassis,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'deskripsi' => ['required', 'string', 'max:255']
        ]);

        $chassis = Chassis::findOrFail($id);

        $chassis->update($validated);

        return back()->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $chassis = Chassis::findOrFail($id);
        $chassis->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function home()
    {
        $chassis = Chassis::latest()->take(12)->get();
        return view('home', compact('chassis'));
    }
}
