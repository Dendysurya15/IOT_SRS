<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login User Web IoT</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/CBI-logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    html,
    body {
        max-width: 100%;
        overflow-x: hidden;
        background-color: #025C90;
    }
</style>

<body>
    <div style="margin-top: 3%">


        <div class="row justify-content-center">
            <div class="col-11 col-md-7 col-lg-5">
                <div class="card mb-5 p-4" style="border-radius: 10px">
                    <div class="text-center mt-4 mb-3">
                        <img src="{{ asset('img/logo-srs.png') }}" style="height: 100%;width:40%">
                    </div>
                    {{-- <p class="text-center"
                        style="margin:0 3% 0 3%;color: #013C5E;font-size: 50px; font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                        Log in.</p> --}}
                    <p class="text-secondary text-center"
                        style="margin:1% 3% 0 3%;font-style: normal;font-size: 14px;font-family:  Arial, Helvetica, sans-serif;font-weight: 600">
                        Silakan masukkan Username dan Password yang ada miliki untuk mengakses portal <span
                            style="color: #4CAF50">Web AWS IoT</span>!
                    </p>
                    {{-- {{-- @error('msg') --}}
                    @if (session('error'))
                    <div id="boxAlert" style="margin: 3% 2% -3% 2%">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong> {{ session('error') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    <div class="card-body" style="font-family: Arial, Helvetica, sans-serif">
                        <form method="POST" action="{{ route('authenticate') }}">
                            @csrf
                            <div class="form-group mb-3">
                                {{-- <label for="exampleInputEmail1" class="mb-3">Username</label> --}}
                                <input type="text" placeholder="Masukkan username" id="username" class="form-control"
                                    name="email" required autofocus>
                            </div>

                            <div class="form-group mb-3">
                                {{-- <label for="exampleInputEmail1" class="mb-3">Password</label> --}}
                                <input type="password" placeholder="Masukkan password" id="password"
                                    class="form-control" name="password" required>
                                {{-- @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif --}}
                            </div>

                            <div class="mt-3 d-grid gap-2">
                                <button type="submit" class="btn btn-success mt-3 " style="background-color: #013C5E">
                                    <span class="font-weight-bold"> SUBMIT</button>
                            </div>


                            {{--
                            <div class="font-italic text-muted">
                            </div> --}}

                        </form>
                    </div>


                </div>
            </div>


        </div>


        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- ChartJS -->
        <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('js/adminlte.min.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('js/demo.js') }}"></script>

        <script src="{{ asset('js/loader.js') }}"></script>

        <script>
            $('#boxAlert').click(function() {
        $('#boxAlert').attr('hidden', true);
    })
        </script>
    </div>
</body>

</html>