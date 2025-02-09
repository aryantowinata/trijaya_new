@extends('layouts.main')
@section('container')

<main class="main about-page">

    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">About</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li class="current">About</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- About Section -->
    <section id="about" class="about section">

        <div class="container">

            <div class="row gy-4">
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <h3>Kami menyediakan produk berkualitas dengan penuh tanggung jawab, memastikan setiap pelanggan mendapatkan layanan terbaik dan kemudahan dalam berbelanja</h3>
                    <img src="assets/img/Tri.jpeg" class="img-fluid rounded-4 mb-4" alt="">
                    <p>Kami selalu berusaha memberikan pengalaman belanja terbaik dengan produk berkualitas dan layanan pelanggan yang responsif. Kepuasan pelanggan adalah prioritas utama kami, sehingga setiap transaksi dilakukan dengan transparansi dan profesionalisme.</p>
                    <p>Tri Jaya berkomitmen untuk memberikan layanan yang cepat, aman, dan terpercaya. Kami terus berinovasi untuk menghadirkan kemudahan bagi pelanggan dalam berbelanja. Dengan proses yang efisien dan dukungan layanan pelanggan yang siap membantu, kami memastikan setiap pengalaman belanja menjadi lebih menyenangkan dan bebas dari kendala. </p>
                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="250">
                    <div class="content ps-0 ps-lg-5">
                        <p class="fst-italic">
                            Tri Jaya hadir sebagai solusi belanja online yang menawarkan produk berkualitas tinggi dengan layanan terbaik. Dengan fokus pada kepuasan pelanggan, kami terus berinovasi untuk memberikan pengalaman berbelanja yang mudah, aman, dan nyaman.
                        </p>
                        <ul>
                            <li><i class="bi bi-check-circle-fill"></i> <span>Menyediakan produk berkualitas dengan layanan terbaik untuk kepuasan pelanggan.</span></li>
                            <li><i class="bi bi-check-circle-fill"></i> <span>Menjamin pengalaman belanja yang aman, nyaman, dan terpercaya.</span></li>
                            <li><i class="bi bi-check-circle-fill"></i> <span>Memberikan harga kompetitif serta layanan pengiriman cepat dan efisien.</span></li>
                        </ul>
                        <p>
                            Tri Jaya adalah pengecer online terkemuka, berkomitmen untuk menawarkan produk dan layanan berkualitas tinggi kepada pelanggan kami yang berharga. Sejak awal, kami berfokus untuk memberikan pengalaman berbelanja yang luar biasa dengan beragam produk, harga kompetitif, dan pengiriman cepat.
                        </p>

                        <div class="position-relative mt-4">
                            <img src="assets/img/Dalam.jpeg" class="img-fluid rounded-4" alt="">

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section><!-- /About Section -->




</main>

@endsection