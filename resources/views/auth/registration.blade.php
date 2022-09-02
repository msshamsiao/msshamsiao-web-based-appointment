@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('auth.store') }}">
                        {{ csrf_field() }}
                        <h1>Register as New Account</h1><br/>

                        <div class="row justify-content-center">
                            <div class="col-12">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-block">
                                        <button type="button" class="close" data-dismiss="alert">×</button>	
                                            <strong>{{ $message }}</strong>
                                    </div>
                                @endif
                                <div class="row align-items-center">
                                    <div class="col mt-4 input-group mb-3">
                                        <input type="text" name="first_name" class="form-control" placeholder="Enter your first name">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                                        </div>
                                    </div>
                                    <div class="col mt-4 input-group mb-3">
                                        <input type="text" name="middle_name" class="form-control" placeholder="Enter your middle name">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                                        </div>
                                    </div>
                                    <div class="col mt-4 input-group mb-3">
                                        <input type="text" name="last_name" class="form-control" placeholder="Enter your last name">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mt-2">
                                    <div class="col mt-6 input-group mb-3">
                                        <input type="text" name="phone" class="form-control" placeholder="Enter your contact number">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-phone"></span></div>
                                        </div>
                                    </div>
                                    <div class="col mt-6 input-group mb-3">
                                        <input type="email" name="email"  class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mt-4">
                                    <div class="col mt-6 input-group mb-3">
                                        <input type="password" name="password"  class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col mt-6 input-group mb-3">
                                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Register</button>
                            </div>
                        </div>
                    </form><br/>
                    <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection