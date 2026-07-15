@extends('template.master')

@section('content')
    <!-- Content -->


    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12 col-md-4">
                        <h4 class="page-title mb-1">Laporan Stok Gudang</h4>
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
                                        <input type="date" name="tgl1" id="tgl1" value="{{ $tgl1 }}"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="text-light" for="">Sampai</label>
                                        <input type="date" name="tgl2" id="tgl2" value="{{ $tgl2 }}"
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
                        </form>

                        <div class="row justify-content-end">
                            <div class="col-3">
                                <button type="button" class="btn btn-sm btn-light float-end mt-4" data-bs-toggle="modal"
                                    data-bs-target="#modal_invoice" id="btn_invoice"><i
                                        class="fas fa-file-invoice-dollar"></i> List Invoice</button>
                            </div>
                            <div class="col-3">
                                <button type="button" class="btn btn-sm btn-light float-end mt-4" data-bs-toggle="modal"
                                    data-bs-target="#modal_stok_masuk">
                                    <i class="fa fa-plus"></i>
                                    Stok Masuk
                                </button>
                            </div>
                            <div class="col-3">
                                <button type="button" class="btn btn-sm btn-light float-end mt-4" data-bs-toggle="modal"
                                    data-bs-target="#modal_stok_keluar">
                                    <i class="fa fa-plus"></i>
                                    Stok Keluar
                                </button>
                            </div>
                        </div>


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

    <div id="modal_detail_invoice" class="modal fade" role="dialog" aria-labelledby="myModalLabelDetailInvoice"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabelDetailInvoice">Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="mdi mdi-close"></span>
                    </button>
                </div>
                <div class="modal-body" id="table_detail_invoice">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="modal_invoice" class="modal fade" role="dialog" aria-labelledby="myModalLabelInvoice" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabelInvoice">Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="mdi mdi-close"></span>
                    </button>
                </div>
                <div class="modal-body" id="table_invoice">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <form id="formAddStokMasukGudang" action="{{ route('addStokMasukGudang') }}" method="post">
        @csrf
        <div id="modal_stok_masuk" class="modal fade" role="dialog" aria-labelledby="myModalLabeltambah"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabeltambah">Tambah Stok Masuk Gudang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6 col-12">
                                <label>Tanggal</label>
                                <input type="date" name="tgl" class="form-control" required>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4 col-12">
                                <label>Barang</label>
                                <select name="produk_id[]" class="form-control select2bs4" required>
                                    <option value="">Pilih Barang</option>
                                    @foreach ($bahan as $b)
                                        <option value="{{ $b->id }}|2">{{ $b->bahan }}</option>
                                    @endforeach
                                    @foreach ($produk as $p)
                                        <option value="{{ $p->id }}|1">{{ $p->nm_produk }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 col-12">
                                <label>Qty</label>
                                <input type="number" name="qty[]" class="form-control" required>
                            </div>

                            <div class="col-md-3 col-12">
                                <label>Harga</label>
                                <input type="number" name="harga[]" class="form-control" required>
                            </div>

                        </div>

                        <div id="table_tambah_stok_masuk_gudang"></div>


                        <button type="button" id="btn_tambah_stok_masuk_gudang"
                            class="btn btn-primary btn-sm float-end mt-3"><i class="fas fa-plus"></i></button>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="buttonAddStokMasukGudang"
                            class="btn btn-primary waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </form>

    <form id="formAddStokKeluarGudang" action="{{ route('addStokKeluarGudang') }}" method="post">
        @csrf
        <div id="modal_stok_keluar" class="modal fade" role="dialog" aria-labelledby="myModalLabeltambah"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabeltambah">Tambah Stok Keluar Gudang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6 col-12">
                                <label>Tanggal</label>
                                <input type="date" name="tgl" class="form-control" required>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4 col-12">
                                <label>Barang</label>
                                <select name="produk_id[]" class="form-control select2bs4 produk_id" id="produk_id0"
                                    urutan="0" required>
                                    <option value="">Pilih Barang</option>
                                    @foreach ($bahan as $b)
                                        <option value="{{ $b->id }}|2">{{ $b->bahan }}</option>
                                    @endforeach
                                    @foreach ($produk as $p)
                                        <option value="{{ $p->id }}|1">{{ $p->nm_produk }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 col-12">
                                <label>Qty</label>
                                <input type="number" name="qty[]" class="form-control qty" id="qty0"
                                    urutan="0" required>
                            </div>

                            <div class="col-md-3 col-12">
                                <label>Harga</label>
                                <input type="number" name="harga[]" class="form-control" id="harga0" required>
                                <input type="hidden" name="harga_normal[]" class="form-control" id="harga_normal0"
                                    required>
                            </div>

                        </div>

                        <div id="table_tambah_stok_keluar_gudang"></div>


                        <button type="button" id="btn_tambah_stok_keluar_gudang"
                            class="btn btn-primary btn-sm float-end mt-3"><i class="fas fa-plus"></i></button>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light"
                            id="buttonAddStokKeluarGudang">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </form>




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


            //stok masuk
            var count_tambah_masuk_gudang = 1;
            $(document).on('click', '#btn_tambah_stok_masuk_gudang', function() {
                count_tambah_masuk_gudang = count_tambah_masuk_gudang + 1;
                var html_code = '<div class="row mt-2" id="row' + count_tambah_masuk_gudang + '" >';

                html_code +=
                    '<div class="col-md-4 col-12"><select name="produk_id[]" class="form-control select2bs4" required><option value="">Pilih Barang</option>@foreach ($bahan as $b)<option value="{{ $b->id }}|2">{{ $b->bahan }}</option>@endforeach @foreach ($produk as $p)<option value="{{ $p->id }}|1">{{ $p->nm_produk }}</option>@endforeach</select></div>';

                html_code +=
                    '<div class="col-md-3 col-12"><input type="number" name="qty[]" class="form-control" required></div>';

                html_code +=
                    '<div class="col-md-3 col-12"><input type="number" name="harga[]" class="form-control" required></div>';

                html_code += '<div class="col-2"><button type="button" data-row="row' +
                    count_tambah_masuk_gudang +
                    '" class="btn btn-danger btn-sm remove_tambah_masuk_gudang"><i class="fas fa-minus"></></button></div>';

                html_code += "</div>";

                $('#table_tambah_stok_masuk_gudang').append(html_code);
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });

                $('.select2bs4').each(function() {
                    $(this).select2({
                        theme: 'bootstrap4',
                        dropdownParent: $(this).parent(),
                    });
                });

            });

            $(document).on('click', '.remove_tambah_masuk_gudang', function() {
                var delete_row = $(this).data("row");
                $('#' + delete_row).remove();
            });

            $(document).on('submit', '#formAddStokMasukGudang', function(event) {
                // event.preventDefault();
                $('#buttonAddStokMasukGudang').attr('disabled', true);
                $('#buttonAddStokMasukGudang').html(
                    'Loading... <div class="spinner-border text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'
                );
            });

            //endstokkeluar

            //stok keluar
            var count_tambah_keluar_gudang = 1;
            $(document).on('click', '#btn_tambah_stok_keluar_gudang', function() {
                count_tambah_keluar_gudang = count_tambah_keluar_gudang + 1;
                var html_code = '<div class="row mt-2" id="row' + count_tambah_keluar_gudang + '" >';

                html_code +=
                    '<div class="col-md-4 col-12"><select name="produk_id[]" class="form-control select2bs4 produk_id" id="produk_id' +
                    count_tambah_keluar_gudang + '" urutan="' + count_tambah_keluar_gudang +
                    '" required><option value="">Pilih Barang</option>@foreach ($bahan as $b)<option value="{{ $b->id }}|2">{{ $b->bahan }}</option>@endforeach @foreach ($produk as $p)<option value="{{ $p->id }}|1">{{ $p->nm_produk }}</option>@endforeach</select></div>';

                html_code +=
                    '<div class="col-md-3 col-12"><input type="number" name="qty[]" class="form-control qty" id="qty' +
                    count_tambah_keluar_gudang + '" urutan="' + count_tambah_keluar_gudang +
                    '" required></div>';

                html_code +=
                    '<div class="col-md-3 col-12"><input type="number" name="harga[]" class="form-control" id="harga' +
                    count_tambah_keluar_gudang +
                    '" required><input type="hidden" name="harga_normal[]" class="form-control" id="harga_normal' +
                    count_tambah_keluar_gudang + '" required></div>';

                html_code += '<div class="col-2"><button type="button" data-row="row' +
                    count_tambah_keluar_gudang +
                    '" class="btn btn-danger btn-sm remove_tambah_keluar_gudang"><i class="fas fa-minus"></></button></div>';

                html_code += "</div>";

                $('#table_tambah_stok_keluar_gudang').append(html_code);
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });

                $('.select2bs4').each(function() {
                    $(this).select2({
                        theme: 'bootstrap4',
                        dropdownParent: $(this).parent(),
                    });
                });

            });

            $(document).on('click', '.remove_tambah_keluar_gudang', function() {
                var delete_row = $(this).data("row");
                $('#' + delete_row).remove();
            });

            $(document).on('submit', '#formAddStokKeluarGudang', function(event) {
                // event.preventDefault();
                $('#buttonAddStokKeluarGudang').attr('disabled', true);
                $('#buttonAddStokKeluarGudang').html(
                    'Loading... <div class="spinner-border text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'
                );
            });

            //endstokkeluar

            $(document).on('change', '.produk_id', function() {
                var urutan = $(this).attr('urutan');
                var qty = $('#qty' + urutan).val();
                var dt_produk_id = $('#produk_id' + urutan).val();
                var produk_id = dt_produk_id.split("|");

                // console.log('urutan ' + urutan);
                // console.log('qty ' + qty);
                // console.log('bahan ' + dt_produk_id);

                $('#harga' + urutan).val('');
                // $("#total_keluar").html('Loading...');



                if (qty && dt_produk_id) {
                    $.ajax({
                        url: "{{ route('getHarga') }}",
                        method: "GET",
                        dataType: "JSON",
                        data: {
                            produk_id: produk_id[0],
                            jenis_bahan: produk_id[1]
                        },
                        success: function(data) {
                            // console.log(data.harga_beli);

                            var harga_normal = parseInt(data.harga_beli) * parseInt(qty);
                            $('#harga_normal' + urutan).val(harga_normal);

                            var harga = parseInt(data.harga_jual) * parseInt(qty);
                            // var total_uang = new Intl.NumberFormat().format(harga);
                            $('#harga' + urutan).val(harga);

                            // var uang_keluar = 0;

                            // $(".uang_keluar").each(function() {
                            //     var data_uang = $(this).val();
                            //     var uang = data_uang.replace(/\D/g, "");
                            //     uang_keluar += parseFloat(uang);
                            // });

                            // var total_uang = new Intl.NumberFormat().format(uang_keluar);

                            // $("#total_keluar").html(total_uang);

                        }

                    });
                }

            });

            // Variabel global (di luar event) agar timer tidak tumpang tindih
            let timerMengetik;
            const waktuTunggu = 500; // Jeda 0.5 detik

            $(document).on('keyup', '.qty', function() {
                var urutan = $(this).attr('urutan');
                var qty = $('#qty' + urutan).val();
                var dt_produk_id = $('#produk_id' + urutan).val();
                var produk_id = dt_produk_id.split("|");

                // console.log('urutan ' + urutan);
                // console.log('qty ' + qty);
                // console.log('bahan ' + dt_produk_id);


                // $("#total_keluar").html('Loading...');

                clearTimeout(timerMengetik);

                timerMengetik = setTimeout(function() {
                    $('#harga' + urutan).val('');

                    if (qty && dt_produk_id) {
                        $.ajax({
                            url: "{{ route('getHarga') }}",
                            method: "GET",
                            dataType: "JSON",
                            data: {
                                produk_id: produk_id[0],
                                jenis_bahan: produk_id[1]
                            },
                            success: function(data) {
                                // console.log(data.harga_beli);

                                var harga_normal = parseInt(data.harga_beli) * parseInt(
                                    qty);
                                $('#harga_normal' + urutan).val(harga_normal);

                                var harga = parseInt(data.harga_jual) * parseInt(qty);
                                // var total_uang = new Intl.NumberFormat().format(harga);
                                $('#harga' + urutan).val(harga);

                                // var uang_keluar = 0;

                                // $(".uang_keluar").each(function() {
                                //     var data_uang = $(this).val();
                                //     var uang = data_uang.replace(/\D/g, "");
                                //     uang_keluar += parseFloat(uang);
                                // });

                                // var total_uang = new Intl.NumberFormat().format(uang_keluar);

                                // $("#total_keluar").html(total_uang);

                            }

                        });
                    }

                }, waktuTunggu);


            });


            $(document).on('click', '#btn_invoice', function() {
                $('#table_invoice').html(
                    'Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>'
                );

                var tgl1 = $('#tgl1').val();
                var tgl2 = $('#tgl2').val();

                $.ajax({
                    url: "{{ route('getInvoiceGudang') }}",
                    method: "GET",
                    data: {
                        tgl1: tgl1,
                        tgl2: tgl2
                    },
                    success: function(data) {
                        $('#table_invoice').html(data);

                    }

                });

            });

            $(document).on('click', '.detail_invoice', function() {
                $('#table_detail_invoice').html(
                    'Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>'
                );

                var no_invoice = $(this).attr('no_invoice');

                $.ajax({
                    url: "{{ route('getDetailInvoiceGudang') }}",
                    method: "GET",
                    data: {
                        no_invoice: no_invoice
                    },
                    success: function(data) {
                        $('#table_detail_invoice').html(data);

                    }

                });

            });



        });
    </script>
@endsection
@endsection
