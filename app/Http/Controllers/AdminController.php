<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Produk;
use App\Models\Order;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function loginAdmin()
    {
        return response()->view('admin.login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function profileAdmin()
    {
        $adminData = Auth::user();
        return view('admin.profile', compact('adminData'));
    }

    public function ordersAdmin()
    {
        $orders = Order::all();
        $adminData = Auth::user();
        return view('admin.orders', compact('orders', 'adminData'));
    }

    public function hapusOrderAdmin($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();


        return redirect()->route('orders.index')->with('success', 'Order berhasil dihapus!');
    }

    public function detailOrderAdmin(Order $order)
    {
        // Ambil semua item dalam order ini
        $adminData = Auth::user();
        $items = $order->items()->with('produk')->get();



        return view('admin.order-detail', compact('order', 'items', 'adminData'));
    }

    public function usersAdmin()
    {
        $adminData = Auth::user();
        $users = User::where('role', 'user')->get();
        return view('admin.users', compact('users', 'adminData'));
    }

    public function hapusUsersAdmin($id)
    {
        $users = User::findOrFail($id);
        $users->delete();


        return redirect()->route('admin.users')->with('success', 'Users berhasil dihapus!');
    }

    public function updateUsersAdmin(Request $request, $id)
    {
        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Validasi data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, // Mengecualikan email user saat ini
            'alamat' => 'nullable|string|max:255',
            'role' => 'required|string|max:20', // Role seperti 'user' atau 'admin'
        ]);

        // Perbarui data user
        $user->update($validatedData);

        // Redirect kembali ke halaman users dengan pesan sukses
        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui!');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input  
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk foto profil  
        ]);

        // Update data pengguna  
        $user->name = $request->name;
        $user->email = $request->email;

        // Jika ada file yang diupload  
        if ($request->hasFile('file')) {
            // Hapus foto profil lama jika ada  
            if ($user->foto_profile) {
                Storage::delete($user->foto_profile);
            }

            // Simpan foto profil baru  
            $path = $request->file('file')->store('foto_profile', 'public');
            $user->foto_profile = $path;
        }

        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->intended('admin/dashboard');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You do not have admin access.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboardAdmin()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $adminData = Auth::user();

            $jumlahUser = User::where('role', 'user')->count();

            // Mengambil jumlah order sekarang
            $jumlahOrderNow = Order::where('status', 'completed')->count();
            // Mengambil total harga order sekarang
            $totalHargaNow = Order::where('status', 'completed')->sum('total_harga');

            // Mengambil jumlah user bulan sebelumnya
            $jumlahUserLastMonth = User::where('role', 'user')
                ->whereMonth('created_at', now()->subMonth()->month)
                ->count();

            // Mengambil jumlah order dan total harga bulan sebelumnya
            $jumlahOrderLastMonth = Order::where('status', 'completed')
                ->whereMonth('created_at', now()->subMonth()->month)
                ->count();
            $totalHargaLastMonth = Order::where('status', 'completed')
                ->whereMonth('created_at', now()->subMonth()->month)
                ->sum('total_harga');

            // Menghitung persentase increase/decrease untuk jumlah order
            $orderIncreasePercentage = 0;
            if ($jumlahOrderLastMonth > 0) {
                $orderIncreasePercentage = (($jumlahOrderNow - $jumlahOrderLastMonth) / $jumlahOrderLastMonth) * 100;
            }

            // Menghitung persentase increase/decrease untuk total revenue
            $revenueIncreasePercentage = 0;
            if ($totalHargaLastMonth > 0) {
                $revenueIncreasePercentage = (($totalHargaNow - $totalHargaLastMonth) / $totalHargaLastMonth) * 100;
            }

            $userIncreasePercentage = 0;
            if ($jumlahUserLastMonth > 0) {
                $userIncreasePercentage = (($jumlahUser - $jumlahUserLastMonth) / $jumlahUserLastMonth) * 100;
            }

            // Menyusun data untuk dikirim ke view
            return response()->view('admin.dashboard', compact(
                'adminData',
                'jumlahOrderNow',
                'jumlahUser',
                'totalHargaNow',
                'orderIncreasePercentage',
                'revenueIncreasePercentage',
                'userIncreasePercentage' // Kirimkan data persentase increase/decrease user
            ))
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        return redirect('/')->withErrors([
            'message' => 'You must be logged in as an admin to access this page.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function productAdmin(Request $request)
    {
        // Mengambil semua produk
        $kategories = Kategori::all();
        $produks = Produk::with('kategori')->get();
        $adminData = Auth::user();
        return view('admin.product', compact('adminData', 'kategories', 'produks'));
    }

    public function hapusProductAdmin($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('admin.product')->with('success', 'Produk berhasil dihapus.');
    }

    public function storeProductAdmin(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_produk' => 'required|string', // Menyimpan kategori dalam bentuk string
            'harga_produk' => 'required|numeric',
            'jumlah_produk' => 'required|integer',
            'gambar_produk' => 'image|nullable|max:2048', // Max ukuran 2MB
        ]);

        // Mendapatkan ID kategori berdasarkan nama kategori yang dipilih
        $kategori = Kategori::where('nama_kategori', $validatedData['kategori_produk'])->first();
        if ($kategori) {
            $validatedData['id_kategori'] = $kategori->id; // Menambahkan ID kategori ke validasi data
        } else {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        // Handle file upload jika ada gambar produk
        if ($request->hasFile('gambar_produk')) {
            $fileName = time() . '.' . $request->gambar_produk->extension();
            $request->gambar_produk->storeAs('produk', $fileName, 'public');
            $validatedData['gambar_produk'] = $fileName;
        }

        // Tambah user_id untuk tracking
        $validatedData['id_user'] = auth()->id();

        // Simpan produk ke database
        Produk::create($validatedData);

        return redirect()->route('admin.product')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function updateProductAdmin(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_produk' => 'required|string',
            'harga_produk' => 'required|numeric',
            'jumlah_produk' => 'required|integer',
            'gambar_produk' => 'image|nullable|max:2048',
        ]);

        $kategori = Kategori::where('nama_kategori', $validatedData['kategori_produk'])->first();
        if ($kategori) {
            $validatedData['id_kategori'] = $kategori->id;
        } else {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        // Handle file upload jika ada
        if ($request->hasFile('gambar_produk')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar_produk) {
                Storage::disk('public')->delete('produk/' . $produk->gambar_produk);
            }

            $fileName = time() . '.' . $request->gambar_produk->extension();
            $request->gambar_produk->storeAs('produk', $fileName, 'public');
            $validatedData['gambar_produk'] = $fileName;
        } else {
            $validatedData['gambar_produk'] = $produk->gambar_produk;
        }

        $produk->update($validatedData);

        return redirect()->route('admin.product')->with('success', 'Produk berhasil diperbarui.');
    }

    public function storeKategoriAdmin(Request $request)
    {

        // Validasi input
        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'gambar_kategori' => 'image|nullable|max:2048', // Max ukuran 2MB
        ]);

        // Handle file upload jika ada gambar kategori
        if ($request->hasFile('gambar_kategori')) {
            $fileName = time() . '.' . $request->gambar_kategori->extension();
            $request->gambar_kategori->storeAs('kategori', $fileName, 'public');
            $validatedData['gambar_kategori'] = $fileName;
        }

        // Simpan kategori ke database
        Kategori::create($validatedData);

        return redirect()->route('admin.product')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updatePassword(Request $request)
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed', // Setidaknya 8 karakter dan password konfirmasi harus cocok
        ]);

        // Cek apakah password lama yang dimasukkan cocok dengan password yang ada di database
        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama yang Anda masukkan tidak cocok.']);
        }

        // Update password jika valid
        $user->password = \Hash::make($request->new_password);
        $user->save();

        // Redirect kembali ke halaman profile dengan pesan sukses
        return redirect()->route('admin.profile')->with('success', 'Password berhasil diperbarui!');
    }
}
