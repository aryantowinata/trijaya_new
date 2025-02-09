<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Trijaya</title>
    <meta name="description" content="">
    <meta name="keywords" content="Trijaya">

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/aos/aos.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css')}}" />

    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}" />

</head>

<body class="index-page">

    <header id="header" class="header sticky-top">

        <div class="topbar d-flex align-items-center light-background">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    <i class="bi bi-envelope d-flex align-items-center"><a href="#">julianjoe520@gmail.com</a></i>
                    <i class="bi bi-phone d-flex align-items-center ms-4"><span>0822-8755-4320</span></i>
                </div>
                <div class="social-links d-none d-md-flex align-items-center">
                    <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div><!-- End Top Bar -->

        <div class="branding d-flex align-items-cente">

            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="index.html" class="logo d-flex align-items-center">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <!-- <img src="assets/img/logo.png" alt=""> -->
                    <h1 class="sitename">Trijaya</h1>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="{{route('index')}}" class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}">Home<br></a></li>
                        <li><a href="{{route('about')}}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
                        <li><a href="{{route('product')}}" class="nav-link {{ request()->routeIs('product') ? 'active' : '' }}">Product</a></li>
                        <li><a href="{{route('user.cart')}}" class="nav-link {{ request()->routeIs('user.cart') ? 'active' : '' }}">Cart</a></li>
                        <li><a href="{{route('contact')}}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
                        @auth
                        @if(Auth::user()->role == 'user')
                        <li class="dropdown">
                            <a href="#" class="nav-link">
                                <span>{{ Auth::user()->name }}</span>
                                <i class="bi bi-chevron-down toggle-dropdown"></i>
                            </a>
                            <ul>
                                <li><a href="{{route('user.profile')}}">Profile</a></li>
                                <li><a href="{{route('user.history')}}">Order History</a></li>
                                <li>
                                    <form action="{{ route('user.logout') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item logout-btn">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @else
                        <!-- Tombol login jika belum login -->
                        <a href="{{ route('user.login') }}">
                            <button class="btn btn-secondary btn-md" id="loginButton">Login</button>
                        </a>
                        @endauth

                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

            </div>

        </div>

    </header>

    <!-- content awal -->
    @yield('container')
    <!-- conten akhir -->

    <footer id="footer" class="footer dark-background">

        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-4 col-md-6 footer-about">
                        <a href="index.html" class="logo d-flex align-items-center">
                            <span class="sitename">Trijaya</span>
                        </a>
                        <div class="footer-contact pt-3">
                            <p>Jl. Yos Sudarso No.51, Bengkalis Kota</p>
                            <p>Kec. Bengkalis, Kabupaten Bengkalis, Riau 287122</p>
                            <p class="mt-3"><strong>Phone:</strong> <span>0822-8755-4320</span></p>
                            <p><strong>Email:</strong> <span>julianjoe520@gmail.com</span></p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><a href="{{route('index')}}">Home</a></li>
                            <li><a href="{{route('about')}}">About us</a></li>
                            <li><a href="{{route('product')}}">Product</a></li>
                            <li><a href="{{route('user.cart')}}">Cart</a></li>
                            <li><a href="{{route('contact')}}">Contact</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-6 col-md-6 footer-links">
                        <h4>Our Location</h4>
                        <div class="map-container">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.5064066687737!2d102.1036921740344!3d1.469351161182027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d15f231dd9a6ed%3A0xb22508e69347729a!2sTri%20jaya!5e0!3m2!1szh-CN!2sid!4v1738648597229!5m2!1szh-CN!2sid"
                                width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">

                            </iframe>

                        </div>
                    </div>





                </div>
            </div>
        </div>

        <div class="copyright text-center">
            <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

                <div class="d-flex flex-column align-items-center align-items-lg-start">
                    <div>
                        © Copyright <strong><span>MyWebsite</span></strong>. All Rights Reserved
                    </div>
                    <div class="credits">

                        Designed by <a href="#">Trijaya</a>
                    </div>
                </div>

                <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>

                </div>

            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js')}}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js')}}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js')}}"></script>

    <script>
        // SweetAlert2 for delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                const form = document.getElementById(`delete-form-${itemId}`);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This item will be removed from your cart.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // SweetAlert2 success message for item deletion
        @if(session('success_delete'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session("success_delete ") }}',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
        @endif
    </script>

</body>

</html>