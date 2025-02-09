@extends('layouts.main')
@section('container')


<div class="container my-5" data-aos="fade-up" data-aos-duration="1000">
    <div class="text-center mb-4">
        <h2>Order History</h2>
        <p class="text-muted">Here you can view details about your previous orders.</p>
    </div>

    @if($orders->isEmpty())
    <div class="alert alert-warning text-center" data-aos="fade-up" data-aos-duration="1000">
        <i class="bi bi-exclamation-circle"></i> You have no order history yet.
    </div>
    @else
    <div class="row">
        @foreach($orders as $order)
        <div class="col-lg-6 col-md-12 mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Order ID: <strong>#{{ $order->id }}</strong></span>
                    <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Total Harga:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </p>
                    <p class="mb-2">
                        <strong>Tanggal Order:</strong> {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                    <a href="{{ route('user.order-detail-user', $order->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@endsection