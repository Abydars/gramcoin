@extends('layouts.single')

@section('style')
@endsection

@section('content')
    <div class="block-center wd-xl">
        <!-- START panel-->
        <div class="panel panel-dark panel-flat">
            <div class="panel-heading text-center">
                <h3 class="m0">{{ config('app.name') }}</h3>
            </div>
            <div class="panel-body">
                <p class="text-center pv">SIGNUP TO GET INSTANT ACCESS.</p>
                @if(isset($guid) && isset($exists) && ! $exists)
                    <div class="alert alert-danger">
                        Reference not found
                    </div>
                @endif
                {!! Form::open(['url'=>['register'], 'role'=>'form', 'method'=>'POST', 'data-parsley-validate'=>' ', 'novalidate'=>' ', 'class'=>'mb-lg']) !!}
                {{ csrf_field() }}
                <div class="form-group has-feedback{{ $errors->has('full_name') ? ' has-error' : '' }}">
                    <label for="signup_full_name" class="text-muted">Full Name</label>
                    {!! Form::text('full_name', old('full_name'), ['id'=>'signup_full_name', 'placeholder'=>'Full Name', 'autocomplete'=>'off', 'required', 'class'=>'form-control']) !!}
                    <span class="fa fa-user form-control-feedback text-muted"></span>
                    @if ($errors->has('full_name'))
                        <ul class="parsley-errors-list filled">
                            <li class="parsley-required">{{ $errors->first('full_name') }}</li>
                        </ul>
                    @endif
                </div>
                <div class="form-group has-feedback{{ $errors->has('username') ? ' has-error' : '' }}">
                    <label for="signup_username" class="text-muted">Username</label>
                    {!! Form::text('username', old('username'), ['id'=>'signup_username', 'placeholder'=>'Enter Username', 'autocomplete'=>'off', 'required', 'class'=>'form-control']) !!}
                    <span class="fa fa-user form-control-feedback text-muted"></span>
                    @if ($errors->has('username'))
                        <ul class="parsley-errors-list filled">
                            <li class="parsley-required">{{ $errors->first('username') }}</li>
                        </ul>
                    @endif
                </div>
                <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="signup_email" class="text-muted">Email Address</label>
                    {!! Form::text('email', old('email'), ['id'=>'signup_email', 'placeholder'=>'Enter Email', 'autocomplete'=>'off', 'required', 'class'=>'form-control']) !!}
                    <span class="fa fa-envelope form-control-feedback text-muted"></span>
                    @if ($errors->has('email'))
                        <ul class="parsley-errors-list filled">
                            <li class="parsley-required">{{ $errors->first('email') }}</li>
                        </ul>
                    @endif
                </div>
                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="signup_password" class="text-muted">Password</label>
                    {!! Form::password('password', ['id'=>'signup_password', 'placeholder'=>'Password', 'autocomplete'=>'off', 'required', 'class'=>'form-control']) !!}
                    <span class="fa fa-lock form-control-feedback text-muted"></span>
                    @if ($errors->has('password'))
                        <ul class="parsley-errors-list filled">
                            <li class="parsley-required">{{ $errors->first('password') }}</li>
                        </ul>
                    @endif
                </div>
                <div class="form-group has-feedback">
                    <label for="signup_password_confirm" class="text-muted">Retype Password</label>
                    {!! Form::password('password_confirmation', ['id'=>'signup_password_confirm', 'placeholder'=>'Retype Password', 'autocomplete'=>'off', 'required', 'data-parsley-equalto'=>'#signup_password', 'class'=>'form-control']) !!}
                    <span class="fa fa-lock form-control-feedback text-muted"></span>
                </div>
                <div class="clearfix">
                    <div class="checkbox c-checkbox pull-left mt0">
                        <label>
                            <input type="checkbox" value="" required name="agreed">
                            <span class="fa fa-check"></span>I agree with the <a href="#">terms</a>
                        </label>
                    </div>
                </div>
                @if(isset($guid) && isset($exists) && $exists)
                    {!! Form::hidden('reference', $guid) !!}
                @endif
                <button type="submit" class="btn btn-block btn-primary mt-lg">Create account</button>
                {!! Form::close() !!}
                <p class="pt-lg text-center">Have an account?</p><a href="{{ url('/login') }}"
                                                                    class="btn btn-block btn-default">Sign In</a>
            </div>
        </div>
        <!-- END panel -->
    </div>
@endsection
