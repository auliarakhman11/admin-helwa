@extends('template.master')

@section('content')
    <!-- Content -->

    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">List Pengeluaran {{ date('d/m/Y', strtotime($tgl1)) }} s/d
                            {{ date('d/m/Y', strtotime($tgl2)) }}</h4>
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
                        <button type="button" class="btn btn-sm btn-light float-end ml-2" style="margin-left: 20px;"
                            data-bs-toggle="modal" data-bs-target="#modal_tambah">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Pengeluaran
                        </button>
                        <button type="button" class="btn btn-sm btn-light float-end mr-2" data-bs-toggle="modal"
                            data-bs-target="#modal_view">
                            <i class="fa fa-eye"></i>
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
                                <table id="datatable" class="tabledt-responsive nowrap table-striped"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Akun</th>
                                            <th>Jumlah</th>
                                            <th>Keterangan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($pengeluaran as $d)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ date('d/m/Y', strtotime($d->tgl)) }}</td>
                                                <td>
                                                    @if ($d->jenis == '1')
                                                        Kas
                                                    @else
                                                        Laba
                                                    @endif
                                                </td>
                                                <td>{{ $d->akun->nm_akun }}</td>
                                                <td>{{ number_format($d->jumlah, 0) }}</td>
                                                <td>{{ $d->ket }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal_edit{{ $d->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    <form class="d-inline-block" action="{{ route('dropPengeluaran') }}"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $d->id }}">
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
                                <label>Dari</label>
                                <input type="date" name="tgl1" value="{{ $tgl1 }}" class="form-control"
                                    required>
                            </div>

                            <div class="col-6">
                                <label>Sampai</label>
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

    <form action="{{ route('addPengeluaran') }}" method="post">
        @csrf
        <div id="modal_tambah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabeltambah"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabeltambah">Tambah Pengeluaran</h5>
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

                            <div class="col-md-6 col-12">
                                <label>Cabang</label>
                                <select name="cabang_id" class="form-control" required>
                                    @foreach ($cabang as $c)
                                        <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 col-12">
                                <label>Akun</label>
                                <select name="akun_id" class="form-control" required>
                                    <option value="">Pilih Akun</option>
                                    @foreach ($akun as $a)
                                        <option value="{{ $a->id }}">{{ $a->nm_akun }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 col-12">
                                <label>Jenis</label>
                                <select name="jenis" class="form-control" id="jenis" required>
                                    <option value="1">Kas</option>
                                    <option value="2">Laba</option>
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
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </form>



    @foreach ($pengeluaran as $p)
        <form action="{{ route('editPengeluaran') }}" method="post">
            @csrf
            @method('patch')
            <div class="modal fade" id="modal_edit{{ $p->id }}" role="dialog"
                aria-labelledby="exampleModalLabelEdit" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabelEdit">Edit Akun</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span class="mdi mdi-close"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="id" value="{{ $p->id }}">

                                <div class="col-md-6 col-12">
                                    <label>Tanggal</label>
                                    <input type="date" name="tgl" class="form-control"
                                        value="{{ $p->tgl }}" required>
                                </div>

                                <div class="col-12">
                                    <label>Cabang</label>
                                    <select name="cabang_id" class="form-control" required>
                                        @foreach ($cabang as $c)
                                            <option value="{{ $c->id }}"
                                                {{ $p->cabang_id == $c->id ? 'selected' : '' }}>{{ $c->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label>Akun</label>
                                    <select name="akun_id" class="form-control" required>
                                        <option value="">Pilih Akun</option>
                                        @foreach ($akun as $a)
                                            <option value="{{ $a->id }}"
                                                {{ $p->akun_id == $a->id ? 'selected' : '' }}>{{ $a->nm_akun }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 col-12">
                                    <label>Jenis</label>
                                    <select name="jenis" class="form-control" id="jenis" required>
                                        <option value="1" {{ $p->jenis == 1 ? 'selectd' : '' }}>Kas</option>
                                        <option value="2" {{ $p->jenis == 2 ? 'selectd' : '' }}>Laba</option>
                                    </select>
                                </div>


                                <div class="col-12">
                                    <label>Jumlah</label>
                                    <input type="number" name="jumlah" class="form-control"
                                        value="{{ $p->jumlah }}" required>
                                </div>

                                <div class="col-12">
                                    <label>Keterangan</label>
                                    <input type="text" name="ket" class="form-control"
                                        value="{{ $p->ket }}" required>
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

            $(document).on('change', '#jenis', function() {
                var jenis = $(this).val();
                if (jenis == 1) {
                    $('#investor_id').val('');
                    $("#investor_id").attr('disabled', 'disabled');
                } else {
                    $("#investor_id").removeAttr('disabled');
                }
            });


        });
    </script>
@endsection
@endsection
