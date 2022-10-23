@extends('layouts.app')
@section('content')
<style>
    html, body {
                margin: 0;
                padding: 0;
                font-family: 'Nanum Gothic', sans-serif;
            }

    .main {
        background-image: url(https://i.postimg.cc/Z5kyHB02/PAO.jpg);
        height: 100vh;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }

    .main .contain {
        background-color: gray;
        height: 100%;
        opacity: 0.7;
    }

    .main .contain .content {
        text-align: center;
        padding-top: 230px;
        color: #fff;
    }
    
    input[type=text], input[type=password], input[type=email], input[type=number] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    select[name="gender"]{
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }
    
    input[type=text]:focus, input[type=password]:focus, input[type=email]:focus, input[type=number]:focus {
        background-color: #ddd;
        outline: none;
    }
    
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }
    
    /* Set a style for all buttons */
    button {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }
    
    button:hover {
        opacity:1;
    }
    
    /* Extra styles for the cancel button */
    .cancelbtn {
        padding: 14px 20px;
        background-color: #f44336;
    }
    
    /* Float cancel and signup buttons and add an equal width */
    .cancelbtn, .signupbtn {
      float: left;
      width: 50%;
    }
    
    /* Add padding to container elements */
    .container {
        padding: 16px;
    }
    
    /* Clear floats */
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }
    
    /* Change styles for cancel button and signup button on extra small screens */
    @media screen and (max-width: 300px) {
        .cancelbtn, .signupbtn {
           width: 100%;
        }
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <h1>Appointment</h1>
                        <p>Please Login</p>

                        <div class="row justify-content-center">
                            <div class="col-12">
                                @if(\Session::has('message'))
                                    <p class="alert alert-info">
                                        {{ \Session::get('message') }}
                                    </p>
                                @endif

                                <label for="Email"><b>Email</b></label>
                                <input name="email" type="text" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" required autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif

                                <label for="Password"><b>Password</b></label>
                                <input name="password" type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">
                                @if($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif

                                <button type="submit" class="btn btn-primary px-4">
                                    {{ trans('global.login') }}
                                </button>

                            </div>
                        </div>

                        <div class="input-group mb-4">
                            <div class="form-check checkbox">
                                <input class="form-check-input" name="remember" type="checkbox" id="remember" style="vertical-align: middle;" />
                                <label class="form-check-label" for="remember" style="vertical-align: middle;">
                                    {{ trans('global.remember_me') }}
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            
                            <div class="col-12 text-right">
                                <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                    {{ trans('global.forgot_password') }}
                                </a>
                                |
                                <a class="btn btn-link px-0" href="{{ route('auth.registration') }}">
                                    Register a new membership
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection