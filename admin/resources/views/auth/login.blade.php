<!doctype html>
<html lang="en">
@include('layouts.partials.header')
<body>
    <!-- login page start-->
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div>

                        <div class="login-main">
                            <div>
                                <a class="logo" href="#">
                                    <img class="img-fluid for-light" src="{{ url(@$setting->logo) }}" alt="looginpage">
                                    <img class="img-fluid for-dark" src="{{ url(@$setting->logoDark) }}" alt="looginpage">
                                </a>
                            </div>
                            <form class="theme-form" action="{{ route('login') }}" method="POST">
                                @csrf
                                <h4>Sign in to account</h4>
                                <p>Enter your email & password to login</p>
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="test@gmail.com" value="{{ old('email') }}" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="*********" required>
                                        <div class="show-hide"><span class="show"></span></div>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input id="checkbox1" type="checkbox" name="remember" value="true">
                                        <label class="text-muted" for="checkbox1">Remember password</label>
                                    </div>
{{--                                    <a class="link" href="forget-password.html">Forgot password?</a>--}}
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                                    </div>
                                </div>
{{--                                <h6 class="text-muted mt-4 or">Or Sign in with</h6>--}}
{{--                                <div class="social mt-4">--}}
{{--                                    <div class="btn-showcase"><a class="btn btn-light" href="https://www.linkedin.com/login" target="_blank"><i class="txt-linkedin" data-feather="linkedin"></i> LinkedIn </a><a class="btn btn-light" href="https://twitter.com/login?lang=en" target="_blank"><i class="txt-twitter" data-feather="twitter"></i>twitter</a><a class="btn btn-light" href="https://www.facebook.com/" target="_blank"><i class="txt-fb" data-feather="facebook"></i>facebook</a></div>--}}
{{--                                </div>--}}
{{--                                <p class="mt-4 mb-0 text-center">Don't have account?<a class="ms-2" href="sign-up.html">Create Account</a></p>--}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.scripts')
</body>
</html>
