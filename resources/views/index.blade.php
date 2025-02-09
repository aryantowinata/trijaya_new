@extends('layouts.main')
@section('container')
<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

        <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

            <div class="carousel-item active">
                <img src="assets/img/Tri.jpeg" alt="">
                <div class="container">
                    <h2>Belanja Mudah, Cepat, dan Terpercaya!</h2>
                    <p>Temukan produk terbaik dengan harga terjangkau. Kami siap melayani kebutuhan Anda dengan profesionalisme dan kualitas terbaik.</p>
                    <a href="#featured-services" class="btn-get-started">Mulai Belanja</a>
                </div>
            </div><!-- End Carousel Item -->

            <div class="carousel-item">
                <img src="assets/img/Dalam.jpeg" alt="">
                <div class="container">
                    <h2>Pilihan Terbaik untuk Kebutuhan Anda!</h2>
                    <p>Kami menghadirkan produk berkualitas dengan berbagai kategori yang dapat memenuhi kebutuhan Anda sehari-hari.</p>
                    <a href="#featured-services" class="btn-get-started">Mulai Belanja</a>
                </div>
            </div><!-- End Carousel Item -->

            <div class="carousel-item">
                <img src="assets/img/barang.jpeg" alt="">
                <div class="container">
                    <h2>Belanja Aman & Nyaman di Satu Tempat</h2>
                    <p>Dapatkan pengalaman berbelanja yang menyenangkan dengan berbagai promo menarik dan pengiriman cepat.</p>
                    <a href="#featured-services" class="btn-get-started">Mulai Belanja</a>
                </div>
            </div><!-- End Carousel Item -->

            <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>

            <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>

            <ol class="carousel-indicators"></ol>

        </div>

    </section><!-- /Hero Section -->

    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section light-background">

        <div class="container">

            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-xl-9 text-center text-xl-start">
                    <h3>Ayo Mulai Belanja!</h3>
                    <p>Jangan lewatkan penawaran terbaik! Nikmati pengalaman belanja praktis dengan berbagai kemudahan hanya di sini.</p>
                </div>
                <div class="col-xl-3 cta-btn-container text-center">
                    <a class="cta-btn align-middle" href="#">Belanja Sekarang</a>
                </div>
            </div>

        </div>

    </section><!-- /Call To Action Section -->

    <!-- Services Section -->
    <section id="services" class="services section">

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item  position-relative">
                        <div class="icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>Gratis Kirim</h3>
                        </a>
                        <p>Nikmati pengiriman gratis untuk wilayah tertentu. Kami pastikan produk sampai dengan aman dan tepat waktu.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>Pembayaran Secara Online</h3>
                        </a>
                        <p>Transaksi mudah dan aman dengan berbagai metode pembayaran yang tersedia, mulai dari e-wallet, transfer bank, hingga kartu kredit.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-box"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>Barang Berkualitas</h3>
                        </a>
                        <p>Kami hanya menyediakan produk dengan kualitas terbaik yang telah teruji dan terpercaya.</p>
                    </div>
                </div><!-- End Service Item -->





            </div>

        </div>

    </section><!-- /Services Section -->

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">

        <div class="container">

            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

                <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                    <li class="{{ !$selectedCategory ? 'filter-active text-red' : '' }}">
                        <a href="{{ route('index') }}">All</a>
                    </li>
                    @foreach($kategories as $kategori)
                    <li class="{{ $selectedCategory === $kategori->nama_kategori ? 'filter-active text-red' : '' }}">
                        <a href="{{ route('index', ['category' => $kategori->nama_kategori]) }}">
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
                </div><!-- End Portfolio Container -->
            </div>

        </div>

    </section><!-- /Portfolio Section -->



</main>

<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function() {
        history.go(1);
    };
</script>
@endsection