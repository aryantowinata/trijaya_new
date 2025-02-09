@extends('layouts.main')
@section('container')

<div class="container my-5" data-aos="fade-up" data-aos-duration="1000">
    <!-- Order Summary -->
    <div class="order-summary bg-light rounded p-4 shadow-sm mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <h5 class="fw-bold mb-1">Order ID: <span class="text-primary">#{{ $order->id }}</span></h5>
                <p class="text-muted mb-1">Order Date: {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <span class="badge rounded-pill bg-{{ $order->status == 'completed' ? 'success' : 'warning' }} py-2 px-3">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
        <p class="mt-3 mb-0"><strong>Total Harga:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
    </div>

    <!-- Order Items -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Order Items</h5>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Harga Satuan</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td class="d-flex align-items-center">
                                <img src="{{ asset('storage/produk/' . $item->produk->gambar_produk) }}" alt="{{ $item->produk->nama_produk }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <strong>{{ $item->produk->nama_produk }}</strong>
                                </div>
                            </td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td class="text-center">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-center">Rp {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Back to Order History -->
    <div class="text-center mt-5">
        <a href="{{ route('user.history') }}" class="btn btn-outline-secondary btn-lg">
            <i class="bi bi-arrow-left"></i> Back to Order History
        </a>
    </div>
</div>

@endsection