@extends('layouts.admin')
@section('container')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Orders</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $jumlahOrderNow }}</h6>
                                        <span class="text-success small pt-1 fw-bold">
                                            {{ number_format($orderIncreasePercentage, 2) }}%
                                        </span>
                                        <span class="text-muted small pt-2 ps-1">
                                            increase
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Revenue</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>Rp. {{ number_format($totalHargaNow, 0, ',', '.') }}</h6>
                                        <span class="text-success small pt-1 fw-bold">
                                            {{ number_format($revenueIncreasePercentage, 2) }}%
                                        </span>
                                        <span class="text-muted small pt-2 ps-1">
                                            increase
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Customers</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $jumlahUser }}</h6>
                                        <span class="small pt-1 fw-bold">
                                            @if ($userIncreasePercentage > 0)
                                            <span class="text-success">+{{ number_format($userIncreasePercentage, 2) }}%</span>
                                            <span class="text-muted small pt-2 ps-1">increase</span>
                                            @elseif ($userIncreasePercentage < 0)
                                                <span class="text-danger">{{ number_format($userIncreasePercentage, 2) }}%</span>
                                        <span class="text-muted small pt-2 ps-1">decrease</span>
                                        @else
                                        <span>0%</span>
                                        <span class="text-muted small pt-2 ps-1">no change</span>
                                        @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Customers Card -->

                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>
</main><!-- End #main -->

<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function() {
        history.go(1);
    };
</script>

@endsection