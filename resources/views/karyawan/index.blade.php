@extends('template.master')

@section('content')
    <!-- Content -->

    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Karyawan</h4>
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
                            Tambah Karyawan
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
                                            <th>Nama</th>
                                            <th>Status</th>
                                            <th>No Tlp</th>
                                            <th>Alamat</th>
                                            <th>Tgl_masuk</th>
                                            <th>Gapok</th>
                                            <th>Outlet</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($karyawan as $k)
                                            <tr>
                                                {{-- <td><img src="{{ asset('') }}{{ $k->foto }}" alt="" height="40px"></td> --}}
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $k->nama }}</td>
                                                <td>{{ $k->status }}</td>
                                                <td>{{ $k->no_tlp }}</td>
                                                <td>{{ $k->alamat }}</td>
                                                <td>{{ $k->tgl_masuk ? date('d M Y', strtotime($k->tgl_masuk)) : '-' }}</td>
                                                <td>{{ number_format($k->gapok, 0) }}</td>
                                                <td>{{ $k->cabang->nama }}</td>

                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal_edit{{ $k->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    <form class="d-inline-block" action="{{ route('dropKaryawan') }}"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $k->id }}">
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

    <form action="{{ route('addKaryawan') }}" method="post">
        @csrf
        <div id="modal_tambah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabeltambah"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabeltambah">Tambah Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" placeholder="Masukan nama"
                                    required>
                            </div>

                            {{-- <div class="col-12 col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">- Pilih Status -</option>
                                <option value="Leader">Leader</option>
                                <option value="Rolling">Rolling</option>
                                <option value="Training">Training</option>
                            </select>
                        </div> --}}
                            <input type="hidden" name="status" value="Leader" required>

                            <div class="col-12 col-md-6">
                                <label>No Telephon</label>
                                <input type="number" name="no_tlp" class="form-control" placeholder="Masukan nomor">
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Tanggal Masuk</label>
                                <input type="date" name="tgl_masuk" style="font-size: 12px;" class="form-control"
                                    placeholder="Masukan tanggal masuk">
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Gapok Perbulan</label>
                                <input type="number" name="gapok" style="font-size: 12px;" class="form-control"
                                    placeholder="Masukan gapok">
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Outlet</label>
                                <select name="cabang_id" class="form-control" required>
                                    @foreach ($cabang as $d)
                                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-12">
                                <label>Alamat</label>
                                <textarea class="form-control" name="alamat" rows="5"></textarea>
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



    @foreach ($karyawan as $k)
        <form action="{{ route('editKaryawan') }}" method="post">
            @csrf
            @method('patch')
            <div class="modal fade" id="modal_edit{{ $k->id }}" role="dialog"
                aria-labelledby="exampleModalLabelEdit" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabelEdit">Edit Karyawan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span class="mdi mdi-close"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="id" value="{{ $k->id }}">
                                <div class="col-12 col-md-6">
                                    <label>Nama</label>
                                    <input type="text" name="nama" value="{{ $k->nama }}"
                                        class="form-control" placeholder="Masukan nama" required>
                                </div>

                                {{-- <div class="col-12 col-md-6">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="">- Pilih Status -</option>
                                        <option value="Leader" {{ $k->status == 'Leader' ? 'selected' : '' }}>Leader
                                        </option>
                                        <option value="Rolling" {{ $k->status == 'Rolling' ? 'selected' : '' }}>Rolling
                                        </option>
                                        <option value="Training" {{ $k->status == 'Training' ? 'selected' : '' }}>Training
                                        </option>
                                    </select>
                                </div> --}}

                                <div class="col-12 col-md-6">
                                    <label>No Telephon</label>
                                    <input type="number" name="no_tlp" value="{{ $k->no_tlp }}"
                                        class="form-control" placeholder="Masukan nomor">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label>Tanggal Masuk</label>
                                    <input type="date" name="tgl_masuk" value="{{ $k->tgl_masuk }}"
                                        style="font-size: 12px;" class="form-control"
                                        placeholder="Masukan tanggal masuk">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label>Cabang</label>
                                    <select name="cabang_id" class="form-control" required>
                                        @foreach ($cabang as $d)
                                            <option {{ $k->cabang_id == $d->id ? 'selected' : '' }}
                                                value="{{ $d->id }}">{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label>Gapok Perbulan</label>
                                    <input type="number" name="gapok" style="font-size: 12px;"
                                        value="{{ $k->gapok }}" class="form-control" placeholder="Masukan gapok">
                                </div>

                                <div class="col-12 col-md-12">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat" rows="5">{{ $k->alamat }}</textarea>
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
