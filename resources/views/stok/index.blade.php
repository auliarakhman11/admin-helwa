@extends('template.master')

@section('content')
    <!-- Content -->

    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12 col-md-4">
                        <h4 class="page-title mb-1">Laporan Stok Outlet</h4>
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
                                <div class="col-3">
                                    <button type="submit" class="btn btn-light float-end mt-4">
                                        <i class="fa fa-search"></i>
                                        Cari
                                    </button>
                                </div>
                            </div>
                            {{-- <div class="row justify-content-end">
                                <div class="col-12">
                                    <button type="button" class="btn btn-sm btn-light float-end mt-4"
                                        data-bs-toggle="modal" data-bs-target="#modal_saldo_awal">
                                        <i class="fa fa-plus"></i>
                                        Saldo Awal
                                    </button>
                                </div>
                            </div> --}}
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
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Barang</th>
                                            <th>Stok Awal<br>Berjalan</th>
                                            <th>Stok Masuk</th>
                                            <th>Stok Keluar</th>
                                            <th>Stok Update</th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        @foreach ($bahan as $b)
                                            <tr>
                                                <td>{{ $b->bahan }}</td>
                                                <td class="text-center">
                                                    {{ round($b->qty_masuk_lalu - $b->qty_keluar_lalu) }}</td>
                                                <td class="text-center">{{ round($b->qty_masuk) }}</td>
                                                <td class="text-center">{{ round($b->qty_keluar) }}</td>
                                                <td class="text-center">
                                                    {{ round($b->qty_masuk_lalu - $b->qty_keluar_lalu + ($b->qty_masuk - $b->qty_keluar)) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($produk as $p)
                                            <tr>
                                                <td>{{ $p->nm_produk }}</td>
                                                <td class="text-center">
                                                    {{ round($p->qty_masuk_lalu - $p->qty_keluar_lalu) }}</td>
                                                <td class="text-center">{{ round($p->qty_masuk) }}</td>
                                                <td class="text-center">{{ round($p->qty_keluar) }}</td>
                                                <td class="text-center">
                                                    {{ round($p->qty_masuk_lalu - $p->qty_keluar_lalu + ($p->qty_masuk - $p->qty_keluar)) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </thead>
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

    {{-- <form action="{{ route('addPengeluaran') }}" method="post">
        @csrf
        <div id="modal_saldo_awal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabeltambah"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabeltambah">Tambah Saldo Awal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <input type="hidden" value="{{ $tgl1 }}" required>

                            <div class="col-md-6 col-12">
                                <label>Barang</label>
                                <select name="produk_id" class="form-control" required>
                                    <option value="">Pilih Barang</option>
                                    @foreach ($bahan as $b)
                                        <option value="{{ $b->id }}">{{ $b->bahan }}</option>
                                    @endforeach
                                    @foreach ($produk as $p)
                                        <option value="{{ $p->id }}">{{ $p->nm_produk }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 col-12">
                                <label>Jenis</label>
                                <select name="jenis" class="form-control" id="jenis" required>
                                    <option value="1">Kas</option>
                                    <option value="2">Laba</option>
                                    <option value="3">QRIS/Transfer</option>
                                </select>
                            </div>

                            <div class="col-md-6 col-12">
                                <label>Jumlah</label>
                                <input type="number" name="jumlah" class="form-control" required>
                            </div>

                            <div class="col-md-6 col-12">
                                <label>Keterangan</label>
                                <input type="text" name="ket" class="form-control" required>
                            </div>



                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </form> --}}




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
