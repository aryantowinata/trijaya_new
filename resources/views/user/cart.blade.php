@extends('layouts.main')
@section('container')

<main class="main">
    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Cart</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{route('index')}}">Home</a></li>
                    <li class="current">Cart</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->
    <div class="container py-5 mt-5" data-aos="fade-up">
        <h2 class="text-center mb-4">Your Cart</h2>

        @if($cart && count($cart) > 0)
        <div class="table-responsive" data-aos="zoom-in" data-aos-delay="200">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>
                            <img src="{{ asset('storage/produk/' . $item['image']) }}" alt="{{ $item['name'] }}" class="card-img-top" style="max-width: 50px;">
                        </td>
                        <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                        <td>
                            <!-- Tombol Delete -->
                            <form id="delete-form-{{ $id }}" action="{{ route('user.cart.delete', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $id }}">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Button Checkout -->
        <div class="text-center mt-4">
            @if(Auth::check())
            <a href="{{ route('user.cart.checkout') }}" class="btn btn-success btn-custom">Proceed to Checkout</a>
            @else
            <a href="{{ route('user.login') }}" class="btn btn-warning btn-custom">Login to Checkout</a>
            @endif
        </div>
        @else
        <p class="text-center">Your cart is empty. <a href="{{ route('product') }}">Start shopping now</a>!</p>
        @endif
    </div>
</main>


@endsection