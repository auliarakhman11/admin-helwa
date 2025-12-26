<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Ganti Password | Helawa Perfume</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('img') }}/helwa.jpg">

    <!-- Bootstrap Css -->
    <link href="{{ asset('template') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('template') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('template') }}/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body class="bg-primary bg-pattern">
    {{-- <div class="home-btn d-none d-sm-block">
        <a href="index.html"><i class="mdi mdi-home-variant h2 text-white"></i></a>
    </div> --}}

    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5">
                        {{-- <a href="" class="logo"><img src="{{ asset('img') }}/helwa.png" height="200"
                                alt="logo"></a> --}}
                        <h5 class="font-size-16 text-white-50 mb-4">Ganti Password</h5>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-xl-5 col-sm-8">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="p-2">
                                {{-- <h5 class="mb-5 text-center">HELWA PARFUME</h5> --}}
                                <center><img src="{{ asset('img') }}/helwa.jpg" height="100" alt="logo"
                                        class="mb-3"></center>

                                @error('password')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <?php if(session('success')): ?>
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                                <?php endif; ?>

                                <?php if(session('error')): ?>
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                                <?php endif; ?>
                                <form class="form-horizontal" method="POST" action="{{ route('editPassword') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="form-group form-group-custom mb-4">
                                                <input type="password" class="form-control" id="confirmpassword"
                                                    name="old_password" required>
                                                <label for="confirmpassword">Password saat ini</label>
                                            </div>

                                            <div class="form-group form-group-custom mb-4">
                                                <input type="password" class="form-control" id="userpassword"
                                                    name="password" required>
                                                <label for="userpassword">Password Baru</label>
                                            </div>

                                            <div class="form-group form-group-custom mb-4">
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation" required>
                                                <label for="password_confirmation">Ulangi password baru</label>
                                            </div>

                                            <div class="row">
                                                {{-- <div class="col-md-6">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customControlInline">
                                                        <label class="custom-control-label"
                                                            for="customControlInline">Remember me</label>
                                                    </div>
                                                </div> --}}
                                                {{-- <div class="col-md-6">
                                                    <div class="text-md-right mt-3 mt-md-0">
                                                        <a href="auth-recoverpw.html" class="text-muted"><i
                                                                class="mdi mdi-lock"></i> Forgot your password?</a>
                                                    </div>
                                                </div> --}}
                                            </div>
                                            <div class="mt-4">
                                                <button class="btn btn-success d-block w-100 waves-effect waves-light"
                                                    type="submit">Ganti Password</button>
                                            </div>
                                            <div class="mt-4 text-center">
                                                <a href="/" class="text-muted"><i
                                                        class="mdi mdi-arrow-left-circle me-1"></i> Kembali</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>
    <!-- end Account pages -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('template') }}/libs/jquery/jquery.min.js"></script>
    <script src="{{ asset('template') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template') }}/libs/metismenu/metisMenu.min.js"></script>
    <script src="{{ asset('template') }}/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('template') }}/libs/node-waves/waves.min.js"></script>

    <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

    <script src="{{ asset('template') }}/js/app.js"></script>

</body>

</html>
