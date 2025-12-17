@extends('template.master')

@section('content')
    <!-- Content -->

    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Produk</h4>
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
                            data-bs-target="#add-produk">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Produk
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="datatable" class="tabledt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Brand</th>
                                            <th>Nama</th>
                                            <th>Rename</th>
                                            <th>Inspired By</th>
                                            <th>Kategori</th>
                                            <th>Gender</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($produk as $p)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $p->brand }}</td>
                                                <td>{{ $p->nm_produk }}</td>
                                                <td>{{ $p->ganti_nama }}</td>
                                                <td>{{ $p->inspired_by }}</td>
                                                <td>{{ $p->kategori->kategori }}</td>
                                                <td>{{ $p->gender->nm_gender }}</td>
                                                <td class="{{ $p->status == 'ON' ? 'text-success' : 'text-danger' }}">
                                                    {{ $p->status }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit-product{{ $p->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <a href="{{ route('deleteProduk', $p->id) }}"
                                                        onclick="return confirm('Aoakah yakin ingin menghapus produk?')"
                                                        class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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

    <form action="{{ route('addProduct') }}" method="post">
        @csrf
        <div id="add-produk" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabeltambah"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabeltambah">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row form-group ">
                            {{-- <div class="col-sm-4">
                                <label for="">Masukkan Gambar</label>
                                <input type="file" class="dropify text-sm"
                                    data-default-file="{{ asset('img') }}/kebabyasmin.jpeg" name="foto"
                                    placeholder="Image" required>
                            </div> --}}
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Brand</dt>
                                        </label>
                                        <input type="text" name="brand" class="form-control" required>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Nama Produk</dt>
                                        </label>
                                        <input type="text" name="nm_produk" class="form-control" required>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Rename</dt>
                                        </label>
                                        <input type="text" name="ganti_nama" class="form-control" required>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Inspired By</dt>
                                        </label>
                                        <input type="text" name="inspired_by" class="form-control">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Kategori</dt>
                                        </label>
                                        <select name="kategori_id" class="form-control" required>
                                            @foreach ($kategori as $d)
                                                <option value="{{ $d->id }}">{{ $d->kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Gender</dt>
                                        </label>
                                        <select name="gender_id" class="form-control" required>
                                            @foreach ($gender as $d)
                                                <option value="{{ $d->id }}">{{ $d->nm_gender }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <hr class="bg-primary">
                                    </div>

                                    <div class="col-12 text-center">
                                        <label for="">
                                            <dt>Outlet</dt>
                                        </label>
                                    </div>

                                    @foreach ($cabang as $k)
                                        <div class="col-4">
                                            <label for="{{ $k->nama . $k->id }}"><input type="checkbox"
                                                    id="{{ $k->nama . $k->id }}" value="{{ $k->id }}"
                                                    name="cabang_id[]"> {{ $k->nama }}</label>
                                        </div>
                                    @endforeach

                                    <div class="col-12">
                                        <hr class="bg-primary">
                                    </div>

                                </div>
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



    @foreach ($produk as $p)
        <form action="{{ route('editProduk') }}" method="post">
            @csrf
            @method('patch')
            <div class="modal fade" id="edit-product{{ $p->id }}" role="dialog"
                aria-labelledby="exampleModalLabelEdit" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabelEdit">Edit Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span class="mdi mdi-close"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row form-group ">
                                {{-- <div class="col-sm-4">
                                <label for="">Masukkan Gambar</label>
                                <input type="file" class="dropify text-sm"
                                    data-default-file="{{ asset('img') }}/kebabyasmin.jpeg" name="foto"
                                    placeholder="Image" required>
                            </div> --}}

                                <input type="hidden" name="id" value="{{ $p->id }}">
                                <div class="col-12">
                                    <div class="form-group row">

                                        <div class="col-lg-6 mb-2">
                                            <label for="">
                                                <dt>Brand</dt>
                                            </label>
                                            <input type="text" name="brand" class="form-control"
                                                value="{{ $p->brand }}" required>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                            <label for="">
                                                <dt>Nama Produk</dt>
                                            </label>
                                            <input type="text" name="nm_produk" class="form-control"
                                                value="{{ $p->nm_produk }}" required>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                            <label for="">
                                                <dt>Rename</dt>
                                            </label>
                                            <input type="text" name="ganti_nama" class="form-control"
                                                value="{{ $p->ganti_nama }}" required>
                                        </div>



                                        <div class="col-lg-6 mb-2">
                                            <label for="">
                                                <dt>Kategori</dt>
                                            </label>
                                            <select name="kategori_id" class="form-control" required>
                                                @foreach ($kategori as $d)
                                                    <option value="{{ $d->id }}"
                                                        {{ $d->id == $p->kategori_id ? 'selected' : '' }}>
                                                        {{ $d->kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                            <label for="">
                                                <dt>Gender</dt>
                                            </label>
                                            <select name="gender_id" class="form-control" required>
                                                @foreach ($gender as $d)
                                                    <option value="{{ $d->id }}"
                                                        {{ $d->id == $p->gender_id ? 'selected' : '' }}>
                                                        {{ $d->nm_gender }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12">
                                            <hr class="bg-primary">
                                        </div>

                                        <div class="col-12 text-center">
                                            <label for="">
                                                <dt>Outlet</dt>
                                            </label>
                                        </div>

                                        @php
                                            $dat_c = $p->produkCabang;
                                        @endphp

                                        @foreach ($cabang as $k)
                                            @php
                                                if ($dat_c) {
                                                    $check = $dat_c->where('cabang_id', $k->id)->first();
                                                    if ($check) {
                                                        $checked = 1;
                                                    } else {
                                                        $checked = null;
                                                    }
                                                } else {
                                                    $checked = null;
                                                }

                                            @endphp
                                            <div class="col-4">
                                                <label for="{{ $k->nama . $k->id }}"><input type="checkbox"
                                                        id="{{ $k->nama . $k->id }}" value="{{ $k->id }}"
                                                        name="cabang_id[]" {{ $checked != null ? 'checked' : '' }}>
                                                    {{ $k->nama }}</label>
                                            </div>
                                        @endforeach

                                        <div class="col-12">
                                            <hr class="bg-primary">
                                        </div>

                                    </div>
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
