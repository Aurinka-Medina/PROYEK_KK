<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Menampilkan Landing Page User
    public function index()
    {
        $products = Product::latest()->paginate(8);
        return view('products.index', compact('products'));
    }

    // Menampilkan Halaman Dashboard Admin
    public function admin()
    {
        $products = Product::latest()->paginate(10);
        return view('products.admin', compact('products'));
    }

    // Form Tambah Produk
    public function create()
    {
        return view('products.create');
    }

    // Simpan Produk Baru
   // Di dalam method store()
public function store(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'title' => 'required|min:3',
        'price' => 'required|numeric',
        'stock' => 'required|numeric'
    ]);

    $image = $request->file('image');
    // Simpan gambar ke folder storage/app/public/products
    $imageName = $image->hashName();
    $image->storeAs('products', $imageName, 'public');

    Product::create([
        'image' => $imageName,
        'title' => $request->title,
        'price' => $request->price,
        'stock' => $request->stock
    ]);

    return redirect()->route('products.admin')->with(['success' => 'Data Berhasil Disimpan!']);
}
    // Form Edit Produk
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Update Data Produk
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|min:3',
            'price' => 'required|numeric',
            'stock' => 'required|numeric'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());
            Storage::delete('public/products/' . $product->image);

            $product->update([
                'image' => $image->hashName(),
                'title' => $request->title,
                'price' => $request->price,
                'stock' => $request->stock
            ]);
        } else {
            $product->update([
                'title' => $request->title,
                'price' => $request->price,
                'stock' => $request->stock
            ]);
        }

        return redirect()->route('products.admin')->with(['success' => 'Data Berhasil Diubah!']);
    }

    // Hapus Produk
    public function destroy(Product $product)
    {
        Storage::delete('public/products/' . $product->image);
        $product->delete();

        return redirect()->route('products.admin')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}