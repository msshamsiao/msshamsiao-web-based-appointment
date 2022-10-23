@extends('layouts.app')
@section('content')
<style>
    body {font-family: Arial, Helvetica, sans-serif;}
    * {box-sizing: border-box}
    
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
                        <form method="POST" action="{{ route('auth.store') }}">
                            {{ csrf_field() }}
                            <h1>Sign Up</h1>
                            <p>Please fill in this form to create an account.</p>
                            <hr/>
    
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

                                    <label for="firstname"><b>Firstname</b></label>
                                    <input type="text" name="first_name" placeholder="Enter your first name">
                                    
                                    <label for="middlename"><b>Middlename</b></label>
                                    <input type="text" name="middle_name" placeholder="Enter your middle name">

                                    <label for="lastname"><b>Lastname</b></label>
                                    <input type="text" name="last_name" placeholder="Enter your last name">

                                    <label for="gender"><b>Gender</b></label>
                                    <select name="gender" aria-placeholder="Choose Gender">
                                        <option disabled selected hidden>Choose Gender</option>
                                        <option value="0">Male</option>
                                        <option value="1">Female</option>
                                    </select>

                                    <label for="phone"><b>Phone</b></label>
                                    <input type="number" name="phone" placeholder="Enter your contact number">

                                    <label for="email"><b>Email</b></label>
                                    <input type="email" name="email" class="@error('email') is-invalid @enderror" placeholder="Email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <label for="password"><b>Password</b></label>
                                    <input type="password" name="password"  class="@error('password') is-invalid @enderror" placeholder="Password">

                                    <label for="confirm-password"><b>Confirm Password</b></label>
                                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                                </div>
                            </div>
                        </form><br/>
                        <a href="{{ route('login') }}" class="text-center">I already have an account.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
@endsection