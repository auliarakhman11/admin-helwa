@extends('template.master')

@section('content')
    <!-- Content -->

    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Persentase Investor</h4>
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
                                <h5 class="float-start">Persentase</h5>

                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-striped"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Cabang</th>
                                            <th>Investor</th>
                                            <th>Persentase</th>
                                            <th>Jumlah Investasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $tot = 0;
                                        @endphp
                                        @foreach ($dt_cabang as $c)
                                            @php
                                                $dat_investor = $dt_investor->where('cabang_id',$c->id)->all();
                                            @endphp
                                            @foreach ($dat_investor as $d)
                                            @php
                                                $tot += $d->jml_pengeluaran;
                                            @endphp
                                                <tr>
                                                    <td>{{ $d->nama }}</td>
                                                    <td>{{ $d->nm_investor }}</td>
                                                    <td>{{ $d->jml_pengeluaran > 0 && $c->jml_pengeluaran > 0 ? number_format($d->jml_pengeluaran / $c->jml_pengeluaran * 100,2) : 0  }}%</td>
                                                    <td>{{ number_format($d->jml_pengeluaran,0) }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3"><strong>Total</strong></td>
                                            <td>{{ number_format($tot,0) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>

        <div class="page-content-wrapper mt-2">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-start">Pengeluaran Investor</h5>
                                <button type="button" class="btn btn-sm btn-primary float-end" data-bs-toggle="modal"
                                    data-bs-target="#modal_tambah">
                                    <i class="fa fa-plus-circle"></i>
                                    Tambah Pengeluaran
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="datatable" class="tabledt-responsive nowrap table-striped"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Investor</th>
                                            <th>Cabang</th>
                                            <th>Keterangan</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($pengeluaran as $d)
                                            <tr>
                                                {{-- <td><img src="{{ asset('') }}{{ $k->foto }}" alt="" height="40px"></td> --}}
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $d->investor->nm_investor }}</td>
                                                <td>{{ $d->cabang->nama }}</td>
                                                <td>{{ $d->ket }}</td>
                                                <td>{{ number_format($d->jumlah,0) }}</td>
                                                <td>{{ date('d/m/Y', strtotime($d->tgl)) }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal_edit{{ $d->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    <form class="d-inline-block" action="{{ route('dropPengeluaranInvestor') }}"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $d->id }}">
                                                        <input type="hidden" name="tgl" value="{{ $d->tgl }}">
                                                        <input type="hidden" name="cabang_id" value="{{ $d->cabang_id }}">
                                                        <button type="submit"
                                                            onclick="return confirm('Apakah anda yakin ingin menghapus data karyawan?')"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach

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

    <form action="{{ route('addPengeluaranInvestor') }}" method="post">
        @csrf
        <div id="modal_tambah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabeltambah"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabeltambah">Tambah Member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-12">
                                <label>Tanggal</label>
                                <input type="date" name="tgl" class="form-control" max="{{ date('Y-m-d') }}"
                                    required>
                            </div>

                            <div class="col-12">
                                <label>Investor</label>
                                <select name="investor_id" class="form-control" required>
                                    <option value="">Pilih Investor</option>
                                    @foreach ($investor as $in)
                                        <option value="{{ $in->id }}">{{ $in->nm_investor }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label>cabang</label>
                                <select name="cabang_id" class="form-control" required>
                                    @foreach ($cabang as $c)
                                        <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label>Keterangan</label>
                                <input type="text" name="ket" class="form-control"
                                    required>
                            </div>

                            <div class="col-12">
                                <label>Jumlah</label>
                                <input type="number" name="jumlah" class="form-control"
                                    required>
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
    </form>



    @foreach ($pengeluaran as $d)
        <form action="{{ route('editPengeluaranInvestor') }}" method="post">
            @csrf
            @method('patch')
            <div class="modal fade" id="modal_edit{{ $d->id }}" role="dialog"
                aria-labelledby="exampleModalLabelEdit" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabelEdit">Edit Diskon</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span class="mdi mdi-close"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="id" value="{{ $d->id }}">
                                
                                {{-- <div class="col-12">
                                    <label>Tanggal</label>
                                    <input type="date" name="tgl" value="{{ $d->tgl }}" class="form-control" max="{{ date('Y-m-d') }}"
                                        required>
                                </div> --}}

                                <div class="col-12">
                                    <label>Investor</label>
                                    <select name="investor_id" class="form-control" required>
                                        <option value="">Pilih Investor</option>
                                        @foreach ($investor as $in)
                                            <option value="{{ $in->id }}" {{ $d->investor_id == $in->id ? 'selected' : '' }}>{{ $in->nm_investor }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label>cabang</label>
                                    <select name="cabang_id" class="form-control" required>
                                        @foreach ($cabang as $c)
                                            <option value="{{ $c->id }}" {{ $d->cabang_id == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label>Keterangan</label>
                                    <input type="text" name="ket" class="form-control" value="{{ $d->ket }}"
                                        required>
                                </div>

                                <div class="col-12">
                                    <label>Jumlah</label>
                                    <input type="number" name="jumlah" class="form-control" value="{{ $d->jumlah }}"
                                        required>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach




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
