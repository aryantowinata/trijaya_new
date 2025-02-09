<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->query('category'); // Ambil kategori dari query string
        $kategories = Kategori::all(); // Ambil semua kategori untuk filter navigasi

        // Filter produk berdasarkan kategori jika kategori dipilih
        if ($selectedCategory) {
            $products = Produk::with('kategori')
                ->whereHas('kategori', function ($query) use ($selectedCategory) {
                    $query->where('nama_kategori', $selectedCategory);
                })
                ->get();
        } else {
            $products = Produk::with('kategori')->get(); // Jika tidak ada kategori, tampilkan semua produk
        }

        return response()->view('index', compact('selectedCategory', 'kategories', 'products'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }


    public function about()
    {
        return view('about');
    }

    public function product(Request $request)
    {
        $selectedCategory = $request->query('category'); // Ambil kategori dari query string
        $kategories = Kategori::all(); // Ambil semua kategori untuk filter navigasi

        // Filter produk berdasarkan kategori jika kategori dipilih
        if ($selectedCategory) {
            $products = Produk::with('kategori')
                ->whereHas('kategori', function ($query) use ($selectedCategory) {
                    $query->where('nama_kategori', $selectedCategory);
                })
                ->get();
        } else {
            $products = Produk::with('kategori')->get(); // Jika tidak ada kategori, tampilkan semua produk
        }

        return view('product', compact('products', 'kategories', 'selectedCategory'));
    }

    public function product_detail($id)
    {
        $product = Produk::with('kategori')->findOrFail($id); // Ambil produk berdasarkan ID
        $kategories = Kategori::all(); // Ambil semua kategori untuk navigasi
        return view('product_detail', compact('product', 'kategories')); // Kirim data ke view
    }


    public function contact()
    {
        return view('contact');
    }

    public function cart()
    {
        return view('cart');
    }
}
