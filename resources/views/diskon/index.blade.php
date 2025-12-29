@extends('template.master')

@section('content')
    <!-- Content -->

    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Diskon</h4>
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
                            data-bs-target="#modal_tambah">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Diskon
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
                                            <th>Nama Diskon</th>
                                            <th>Jumlah Diskon</th>
                                            <th>Maksimal</th>
                                            <th>Expired</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($diskon as $d)
                                            <tr>
                                                {{-- <td><img src="{{ asset('') }}{{ $k->foto }}" alt="" height="40px"></td> --}}
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $d->nm_diskon }}</td>
                                                <td>
                                                    @if ($d->jml_diskon)
                                                        @if ($d->jml_diskon <= 100)
                                                            {{ $d->jml_diskon }}%
                                                        @else
                                                            Rp.{{ $d->jml_diskon }}
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($d->maksimal)
                                                        Rp.{{ $d->maksimal }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $d->exp_date ? date('d M Y', strtotime($d->exp_date)) : '-' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal_edit{{ $d->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    <form class="d-inline-block" action="{{ route('dropDiskon') }}"
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

    <form action="{{ route('addDiskon') }}" method="post">
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
                            <div class="col-12 col-md-6">
                                <label>Nama Diskon</label>
                                <input type="text" name="nm_diskon" class="form-control" placeholder="Masukan nama diskon"
                                    required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Jumlah Diskon</label>
                                <input type="number" name="jml_diskon" class="form-control" placeholder="Masukan jumlah"
                                    required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Maksimal</label>
                                <input type="number" name="maksimal" class="form-control" placeholder="Masukan jumlah maksimal"
                                    required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Expired Date</label>
                                <input type="date" name="exp_date" class="form-control" placeholder="Masukan expired date"
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



    @foreach ($diskon as $k)
        <form action="{{ route('editDiskon') }}" method="post">
            @csrf
            @method('patch')
            <div class="modal fade" id="modal_edit{{ $k->id }}" role="dialog"
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
                                <input type="hidden" name="id" value="{{ $k->id }}">
                                <div class="col-12 col-md-6">
                                <label>Nama Diskon</label>
                                <input type="text" name="nm_diskon" class="form-control" value="{{ $k->nm_diskon }}" placeholder="Masukan nama diskon"
                                    required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Jumlah Diskon</label>
                                <input type="number" name="jml_diskon" class="form-control" value="{{ $k->jml_diskon }}" placeholder="Masukan jumlah"
                                    required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Maksimal</label>
                                <input type="number" name="maksimal" class="form-control" value="{{ $k->maksimal }}" placeholder="Masukan jumlah maksimal"
                                    required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Expired Date</label>
                                <input type="date" name="exp_date" class="form-control" value="{{ $k->exp_date }}" placeholder="Masukan expired date"
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
