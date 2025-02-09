<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Order;

class OrderController extends Controller
{
    public function order()
    {
        // Ambil cart sesuai dengan user_id yang sedang login
        $carts = Cart::with('produk')->where('id_user', Auth::id())->get();

        // dd($carts);

        // Hitung total harga dari keranjang
        $total_harga = 0;
        foreach ($carts as $cart) {

            $total_harga += $cart->produk->harga_produk * $cart->jumlah;
        }

        return view('user.order', compact('carts', 'total_harga'));
    }


    public function history()
    {
        $orders = Order::where('id_user', Auth::id())->get();
        Cart::where('id_user', Auth::id())->delete();

        return view('user.history', compact('orders'));
    }

    public function order_detail_user(Order $order)
    {
        // Ambil semua item dalam order ini

        $items = $order->items()->with('produk')->get();

        return view('user.order-detail-user', compact('order', 'items'));
    }

    public function index()
    {
        $orders = Order::all();
        return view('admin.orders', compact('orders'));
    }


    public function destroy(Order $order)
    {
        // Hapus produk
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order berhasil dihapus!');
    }


    public function detail_order(Order $order)
    {
        // Ambil semua item dalam order ini

        $items = $order->items()->with('products')->get();

        return view('admin.order-detail', compact('order', 'items'));
    }
}
