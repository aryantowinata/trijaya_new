@extends('layouts.main')
@section('container')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Hubungi Kami</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="index.html">Beranda</a></li>
                    <li class="current">Hubungi Kami</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <div class="mb-5">
            <iframe style="width: 100%; height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.5064066687737!2d102.1036921740344!3d1.469351161182027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d15f231dd9a6ed%3A0xb22508e69347729a!2sTri%20jaya!5e0!3m2!1szh-CN!2sid!4v1738648597229!5m2!1szh-CN!2sid" frameborder="0" allowfullscreen=""></iframe>
        </div><!-- End Google Maps -->

        <div class="container" data-aos="fade">

            <div class="row gy-5 gx-lg-5">

                <div class="col-lg-4">

                    <div class="info">
                        <h3>Informasi Kontak</h3>
                        <p>Kami ingin mendengar dari Anda! Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan, masukan, atau membutuhkan bantuan.</p>

                        <div class="info-item d-flex">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h4>Lokasi:</h4>
                                <p>Jl. Yos Sudarso No.51, Bengkalis Kota, Kec. Bengkalis, Kabupaten Bengkalis, Riau 28712</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h4>Email:</h4>
                                <p>julianjoe520@gmail.com</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex">
                            <i class="bi bi-phone flex-shrink-0"></i>
                            <div>
                                <h4>Telepon:</h4>
                                <p>0822-8755-4320</p>
                            </div>
                        </div><!-- End Info Item -->

                    </div>

                </div>

                <div class="col-lg-8">
                    <form action="#" method="post" role="form" class="php-email-form">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Nama Anda" required="">
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email Anda" required="">
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subjek" required="">
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" placeholder="Pesan" required=""></textarea>
                        </div>
                        <div class="my-3">
                            <div class="loading">Mengirim...</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Pesan Anda telah berhasil dikirim. Kami akan segera menghubungi Anda!</div>
                        </div>
                        <div class="text-center"><button type="submit">Kirim Pesan</button></div>
                    </form>
                </div><!-- End Contact Form -->

            </div>

        </div>

    </section><!-- /Contact Section -->

</main>
@endsection