<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Str;

class CartController extends Controller
{
    // Menampilkan Cart
    public function view()
    {
        $cart = session()->get('cart', []);
        return view('user.cart', compact('cart'));
    }

    public function add($id)
    {
        $product = Produk::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                "id_produk" => $product->id,
                "name" => $product->nama_produk,
                "price" => $product->harga_produk,
                "image" => $product->gambar_produk,
                "quantity" => 1,
            ];
        }

        session()->put('cart', $cart);


        return redirect()->route('user.cart')->with('success', 'Product added to cart!');
    }

    public function buyNow(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('user.login')->with('error', 'You need to log in to buy a product.');
        }

        $user = Auth::user();
        $product = Produk::findOrFail($id);

        // Periksa apakah stok mencukupi
        if ($product->jumlah_produk < 1) {
            return redirect()->route('product')->with('error', 'Product is out of stock.');
        }

        $total_harga = $product->harga_produk;

        Cart::create([
            'id_user' => $user->id,
            'id_produk' => $product->id,
            'jumlah' => 1,
        ]);

        // Buat Order Baru
        $order = Order::create([
            'id_user' => $user->id,
            'total_harga' => $total_harga,
            'status' => 'pending',
            'payment_name' => '', // Akan diperbarui setelah Midtrans Callback
            'payment_number' => '',
        ]);

        // Tambahkan Produk ke Order Item
        OrderItem::create([
            'id_order' => $order->id,
            'id_produk' => $product->id,
            'jumlah' => 1, // Jumlah default untuk "Buy Now"
            'harga_satuan' => $product->harga_produk,
        ]);

        // Kurangi stok produk
        $product->jumlah_produk -= 1;
        $product->save();

        $orderId = $order->id . '-' . time();

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');

        // Persiapkan data untuk Midtrans
        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $total_harga,
        ];

        $itemDetails = [
            [
                'id' => $product->id,
                'price' => $product->harga_produk,
                'quantity' => 1,
                'name' => $product->nama_produk,
            ]
        ];

        $midtransTransaction = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
        ];

        $carts = Cart::with('produk')->where('id_user', $user->id)->get();

        // Dapatkan Snap Token dari Midtrans
        $snapToken = Snap::getSnapToken($midtransTransaction);

        // Redirect ke halaman order dengan Snap Token
        return view('user.order', compact('snapToken', 'total_harga', 'carts'));
    }


    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to access checkout.');
        }

        $cart = session()->get('cart', []);
        $userId = Auth::id();

        if (empty($cart)) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        // Simpan data pesanan ke database
        foreach ($cart as $item) {
            // Simpan ke tabel Cart
            Cart::create([
                'id_user' => $userId,
                'id_produk' => $item['id_produk'],
                'jumlah' => $item['quantity'],
            ]);
        }

        $carts = Cart::where('id_user', Auth::id())->get();


        $total_harga = 0;
        foreach ($carts as $keranjang) {
            $total_harga += $keranjang->produk->harga_produk * $keranjang->jumlah;
        }

        $payment_name = ''; // Bisa disesuaikan dengan bank atau metode pembayaran yang digunakan
        $payment_number = ''; // Nomor VA sementara, nantinya akan diperbarui oleh Midtrans

        // Buat order baru
        $order = Order::create([
            'id_user' => Auth::id(),
            'total_harga' => $total_harga,
            'status' => 'pending',
            'payment_name' => $payment_name,
            'payment_number' => $payment_number,
        ]);

        foreach ($carts as $keranjang) {

            OrderItem::create([
                'id_order' => $order->id,
                'id_produk' => $keranjang->id_produk,
                'jumlah' => $keranjang->jumlah,
                'harga_satuan' => $keranjang->produk->harga_produk,
            ]);

            $this->updateProductQuantity($keranjang->id_produk, $keranjang->jumlah);
        }

        $orderId = $order->id . '-' . time();


        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');

        // Persiapkan data untuk Midtrans
        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $total_harga,
        ];

        $itemDetails = [];
        foreach ($carts as $keranjang) {
            $itemDetails[] = [
                'id' => $keranjang->id_produk,
                'price' => $keranjang->produk->harga_produk,
                'quantity' => $keranjang->jumlah,
                'name' => $keranjang->produk->nama_produk,
            ];
        }

        $midtransTransaction = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        // Dapatkan Snap Token
        $snapToken = Snap::getSnapToken($midtransTransaction);

        // Kosongkan keranjang dari session
        session()->forget('cart');

        $carts = Cart::with('produk')->where('id_user', $userId)->get();

        // Hitung total harga keranjang
        $total_harga = $carts->sum(function ($cart) {
            return $cart->produk->harga_produk * $cart->jumlah;
        });

        return view('user.order', compact('snapToken', 'carts', 'total_harga'));
    }

    public function midtransCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        // Validasi signature key dari Midtrans
        $signatureKey = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($signatureKey === $request->signature_key) {
            $order = Order::find($request->order_id);

            if ($order) {
                // Update status order berdasarkan status transaksi
                if ($request->transaction_status === 'settlement') {
                    $order->update(['status' => 'completed']);
                } elseif ($request->transaction_status === 'pending') {
                    $order->update(['status' => 'pending']);
                } elseif ($request->transaction_status === 'cancel') {
                    $order->update(['status' => 'cancel']);
                }

                // Ambil VA Number dan Bank dari respons Midtrans jika payment_type adalah bank_transfer
                if ($request->payment_type === 'bank_transfer' && isset($request->va_numbers[0])) {
                    $vaNumber = $request->va_numbers[0]['va_number'];
                    $bank = $request->va_numbers[0]['bank'];

                    // Update kolom payment_va_name dan payment_va_number di database
                    $order->update([
                        'payment_name' => $bank,
                        'payment_number' => $vaNumber,
                    ]);
                }
            }
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Fungsi untuk memperbarui jumlah produk setelah order item dibuat.
     *
     * @param int $id_produk ID produk yang jumlahnya ingin diperbarui.
     * @param int $jumlah Jumlah produk yang dikurangi.
     */
    private function updateProductQuantity($id_produk, $jumlah)
    {
        $product = Produk::find($id_produk);
        if ($product) {
            $product->jumlah_produk -= $jumlah;
            $product->save();
        }
    }

    public function delete($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart); // Perbarui session cart
        }

        return redirect()->route('user.cart')->with('success_delete', 'Product removed from cart!');
    }
}
