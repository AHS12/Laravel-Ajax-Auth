@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- login --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <div id="login-error-div">

                    </div>
                    <form id="loginForm">
                        @csrf

                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="login-email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="login-password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btn-login"
                                    data-loading-text='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging In...'
                                    data-normal-text="Login">
                                    <span class="ui-button-text">Login</span>
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- register --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form id="registerForm">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

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

                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

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

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

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

                        <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
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

<script>
    $(document).ready(() => {

        /**
         * @name form onsubmit
         * @description override the default form submission and submit the form manually.
         *              also validate with .validate() method from jquery validation
         * @parameter formid
         * @return 
         */
        $('#loginForm').submit(function (e) {
            e.preventDefault();
        }).validate({
            highlight: function (element) {
                jQuery(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function (element) {
                jQuery(element).closest('.form-control').removeClass('is-invalid');
                jQuery(element).closest('.form-control').addClass('is-valid');
            },

            errorElement: 'div',
            errorClass: 'invalid-feedback',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group-prepend').length) {
                    $(element).siblings(".invalid-feedback").append(error);
                    //error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {


                var formData = new FormData(form);
                $.ajax({
                    url: "{{ url('login') }}",
                    method: "POST",
                    data: formData,
                    enctype: 'multipart/form-data',
                    processData: false,
                    cache: false,
                    contentType: false,
                    timeout: 600000,
                    beforeSend: function () {
                        btnLoadStart("btn-login");
                    },
                    complete: function () {
                        btnLoadEnd("btn-login");
                    },
                    success: function (result) {
                        console.log(result);
                        if (result.auth) {
                            toastr.success(
                                "Login Successful!",
                                'Success!', {
                                    timeOut: 2000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-top-center",
                                });
                                
                                redirect(result.intended,1000);
                        }

                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.Verify Network.';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });

                            btnLoadEnd("btn-login");
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else if (jqXHR.status == 413) {
                            msg = 'Request entity too large. [413]';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else if (jqXHR.status == 419) {
                            msg = 'CSRF error or Unknown Status [419]';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else {
                            console.log(jqXHR.responseJSON.errors);
                            var errorMarkup = '';
                            //jquery valiation
                            var validator = $(form).validate();
                            var objErrors = {};
                            $.each(jqXHR.responseJSON.errors, function (key, val) {
                                if (key == 'authFailed') {

                                    errorMarkup +=
                                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                    errorMarkup +=
                                        '<span class="text-center">' + val +
                                        '</span>';
                                    errorMarkup +=
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                                    errorMarkup +=
                                        '<span aria-hidden="true">&times;</span>';
                                    errorMarkup += '</button>';
                                    errorMarkup += '</div>';

                                    $('#login-error-div').append(errorMarkup);
                                    validator.resetForm();

                                } else {
                                    objErrors[key] = val;
                                }

                            });
                            validator.showErrors(objErrors);
                            validator.focusInvalid();

                            //toastr
                            $.each(jqXHR.responseJSON.errors, function (key, val) {

                                toastr.error(
                                    val,
                                    'Error!', {
                                        timeOut: 8000,
                                        closeButton: true,
                                        progressBar: true,
                                        positionClass: "toast-bottom-right",
                                    });
                            });

                            //text error
                            msg = 'Uncaught Error.\n' + jqXHR
                                .responseText;
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        }

                    }
                });

                //console.log("validation success");
            }
        });

    });

</script>
@endsection
