<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index()
    {
        $cart = session()->get('cart', []);

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('cart.index', compact('cart', 'total'));
    }

    // Menambahkan produk ke keranjang
    public function add(Product $product)
    {
        if ($product->stock <= 0) {
            return back()->with('error', 'Produk sedang habis.');
        }

        $cart = session()->get('cart', []);

        $productId = $product->id;

        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] >= $product->stock) {
                return back()->with(
                    'error',
                    'Jumlah barang melebihi stok yang tersedia.'
                );
            }

            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
                'stock' => $product->stock,
            ];
        }

        session()->put('cart', $cart);

        return back()->with(
            'success',
            'Produk berhasil ditambahkan ke keranjang!'
        );
    }

    // Mengubah jumlah produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return back()->with(
                'error',
                'Produk tidak ditemukan di keranjang.'
            );
        }

        if ($request->quantity > $cart[$id]['stock']) {
            return back()->with(
                'error',
                'Jumlah melebihi stok yang tersedia.'
            );
        }

        $cart[$id]['quantity'] = $request->quantity;

        session()->put('cart', $cart);

        return back()->with(
            'success',
            'Jumlah produk berhasil diperbarui.'
        );
    }

    // Menghapus produk
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return back()->with(
            'success',
            'Produk dihapus dari keranjang.'
        );
    }

    // Checkout WhatsApp
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        $message = "Halo WOVEN, saya ingin memesan:\n\n";

        $total = 0;
        $number = 1;

        foreach ($cart as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;

            $message .= $number . ". " . $item['title'] . "\n";
            $message .= "Jumlah: " . $item['quantity'] . "\n";
            $message .= "Harga: Rp "
                . number_format($item['price'], 0, ',', '.') . "\n";
            $message .= "Subtotal: Rp "
                . number_format($subtotal, 0, ',', '.') . "\n\n";

            $number++;
        }

        $message .= "Total: Rp "
            . number_format($total, 0, ',', '.') . "\n\n";

        $message .= "Mohon informasi mengenai ketersediaan dan pembayaran.";

        // Ganti dengan nomor WhatsApp WOVEN
        $phone = '6289510636988';

        $url = 'https://wa.me/' . $phone
            . '?text=' . urlencode($message);

        return redirect()->away($url);
    }
}