@extends('layouts.auth')

@section('main-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">{{ __('Login') }}</h1>
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger border-left-danger" role="alert">
                                            <ul class="pl-4 my-2">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('login') }}" class="user">
                                        @csrf

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="username"
                                                placeholder="Username or E-Mail Address" value="{{ old('username') }}"
                                                required autofocus>
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Password" required>
                                        </div>

                                        <div class="form-group">
                                            <select name="database" id="database" class="form-control" required>
                                                <option value="" disabled selected>Select Database</option>
                                                <option value="SIMULASI_NEW_UD">SIMULASI NEW UD</option>
                                                {{-- <option value="NEW_UDMW_LIVE">NEW UDMW LIVE</option> --}}
                                                <option value="SIMULASI_NEW_UD_3">SIMULASI NEW UD 3</option>
                                                <option value="SIMULASI_NEW_UD_4">SIMULASI NEW UD 4</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="remember">Remember Me</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                                Login
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
