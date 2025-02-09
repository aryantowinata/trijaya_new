@extends('layouts.admin')
@section('container')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Detail Order</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.orders')}}">Orders</a></li>
                <li class="breadcrumb-item active">Detail Order</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <h1 class="h3 mb-4 text-gray-800">Detail Order #{{ $order->id }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Order</h6>
        </div>
        <div class="card-body">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Total Harga:</strong> Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Item Pesanan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Gambar</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->produk->nama_produk }}</td>
                            <td>
                                <img src="{{ asset('storage/produk/' . $item->produk->gambar_produk) }}" alt="{{ $item->produk->nama_produk }}" style="width: 100px; height: auto;">
                            </td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Kembali</a>

</main><!-- End #main -->




@endsection