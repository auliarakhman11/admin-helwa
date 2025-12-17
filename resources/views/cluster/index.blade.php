@extends('template.master')

@section('content')
    <!-- Content -->

    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Cluster</h4>
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
                            Tambah Cluster
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
                                            <th>Cluster</th>
                                            <th>Takaran<br>Alkohol</th>
                                            <th>Takaran<br>Produk</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($cluster as $d)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $d->nm_cluster }}</td>
                                                <td>{{ $d->takaran1 }}%</td>
                                                <td>{{ $d->takaran2 }}%</td>
                                                <td>
                                                    @if ($d->resep)
                                                        @foreach ($d->resep as $rs)
                                                            {{ $rs->ukuran }} ml : {{ number_format($rs->harga,0) }}<br>
                                                        @endforeach
                                                    @endif
                                                    
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal_edit{{ $d->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <a href="{{ route('deleteCluster', $d->id) }}"
                                                        onclick="return confirm('Apakah yakin ingin menghapus ukuran?')"
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

    <form action="{{ route('addCluster') }}" method="post">
        @csrf
        <div id="modal_tambah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabeltambah"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabeltambah">Tambah Cluster</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row form-group ">

                            <div class="col-12 mb-2">
                                <label for="">
                                    <dt>Cluster</dt>
                                </label>
                                <input type="text" name="nm_cluster" class="form-control" required>
                            </div>

                            <div class="col-12 mb-2">
                                <label for="">
                                    <dt>Alkohol</dt>
                                </label>
                                <input type="number" name="takaran1" class="form-control" required>
                            </div>

                            <div class="col-12 mb-2">
                                <label for="">
                                    <dt>Produk</dt>
                                </label>
                                <input type="number" name="takaran2" class="form-control" required>
                            </div>

                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th>Ukuran</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ukuran as $u)
                                        <tr>
                                            <td>{{ $u->ukuran }} ml</td>
                                            <td>
                                                <input type="hidden" name="ukuran[]" value="{{ $u->ukuran }}" required>
                                                <input type="number" class="form-control form-control-sm" name="harga[]" required>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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



    @foreach ($cluster as $d)
        <form action="{{ route('editCluster') }}" method="post">
            @csrf
            @method('patch')
            <div class="modal fade" id="modal_edit{{ $d->id }}" role="dialog"
                aria-labelledby="exampleModalLabelEdit" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabelEdit">Edit Cluster</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span class="mdi mdi-close"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row form-group ">

                                <input type="hidden" name="id" value="{{ $d->id }}">
                                <div class="col-12 mb-2">
                                    <label for="">
                                        <dt>Cluster</dt>
                                    </label>
                                    <input type="text" name="nm_cluster" class="form-control"
                                        value="{{ $d->nm_cluster }}" required>
                                </div>

                                <div class="col-12 mb-2">
                                    <label for="">
                                        <dt>Alkohol</dt>
                                    </label>
                                    <input type="number" name="takaran1" class="form-control"
                                        value="{{ $d->takaran1 }}" required>
                                </div>

                                <div class="col-12 mb-2">
                                    <label for="">
                                        <dt>Produk</dt>
                                    </label>
                                    <input type="number" name="takaran2" class="form-control"
                                        value="{{ $d->takaran2 }}" required>
                                </div>

                            </div>
                            <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th>Ukuran</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ukuran as $u)
                                    @php
                                        $dt = $d->resep;
                                        $dat = $dt->where('ukuran',$u->ukuran)->where('void',0)->first();
                                    @endphp
                                    @if ($dat)
                                        <tr>
                                            <td>{{ $u->ukuran }} ml</td>
                                            <td>
                                                <input type="hidden" name="resep_id[]" value="{{ $dat->id }}" required>
                                                <input type="number" class="form-control form-control-sm" name="harga[]" value="{{ $dat->harga }}" required>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>{{ $u->ukuran }} ml</td>
                                            <td>
                                                <input type="hidden" name="ukuran_add[]" value="{{ $u->ukuran }}" required>
                                                <input type="number" class="form-control form-control-sm" name="harga_add[]" required>
                                            </td>
                                        </tr>
                                    @endif
                                        
                                    @endforeach
                                </tbody>
                            </table>
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
