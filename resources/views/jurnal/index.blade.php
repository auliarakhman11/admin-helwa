@extends('template.master')

@section('content')
    <!-- Content -->

    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12 col-md-4">
                        <h4 class="page-title mb-1">Laporan Keuangan</h4>
                        {{-- <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Welcome to Xoric Dashboard</li>
                            </ol> --}}
                    </div>
                    <div class="col-12 col-md-8">
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

                        <form action="" method="get">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="text-light" for="">Dari</label>
                                        <input type="date" name="tgl1" value="{{ $tgl1 }}"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="text-light" for="">Sampai</label>
                                        <input type="date" name="tgl2" value="{{ $tgl2 }}"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-light float-end mt-4">
                                        <i class="fa fa-search"></i>
                                        Cari
                                    </button>
                                </div>
                            </div>
                        </form>


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
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th rowspan="2"><strong>Kas</strong></th>
                                            <th colspan="3"><strong>Saldo Berjalan</strong></th>
                                            <th colspan="3"><strong>Laporan Harian</strong></th>
                                            <th rowspan="2"><strong>Akktual</strong></th>
                                        </tr>
                                        <tr class="text-center">
                                            <th><strong>Saldo</strong></th>
                                            <th><strong>Pengeluaran</strong></th>
                                            <th><strong>Sisa Saldo</strong></th>
                                            <th><strong>Saldo</strong></th>
                                            <th><strong>Pengeluaran</strong></th>
                                            <th><strong>Sisa Saldo</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $saldo_penjualan = $penjualan
                                                ? $penjualan->ttl_penjualan -
                                                    $penjualan->ttl_diskon +
                                                    $penjualan->ttl_pembulatan
                                                : 0;
                                        @endphp
                                        <tr class="text-center">
                                            <td class="text-start"><strong>Penjualan</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>{{ number_format($saldo_penjualan, 0) }}</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" class="bg-primary text-light"><strong>Bahan</strong></td>
                                        </tr>
                                        @php
                                            $tot_saldo_lalu_bahan = 0;
                                            $tot_pengeluaran_bahan_lalu = 0;
                                            $tot_sisa_saldo_bahan_lalu = 0;
                                            $tot_saldo_bahan = 0;
                                            $tot_pengeluaran_bahan = 0;
                                            $tot_sisa_saldo_bahan = 0;
                                            $tot_aktual_bahan = 0;

                                            $saldo_bibit_lalu = $stok_produk ? $stok_produk->harga_jual_lalu : 0;
                                            $pengeluaran_bibit_lalu = $stok_produk ? $stok_produk->harga_beli_lalu : 0;
                                            $sisa_saldo_bibit_lalu = $saldo_bibit_lalu - $pengeluaran_bibit_lalu;
                                            $saldo_bibit = $stok_produk ? $stok_produk->harga_jual : 0;
                                            $pengeluaran_bibit = $stok_produk ? $stok_produk->harga_beli : 0;
                                            $sisa_saldo_bibit = $saldo_bibit - $pengeluaran_bibit;
                                            $aktual_bibit = $sisa_saldo_bibit_lalu + $sisa_saldo_bibit;

                                            $tot_saldo_lalu_bahan += $saldo_bibit_lalu;
                                            $tot_pengeluaran_bahan_lalu += $pengeluaran_bibit_lalu;
                                            $tot_sisa_saldo_bahan_lalu += $sisa_saldo_bibit_lalu;
                                            $tot_saldo_bahan += $saldo_bibit;
                                            $tot_pengeluaran_bahan += $pengeluaran_bibit;
                                            $tot_sisa_saldo_bahan += $sisa_saldo_bibit;
                                            $tot_aktual_bahan += $aktual_bibit;
                                        @endphp
                                        <tr class="text-center">
                                            <td class="text-start">Bibit</td>
                                            <td>{{ number_format($saldo_bibit_lalu, 0) }}</td>
                                            <td>{{ number_format($pengeluaran_bibit_lalu, 0) }}</td>
                                            <td>{{ number_format($sisa_saldo_bibit_lalu, 0) }}</td>
                                            <td>{{ number_format($saldo_bibit, 0) }}</td>
                                            <td>{{ number_format($pengeluaran_bibit, 0) }}</td>
                                            <td>{{ number_format($sisa_saldo_bibit, 0) }}</td>
                                            <td>{{ number_format($aktual_bibit, 0) }}</td>
                                        </tr>

                                        @foreach ($stok_bahan as $d)
                                            @php
                                                $saldo_bahan_lalu = $d->harga_jual_lalu;
                                                $pengeluaran_bahan_lalu = $d->harga_beli_lalu;
                                                $sisa_saldo_bahan_lalu = $saldo_bahan_lalu - $pengeluaran_bahan_lalu;
                                                $saldo_bahan = $d->harga_jual;
                                                $pengeluaran_bahan = $d->harga_beli;
                                                $sisa_saldo_bahan = $saldo_bahan - $pengeluaran_bahan;
                                                $aktual_bahan = $sisa_saldo_bahan_lalu + $sisa_saldo_bahan;

                                                $tot_saldo_lalu_bahan += $saldo_bahan_lalu;
                                                $tot_pengeluaran_bahan_lalu += $pengeluaran_bahan_lalu;
                                                $tot_sisa_saldo_bahan_lalu += $sisa_saldo_bahan_lalu;
                                                $tot_saldo_bahan += $saldo_bahan;
                                                $tot_pengeluaran_bahan += $pengeluaran_bahan;
                                                $tot_sisa_saldo_bahan += $sisa_saldo_bahan;
                                                $tot_aktual_bahan += $aktual_bahan;
                                            @endphp
                                            <tr class="text-center">
                                                <td class="text-start">{{ $d->bahan->bahan }}</td>
                                                <td>{{ number_format($saldo_bahan_lalu, 0) }}</td>
                                                <td>{{ number_format($pengeluaran_bahan_lalu, 0) }}</td>
                                                <td>{{ number_format($sisa_saldo_bahan_lalu, 0) }}</td>
                                                <td>{{ number_format($saldo_bahan, 0) }}</td>
                                                <td>{{ number_format($pengeluaran_bahan, 0) }}</td>
                                                <td>{{ number_format($sisa_saldo_bahan, 0) }}</td>
                                                <td>{{ number_format($aktual_bahan, 0) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="text-center">
                                            <td class="text-start"><strong>Total Bahan</strong></td>
                                            <td><strong>{{ number_format($tot_saldo_lalu_bahan, 0) }}</strong></td>
                                            <td><strong>{{ number_format($tot_pengeluaran_bahan_lalu, 0) }}</strong></td>
                                            <td><strong>{{ number_format($tot_sisa_saldo_bahan_lalu, 0) }}</strong></td>
                                            <td><strong>{{ number_format($tot_saldo_bahan, 0) }}</strong></td>
                                            <td><strong>{{ number_format($tot_pengeluaran_bahan, 0) }}</strong></td>
                                            <td><strong>{{ number_format($tot_sisa_saldo_bahan, 0) }}</strong></td>
                                            <td><strong>{{ number_format($tot_aktual_bahan, 0) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" class="bg-primary text-light"><strong>Oprasional</strong>
                                            </td>
                                        </tr>
                                        @php
                                            $tot_saldo_lalu_pengeluaran = 0;
                                            $tot_pengeluaran_pengeluaran_lalu = 0;
                                            $tot_sisa_saldo_pengeluaran_lalu = 0;
                                            $tot_saldo_pengeluaran = 0;
                                            $tot_pengeluaran_pengeluaran = 0;
                                            $tot_sisa_saldo_pengeluaran = 0;
                                            $tot_aktual_pengeluaran = 0;
                                        @endphp
                                        @foreach ($pengeluaran as $d)
                                            @php
                                                $saldo_pengeluaran = $d->ttl_pengeluaran;
                                                $pengeluaran_pengeluaran = $d->ttl_pengeluaran;
                                                $sisa_saldo_pengeluaran = $saldo_pengeluaran - $pengeluaran_pengeluaran;
                                                $aktual_pengeluaran = $sisa_saldo_pengeluaran;

                                                $tot_saldo_pengeluaran += $saldo_pengeluaran;
                                                $tot_pengeluaran_pengeluaran += $pengeluaran_pengeluaran;
                                                $tot_sisa_saldo_pengeluaran += $sisa_saldo_pengeluaran;
                                                $tot_aktual_pengeluaran += $aktual_pengeluaran;
                                            @endphp
                                            <tr class="text-center">
                                                <td class="text-start">{{ $d->akun->nm_akun }}</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>{{ number_format($saldo_pengeluaran, 0) }}</td>
                                                <td>{{ number_format($pengeluaran_pengeluaran, 0) }}</td>
                                                <td>{{ number_format($sisa_saldo_pengeluaran, 0) }}</td>
                                                <td>{{ number_format($aktual_pengeluaran, 0) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="text-center">
                                            <td class="text-start"><strong>Total Oprasional</strong></td>
                                            <td><strong>{{ number_format($tot_saldo_lalu_pengeluaran, 0) }}</strong></td>
                                            <td><strong>{{ number_format($tot_pengeluaran_pengeluaran_lalu, 0) }}</strong>
                                            </td>
                                            <td><strong>{{ number_format($tot_sisa_saldo_pengeluaran_lalu, 0) }}</strong>
                                            </td>
                                            <td><strong>{{ number_format($tot_saldo_pengeluaran, 0) }}</strong></td>
                                            <td><strong>{{ number_format($tot_pengeluaran_pengeluaran, 0) }}</strong></td>
                                            <td><strong>{{ number_format($tot_sisa_saldo_pengeluaran, 0) }}</strong></td>
                                            <td><strong>{{ number_format($tot_aktual_pengeluaran, 0) }}</strong></td>
                                        </tr>

                                        <tr>
                                            <td colspan="8" class="bg-primary text-light"><strong>Gaji</strong>
                                            </td>
                                        </tr>
                                        @php
                                            $tot_saldo_lalu_gapok = 0;
                                            $tot_gapok_gaji_lalu = 0;
                                            $tot_sisa_saldo_gapok_lalu = 0;
                                            $tot_saldo_gapok = 0;
                                            $tot_gapok_gaji = 0;
                                            $tot_sisa_saldo_gapok = 0;
                                            $tot_aktual_gapok = 0;
                                        @endphp
                                        @foreach ($gapok as $d)
                                            @php
                                                $saldo_gapok = $d->ttl_gapok;
                                                $gapok_gaji = $d->ttl_gapok;
                                                $sisa_saldo_gapok = $saldo_gapok - $gapok_gaji;
                                                $aktual_gapok = $sisa_saldo_gapok;

                                                $tot_saldo_gapok += $saldo_gapok;
                                                $tot_gapok_gaji += $gapok_gaji;
                                                $tot_sisa_saldo_gapok += $sisa_saldo_gapok;
                                                $tot_aktual_gapok += $aktual_gapok;
                                            @endphp
                                            <tr class="text-center">
                                                <td class="text-start">{{ $d->karyawan->nama }}</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>{{ number_format($saldo_gapok, 0) }}</td>
                                                <td>{{ number_format($gapok_gaji, 0) }}</td>
                                                <td>{{ number_format($sisa_saldo_gapok, 0) }}</td>
                                                <td>{{ number_format($aktual_gapok, 0) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="text-center">
                                            <td class="text-start"><strong>Total Gaji</strong></td>
                                            <td><strong>{{ number_format($tot_saldo_lalu_gapok, 0) }}</strong></td>
                                            <td><strong>{{ number_format($tot_gapok_gaji_lalu, 0) }}</strong>
                                            </td>
                                            <td><strong>{{ number_format($tot_sisa_saldo_gapok_lalu, 0) }}</strong>
                                            </td>
                                            <td><strong>{{ number_format($tot_saldo_gapok, 0) }}</strong></td>
                                            <td><strong>{{ number_format($tot_gapok_gaji, 0) }}</strong></td>
                                            <td><strong>{{ number_format($tot_sisa_saldo_gapok, 0) }}</strong></td>
                                            <td><strong>{{ number_format($tot_aktual_gapok, 0) }}</strong></td>
                                        </tr>

                                        <tr>
                                            <td colspan="8" class="bg-primary text-light"><strong>Laba dan
                                                    Investor</strong>
                                            </td>
                                        </tr>
                                        @php
                                            $tot_laba =
                                                $saldo_penjualan -
                                                $tot_saldo_bahan -
                                                $tot_saldo_pengeluaran -
                                                $tot_saldo_gapok;
                                            $tot_investor = 0;
                                            foreach ($investor as $d) {
                                                $tot_investor += $d->ttl_investor;
                                            }
                                        @endphp
                                        @foreach ($investor as $d)
                                            @php
                                                $persen_investor =
                                                    $d->ttl_investor > 0 ? ($d->ttl_investor / $tot_investor) * 100 : 0;
                                                $jlm_investor =
                                                    $persen_investor > 0 && $tot_laba > 0
                                                        ? ($tot_laba * $persen_investor) / 100
                                                        : 0;
                                            @endphp
                                            <tr class="text-center">
                                                <td class="text-start">{{ $d->investor->nm_investor }}
                                                    {{ number_format($persen_investor, 2) }}%</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ number_format($jlm_investor, 0) }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                        <tr class="text-center">
                                            <td class="text-start"><strong>Total Laba</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>{{ number_format($tot_laba, 0) }}</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- end page-content-wrapper -->
    </div>
    <!-- End Page-content -->




@section('script')
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
