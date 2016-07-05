@extends('master')

@section('content')
    <section class="content-header">
        <h1>
            Reset Password
        </h1>
    </section>

    <div class="register-box-body">
        <p class="login-box-msg">Reset Password</p>
        @if(!isset($message))
        <form role="form" method="post" action="{{ url('/checkPassword') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group has-feedback">
                <input type="password" name="old_password" class="form-control" placeholder="Enter Old Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                </div>
            </div>
        </form>
        @endif

        @if(isset($message))
        <form role="form" method="post" action="{{ url('/setNewPassword') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group has-feedback">
                @if(isset($validation_message))
                    <label style="color: red;">Passwords Don't Match!</label>
                @endif
                <input type="password" name="new_password" class="form-control" placeholder="Enter New Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="confirm_new_password" class="form-control" placeholder="Retype New password" required>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Change Password</button>
                </div>
            </div>
        </form>
        @endif
    </div>
@endsection