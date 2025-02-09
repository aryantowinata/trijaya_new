@extends('layouts.main')
@section('container')

<div class="container mt-5" data-aos="fade-up" data-aos-duration="1000">
    <h2 class="checkout-title text-center mb-4" data-aos="fade-up" data-aos-duration="1000">Checkout</h2>

    @if($carts && count($carts) > 0)
    <div class="row checkout-summary">
        <!-- Left Column: User Information -->
        <div class="col-lg-6 col-md-12 mb-4" data-aos="fade-right" data-aos-duration="1000">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h4 class="card-title mb-3">User Information</h4>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Name:</strong> {{ Auth::user()->name }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ Auth::user()->email }}</li>
                        <li class="list-group-item"><strong>Alamat:</strong> {{ Auth::user()->alamat }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Column: Cart Summary -->
        <div class="col-lg-6 col-md-12 mb-4" data-aos="fade-left" data-aos-duration="1000">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h4 class="card-title mb-3">Cart Summary</h4>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Total Harga:</strong> Rp {{ number_format($total_harga, 0, ',', '.') }}</li>
                    </ul>
                    <button type="button" id="pay-button" class="btn btn-success w-100 mt-3" data-aos="zoom-in" data-aos-duration="1000">
                        <i class="bi bi-bag-check"></i> Place Order
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Items Section -->
    <div class="row" data-aos="fade-up" data-aos-duration="1000">
        <div class="col-12 checkout-items">
            <h4 class="mb-4">Cart Items</h4>
            <ul class="list-group">
                @foreach($carts as $cart)
                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/produk/' . $cart->produk->gambar_produk) }}" alt="{{ $cart->produk->nama_produk }}" class="product-image me-3" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
                        <div>
                            <strong>{{ $cart->produk->nama_produk }}</strong>
                            <p class="mb-1">Quantity: {{ $cart->jumlah }}</p>
                        </div>
                    </div>
                    <div>
                        <strong>Harga:</strong>
                        <p>Rp {{ number_format($cart->produk->harga_produk * $cart->jumlah, 0, ',', '.') }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @else
    <div class="text-center mt-5">
        <p class="text-muted">Your cart is empty.</p>
        <a href="{{ route('product') }}" class="btn btn-primary mt-3">Start Shopping</a>
    </div>
    @endif
</div>

<!-- Midtrans Snap.js -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.getElementById('pay-button').onclick = function() {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                window.location.href = "{{ route('user.history') }}";
            },
            onPending: function(result) {
                console.log('Waiting for payment:', result);
            },
            onError: function(result) {
                console.log('Payment error:', result);
            }
        });
    };
</script>

@endsection