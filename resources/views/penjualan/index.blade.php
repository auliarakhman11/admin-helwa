@extends('template.master')

@section('content')
    <!-- Content -->

    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Penjualan</h4>
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
                            <div class="card-header">
                                <h4>List Penjualan</h4>
                            </div>
                            <div class="card-body">
                                <table id="datatable" class="tabledt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Waktu</th>
                                            <th>Customer</th>
                                            <th>Jenis Pembayaran</th>
                                            <th>Total<br>Produk</th>
                                            <th>Total<br>Tagihan</th>
                                            <th>Kasir</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $total = 0;
                                        @endphp
                                        @foreach ($invoice as $inv)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ date('d M Y H:i', strtotime($inv->created_at)) }}</td>
                                                <td>{{ $inv->nm_customer }}</td>
                                                <td>{{ $inv->pembayaran->pembayaran }}</td>
                                                <td>
                                                    @php
                                                        $ttl_produk = 0;
                                                        $total += $inv->total + $inv->pembulatan - $inv->diskon;
                                                    @endphp
                                                    @foreach ($inv->penjualan as $p)
                                                        @php
                                                            $ttl_produk += $p->qty;
                                                        @endphp
                                                    @endforeach
                                                    {{ number_format($ttl_produk, 0) }}
                                                </td>
                                                <td>{{ number_format($inv->total + $inv->pembulatan - $inv->diskon, 0) }}
                                                </td>
                                                <td>

                                                    @foreach ($inv->penjualanKaryawan as $k)
                                                        {{ $k->karyawan->nama }},
                                                    @endforeach

                                                </td>
                                                <td width="20%">
                                                    <button type="button" class="btn btn-sm btn-primary mt-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal_detail{{ $inv->id }}">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#modal_refund{{ $inv->id }}"
                                                        class="btn btn-sm btn-danger mt-2"><i class="fas fa-sync"></i>
                                                        Refund</button>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5"><strong>Total</strong></td>
                                            <td><strong>{{ number_format($total, 0) }}</strong></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->


            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>List Refund</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Waktu</th>
                                            <th>Customer</th>
                                            <th>Jenis Pembayaran</th>
                                            <th>Total<br>Produk</th>
                                            <th>Total<br>Tagihan</th>
                                            <th>Kasir</th>
                                            <th>Alasan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $total = 0;
                                        @endphp
                                        @foreach ($invoice_refund as $in)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ date('d M Y H:i', strtotime($in->created_at)) }}</td>
                                                <td>{{ $in->nm_customer }}</td>
                                                <td>{{ $in->pembayaran->pembayaran }}</td>
                                                <td>
                                                    @php
                                                        $ttl_produk = 0;
                                                        $total += $in->total + $in->pembulatan - $in->diskon;
                                                    @endphp
                                                    @foreach ($in->penjualan as $p)
                                                        @php
                                                            $ttl_produk += $p->qty;
                                                        @endphp
                                                    @endforeach
                                                    {{ number_format($ttl_produk, 0) }}
                                                </td>
                                                <td>{{ number_format($in->total + $in->pembulatan - $in->diskon, 0) }}</td>
                                                <td>

                                                    @foreach ($in->penjualanKaryawan as $k)
                                                        {{ $k->karyawan->nama }},
                                                    @endforeach

                                                </td>
                                                <td>{{ $in->ket_void }}</td>
                                                <td width="20%">
                                                    <button type="button" class="btn btn-sm btn-primary mt-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal_detail_refund{{ $in->id }}">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#modal_kembali_refund{{ $in->id }}"
                                                        class="btn btn-sm btn-warning text-dark mt-2"><i
                                                            class="fas fa-sync"></i>
                                                        Kembalikan</button>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    {{-- <tfoot>
                                        <tr>
                                            <td colspan="4"><strong>Total</strong></td>
                                            <td><strong>{{ number_format($total, 0) }}</strong></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tfoot> --}}
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

    @foreach ($invoice as $d)
        <div id="modal_detail{{ $d->id }}" class="modal fade modal-detail" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabeldetail" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white mt-0" id="myModalLabeldetail">Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Produk</th>
                                    <th>Ukuran</th>
                                    <th>Qty x Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                    $total = 0;
                                @endphp
                                @foreach ($d->penjualan as $p)
                                    @php
                                        $total += $p->total;
                                    @endphp
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $p->mix == 1 ? $p->ket_mix : $p->getMenu->ganti_nama }}
                                            ({{ $p->cluster->nm_cluster }})
                                        </td>
                                        <td>{{ $p->ukuran }} ml</td>
                                        <td>{{ $p->qty }} x {{ number_format($p->harga, 0) }}</td>
                                        <td>{{ number_format($p->total, 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"><strong>Subtotal</strong></td>
                                    <td><strong>{{ number_format($total, 0) }}</strong></td>
                                </tr>
                                @if ($d->diskon > 0)
                                    <tr>
                                        <td colspan="4"><strong>Diskon</strong></td>
                                        <td><strong>{{ number_format($d->diskon, 0) }}</strong></td>
                                    </tr>
                                @endif
                                @if ($d->pembulatan > 0)
                                    <tr>
                                        <td colspan="4"><strong>Pembulatan</strong></td>
                                        <td><strong>{{ number_format($d->pembulatan, 0) }}</strong></td>
                                    </tr>
                                @endif

                                <tr>
                                    <td colspan="4"><strong>Grand Total</strong></td>
                                    <td><strong>{{ number_format($total + $d->pembulatan - $d->diskon, 0) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        <form action="{{ route('refundInvoice') }}" method="post">
            @csrf
            <div id="modal_refund{{ $d->id }}" class="modal fade modal-refund" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabelrefund" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white mt-0" id="myModalLabelrefund">Refund</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span class="mdi mdi-close"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="invoice_id" value="{{ $d->id }}">

                            <p>Apakah anda yakin ingin merefund invoice?</p>

                            <input type="text" name="ket_void" class="form-control"
                                placeholder="Masukan Alasan Refund ..." required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Refund</button>

                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        </form>
    @endforeach

    @foreach ($invoice_refund as $d)
        <div id="modal_detail_refund{{ $d->id }}" class="modal fade modal-detail" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabeldetail" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white mt-0" id="myModalLabeldetail">Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Produk</th>
                                    <th>Ukuran</th>
                                    <th>Qty x Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                    $total = 0;
                                @endphp
                                @foreach ($d->penjualan as $p)
                                    @php
                                        $total += $p->total;
                                    @endphp
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $p->mix == 1 ? $p->ket_mix : $p->getMenu->ganti_nama }}
                                            ({{ $p->cluster->nm_cluster }})</td>
                                        <td>{{ $p->ukuran }} ml</td>
                                        <td>{{ $p->qty }} x {{ number_format($p->harga, 0) }}</td>
                                        <td>{{ number_format($p->total, 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"><strong>Subtotal</strong></td>
                                    <td><strong>{{ number_format($total, 0) }}</strong></td>
                                </tr>
                                @if ($d->diskon > 0)
                                    <tr>
                                        <td colspan="4"><strong>Diskon</strong></td>
                                        <td><strong>{{ number_format($d->diskon, 0) }}</strong></td>
                                    </tr>
                                @endif
                                @if ($d->pembulatan > 0)
                                    <tr>
                                        <td colspan="4"><strong>Pembulatan</strong></td>
                                        <td><strong>{{ number_format($d->pembulatan, 0) }}</strong></td>
                                    </tr>
                                @endif

                                <tr>
                                    <td colspan="4"><strong>Grand Total</strong></td>
                                    <td><strong>{{ number_format($total + $d->pembulatan - $d->diskon, 0) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Close</button>

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        <form action="{{ route('kembalikanInvoice') }}" method="post">
            @csrf
            <div id="modal_kembali_refund{{ $d->id }}" class="modal fade modal-refund" tabindex="-1"
                role="dialog" aria-labelledby="myModalLabelrefund" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white mt-0" id="myModalLabelrefund">Refund</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span class="mdi mdi-close"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="invoice_id" value="{{ $d->id }}">

                            <p>Apakah anda yakin ingin mengembalikan invoice?</p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Kembalikan</button>

                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        </form>
    @endforeach

    <form action="" method="GET">
        <div id="modal_view" class="modal fade modal-view" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabelview" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white mt-0" id="myModalLabelview">View</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Dari</label>
                                    <input type="date" name="tgl1" class="form-control"
                                        value="{{ $tgl1 }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Sampai</label>
                                    <input type="date" name="tgl2" class="form-control"
                                        value="{{ $tgl2 }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">View</button>

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


        });
    </script>
@endsection
@endsection
