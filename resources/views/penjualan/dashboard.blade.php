@extends('template.master')
@section('chart')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js"
        integrity="sha512-tMabqarPtykgDtdtSqCL3uLVM0gS1ZkUAVhRFu1vSEFgvB73niFQWJuvviDyBGBH22Lcau4rHB5p2K2T0Xvr6Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('content')
    <!-- Content -->

    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Dashboard</h4>
                        {{-- <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Welcome to Xoric Dashboard</li>
                            </ol> --}}
                    </div>
                    <div class="col-md-4">
                        {{-- <div class="float-end d-none d-md-block">
                                <div class="dropdown d-inline-block">
                                    <button type="button"
                                        class="btn btn-light rounded-pill user text-start d-flex align-items-center"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-settings-outline me-1"></i> Settings
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Separated link</a>
                                    </div>
                                </div>
                            </div> --}}
                        <button type="button" class="btn btn-sm btn-light float-end" data-bs-toggle="modal"
                            data-bs-target="#modal_view">
                            <i class="fas fa-eye"></i>
                            View
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <canvas id="grafik_penjualan" width="400" height="180" class="bg-light"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- end page-content-wrapper -->

        <div class="page-content-wrapper mt-2">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Laporan Penjualan</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered">
                                    <tr>
                                        <td colspan="2" class="text-center"><strong>PENJUALAN</strong></td>
                                    </tr>
                                    @php
                                        $total_penjualan = 0;
                                        $total_penjualan_kas = 0;
                                        $total_penjualan_transfer = 0;
                                    @endphp
                                    @foreach ($penjualan as $d)
                                        @php
                                            $total_penjualan += $d->ttl_penjualan - $d->ttl_diskon + $d->ttl_pembulatan;
                                            if ($d->pembayaran_id == 1) {
                                                $total_penjualan_kas +=
                                                    $d->ttl_penjualan - $d->ttl_diskon + $d->ttl_pembulatan;
                                            } else {
                                                $total_penjualan_transfer +=
                                                    $d->ttl_penjualan - $d->ttl_diskon + $d->ttl_pembulatan;
                                            }

                                        @endphp
                                        <tr>
                                            <td>{{ $d->pembayaran->pembayaran }}</td>
                                            <td>{{ number_format($d->ttl_penjualan - $d->ttl_diskon + $d->ttl_pembulatan, 0) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><strong>Total Penjualan Kas</strong></td>
                                        <td><strong>{{ number_format($total_penjualan_kas, 0) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Penjualan QRIS/Transfer</strong></td>
                                        <td><strong>{{ number_format($total_penjualan_transfer, 0) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Penjualan</strong></td>
                                        <td><strong>{{ number_format($total_penjualan, 0) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-center"><strong>PENGELUARAN</strong></td>
                                    </tr>
                                    @php
                                        $total_pengeluaran = 0;
                                        $total_pengeluaran_kas = 0;
                                        $total_pengeluaran_transfer = 0;
                                    @endphp
                                    @foreach ($pengeluaran as $d)
                                        @php
                                            $total_pengeluaran += $d->ttl_pengeluaran;
                                            if ($d->pembayaran_id == 1 || $d->pembayaran_id == 2) {
                                                $total_pengeluaran_kas += $d->ttl_pengeluaran;
                                            } else {
                                                $total_pengeluaran_transfer += $d->ttl_pengeluaran;
                                            }

                                        @endphp
                                        <tr>
                                            <td>
                                                @if ($d->jenis = 1)
                                                    Kas
                                                @endif
                                                @if ($d->jenis = 2)
                                                    Laba
                                                @endif
                                                @if ($d->jenis = 3)
                                                    QRIS/Transfer
                                                @endif
                                            </td>
                                            <td>{{ number_format($d->ttl_pengeluaran, 0) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><strong>Total Pengeluaran Kas</strong></td>
                                        <td><strong>{{ number_format($total_pengeluaran_kas, 0) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Pengeluaran QRIS/Transfer</strong></td>
                                        <td><strong>{{ number_format($total_pengeluaran_transfer, 0) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Pengeluaran</strong></td>
                                        <td><strong>{{ number_format($total_pengeluaran, 0) }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>

    </div>
    <!-- End Page-content -->

    <form action="" method="get">
        <div id="modal_view" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabeltambah"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabeltambah">View</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <label for="">
                                    Dari
                                </label>
                                <input type="date" name="tgl1" value="{{ $tgl1 }}" class="form-control"
                                    required>
                            </div>

                            <div class="col-6">
                                <label for="">
                                    Sampai
                                </label>
                                <input type="date" name="tgl2" value="{{ $tgl2 }}" class="form-control"
                                    required>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">View</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </form>


@section('script')
    <script>
        var cData = JSON.parse(`<?php echo $chart; ?>`);
        var periode = JSON.parse(`<?php echo $periode; ?>`);
        const ctx = document.getElementById('grafik_penjualan');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: periode,
                datasets: cData
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(document).ready(function() {

            <?php if(session('success')): ?>
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "<?= session('success') ?>",
                showConfirmButton: !1,
                timer: 1500
            });
            <?php endif; ?>

            <?php if(session('error')): ?>
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: "<?= session('error') ?>",
                showConfirmButton: !1,
                timer: 1500
            });
            <?php endif; ?>


        });
    </script>
@endsection
@endsection
