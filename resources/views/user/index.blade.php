@extends('template.master')

@section('content')
    <!-- Content -->

    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">User</h4>
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
                            Tambah User
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
                                <table id="datatable" class="tabledt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($user as $d)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $d->name }}</td>
                                                <td>{{ $d->username }}</td>
                                                <td>{{ $d->role == 1 ? 'Super User' : 'Admin' }}</td>
                                                <td>
                                                    @if ($d->aktif == 1)
                                                        <p class="text-primary">Aktif</p>
                                                    @else
                                                        <p class="text-danger">Non Aktif</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal_edit{{ $d->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
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

    <form action="{{ route('addUser') }}" method="post">
        @csrf
        <div id="modal_tambah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabeltambah"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabeltambah">Tambah User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-6">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control" placeholder="Masukan nama"
                                    required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukan username"
                                    required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukan password"
                                    required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Ulangi password" required>
                            </div>

                            <div class="col-12">
                                <label for="">Role</label>
                                <select name="role" class="form-control" required>
                                    <option value="1">Super User</option>
                                    <option value="2">Admin</option>
                                </select>
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



    @foreach ($user as $d)
        <form action="{{ route('editUser') }}" method="post">
            @csrf
            @method('patch')
            <div class="modal fade" id="modal_edit{{ $d->id }}" role="dialog"
                aria-labelledby="exampleModalLabelEdit" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabelEdit">Edit Ukuran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span class="mdi mdi-close"></span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <input type="hidden" name="id" value="{{ $d->id }}">
                                <div class="col-12">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ $d->name }}" required>
                                </div>


                                <div class="col-12">
                                    <label for="">Role</label>
                                    <select name="role" class="form-control" required>
                                        <option value="1" {{ $d->role == 1 ? 'selected' : '' }}>Super User</option>
                                        <option value="2" {{ $d->role == 2 ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="">Status</label>
                                    <select name="aktif" class="form-control" required>
                                        <option value="1" {{ $d->aktif == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ $d->aktif == 0 ? 'selected' : '' }}>Non Aktif</option>
                                    </select>
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


            function getResep(id) {
                $('#form-resep').html(
                    '<div class="spinner-border text-secondary" role="status"><span class="visually-hidden"></span></div>'
                );
                $.get('getHargaResep/' + id, function(data) {
                    $('#form-resep').html(data);

                    $('.select2bs4').select2({
                        theme: 'bootstrap4'
                    });

                });

            }


        });
    </script>
@endsection
@endsection
