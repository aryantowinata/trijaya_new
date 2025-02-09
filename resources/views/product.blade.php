@extends('layouts.main')
@section('container')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Product</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{route('index')}}">Home</a></li>
                    <li class="current">Product</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">

        <div class="container">

            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

                <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                    <li class="{{ !$selectedCategory ? 'filter-active text-red' : '' }}">
                        <a href="{{ route('product') }}">All</a>
                    </li>
                    @foreach($kategories as $kategori)
                    <li class="{{ $selectedCategory === $kategori->nama_kategori ? 'filter-active text-red' : '' }}">
                        <a href="{{ route('product', ['category' => $kategori->nama_kategori]) }}">
                            {{ $kategori->nama_kategori }}
                        </a>
                    </li>
                    @endforeach
                </ul>

                <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                        <img src="{{ asset('storage/produk/' . $product->gambar_produk) }}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>{{$product->nama_produk}}</h4>
                            <p>{{ $product->kategori ? $product->kategori->nama_kategori : 'Tidak ada kategori' }}</p>
                            @if(Auth::check())
                            <form action="{{ route('user.cart.add', ['id' => $product->id]) }}" method="POST" style="display: inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-cart"></i> Add to Cart
                                </button>
                            </form>

                            <a href="{{ route('user.cart.buyNow', ['id' => $product->id]) }}" class="btn btn-success" style="margin-left: 5px;">
                                <i class="bi bi-cart-plus-fill"></i> Buy Now
                            </a>

                            @else
                            <a href="{{ route('user.login') }}" class="btn btn-warning">
                                <i class="bi bi-cart-plus-fill"> Login To Buy</i>
                            </a>
                            @endif
                        </div>
                    </div><!-- End Portfolio Item -->
                    @endforeach
                </div>

            </div>

        </div>

    </section><!-- /Portfolio Section -->

</main>
@endsection