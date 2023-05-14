<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register User Web IoT</title>
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
        <main class="signup-form">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="card">

                            <p
                                style="margin:5% 3% 0 3%;color: #013C5E;font-size: 50px; font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                                Registrasi.</p>
                            <p class="text-secondary"
                                style="margin:1% 3% 0 3%;font-style: italic;font-size: 14px;font-family:  Arial, Helvetica, sans-serif">
                                Silakan mengisi form untuk mendaftarkan sebagai user di portal website <span
                                    style="color: #4CAF50">Web AWS IoT</span>!
                            </p>
                            @error('msg')
                            <div id="boxAlert" style="margin: 3% 3% -3% 3%">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong> {{ $message }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                            @enderror
                            <div class="card-body" style="font-family: Arial, Helvetica, sans-serif">
                                <form action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1">Nama User</label>
                                        <input type="text" placeholder="Masukkan nama user" id="name"
                                            class="form-control" value="{{ old('name') }}" name="name" required
                                            autofocus>
                                        @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="text" placeholder="Masukkan Email" id="email_address"
                                            class="form-control" value="{{ old('email') }}" name="email" required
                                            autofocus>
                                        @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1">Password</label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">
                                        @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Konfirmasi Password</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">

                                    </div>
                                    <div class="mt-3 d-grid gap-2">
                                        <button type="submit" class="btn btn-success mt-3">Submit</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
</body>

</html>
{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address')
                                }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password')
                                }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm
                                Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}