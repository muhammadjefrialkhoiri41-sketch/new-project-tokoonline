<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('backend/images/Logo.png') }}">

    <title>JEFFLOID CUSTOMER</title>

    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
</head>

<body>

    <div class="main-wrapper">

        <!-- Preloader -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>

        <!-- Login -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">

            <div class="auth-box bg-dark border-top border-secondary">

                <div id="loginform">

                    <!-- Logo -->
                    <div class="text-center p-t-20 p-b-20">
                        <span class="db">
                            <img src="{{ asset('backend/images/J.png') }}"
                                alt="logo"
                                style="height:120px;">
                        </span>
                    </div>

                    <!-- Error -->
                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                            <strong>{{ session('error') }}</strong>
                        </div>
                    @endif

                    <!-- Form Login Customer -->
                    <form class="form-horizontal m-t-20"
                        id="loginform"
                        action="{{ route('auth.login.post') }}"
                        method="POST">

                        @csrf

                        <div class="row p-b-30">

                            <div class="col-12">

                                <!-- Email -->
                                <div class="input-group mb-3">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white">
                                            <i class="ti-user"></i>
                                        </span>
                                    </div>

                                    <input type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        placeholder="Masukkan Email">

                                    @error('email')
                                        <span class="invalid-feedback alert-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                                <!-- Password -->
                                <div class="input-group mb-3">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white">
                                            <i class="ti-pencil"></i>
                                        </span>
                                    </div>

                                    <input type="password"
                                        name="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        placeholder="Masukkan Password">

                                    @error('password')
                                        <span class="invalid-feedback alert-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                            </div>
                        </div>

                        <!-- Button -->
                        <div class="row border-top border-secondary">

                            <div class="col-12">

                                <div class="form-group">

                                    <div class="p-t-20">

                                        <button class="btn btn-info"
                                            id="to-recover"
                                            type="button">
                                            <i class="fa fa-lock m-r-5"></i>
                                            Lost password?
                                        </button>

                                        <button class="btn btn-success float-right"
                                            type="submit">
                                            Login Customer
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

                <!-- Recover Password -->
                <div id="recoverform">

                    <div class="text-center">
                        <span class="text-white">
                            Enter your e-mail address below and we will send you instructions how to recover a password.
                        </span>
                    </div>

                    <div class="row m-t-20">

                        <form class="col-12">

                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white">
                                        <i class="ti-email"></i>
                                    </span>
                                </div>

                                <input type="text"
                                    class="form-control form-control-lg"
                                    placeholder="Email Address">

                            </div>

                            <div class="row m-t-20 p-t-20 border-top border-secondary">

                                <div class="col-12">

                                    <a class="btn btn-success"
                                        href="#"
                                        id="to-login">
                                        Back To Login
                                    </a>

                                    <button class="btn btn-info float-right"
                                        type="button">
                                        Recover
                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- JS -->
    <script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>

    <script src="{{ asset('backend/libs/popper.js/dist/umd/popper.min.js') }}"></script>

    <script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <script>
        $('[data-toggle="tooltip"]').tooltip();

        $(".preloader").fadeOut();

        // Recover password
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });

        $('#to-login').click(function() {
            $("#recoverform").hide();
            $("#loginform").fadeIn();
        });
    </script>

</body>

</html>