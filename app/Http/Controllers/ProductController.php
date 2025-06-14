<?php

namespace App\Http\Controllers;

use App\Models\Chassis;
use App\Models\JenisDump;
use App\Models\product;
use App\Models\TypeDump;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = product::all();
        return view(
            'pages-admin.product.index',
            [
                'products' => $products,
            ]
        );
    }

    public function create()
    {
        return view('pages-admin.product.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'harga' => ['required'],
            'length' => ['nullable', 'numeric', 'min:0'],
            'width' => ['nullable', 'numeric', 'min:0'],
            'height' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:tersedia,tidak tersedia'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $validatedData['harga'] = preg_replace('/[^0-9]/', '', $request->harga);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
            $validatedData['image'] = asset('uploads/products/' . $imageName);
        }

        Product::create($validatedData);

        return redirect('/product/create')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('pages-admin.product.edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'harga' => ['required'],
            'length' => ['nullable', 'numeric', 'min:0'],
            'width' => ['nullable', 'numeric', 'min:0'],
            'height' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:tersedia,tidak tersedia'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $validated['harga'] = preg_replace('/[^0-9]/', '', $request->harga);

        $product = Product::findOrFail($id);

        // Upload gambar baru jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
            $validated['image'] = asset('uploads/products/' . $imageName);
        }

        $product->update($validated);

        return back()->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $products = product::findOrFail($id);
        $products->delete();
        return redirect('/product')->with('success', 'Berhasil menghapus data');
    }

    
}
