@extends('layouts.single')

@section('style')
@endsection

@section('content')
    <div class="block-center wd-xxl mv-lg">
        <!-- START panel-->
        <div class="panel panel-dark panel-flat">
            <div class="bg-purple-custom text-center text-white p-lg">
                <img src="{{ asset('img/logo.png') }}"/>
            </div>
            <div class="panel-body">
                @if(empty($is_admin))
                    <p class="text-center pv">SIGN IN TO CONTINUE.</p>
                @else
                    <p class="text-center pv">ENTER ADMINISTRATOR PASSWORD</p>
                @endif
                @if(isset($error) && $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endif
                <form role="form" data-parsley-validate="" novalidate="" class="mb-lg" method="POST"
                      action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}"
                         style="{{ (empty($is_admin) ? 'display:block;' : 'display:none;') }}">
                        <input id="login_email" name="email" type="text" placeholder="Enter email or username"
                               autocomplete="off" required class="form-control"
                               value="{{ (empty($is_admin) ? "" : $email) }}">
                        <span class="fa fa-envelope form-control-feedback text-muted"></span>
                        @if ($errors->has('email'))
                            <ul class="parsley-errors-list filled">
                                <li class="parsley-required">{{ $errors->first('email') }}</li>
                            </ul>
                        @endif
                    </div>
                    <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="login_password" name="password" type="password" placeholder="Password" required
                               class="form-control">
                        <span class="fa fa-lock form-control-feedback text-muted"></span>
                        @if ($errors->has('password'))
                            <ul class="parsley-errors-list filled">
                                <li class="parsley-required">{{ $errors->first('password') }}</li>
                            </ul>
                        @endif
                    </div>
                    <div class="clearfix">
                        <div class="checkbox c-checkbox pull-left mt0">
                            <label>
                                <input type="checkbox" value="1" name="remember">
                                <span class="fa fa-check"></span>Remember Me
                            </label>
                        </div>
                        <div class="pull-right"><a href="{{ url('/password/reset') }}" class="text-muted">Forgot your
                                password?</a>
                        </div>
                    </div>
                    {!! Recaptcha::render() !!}
                    @if ($errors->has('g-recaptcha-response'))
                        <ul class="parsley-errors-list filled">
                            <li class="parsley-required">{{ $errors->first('g-recaptcha-response') }}</li>
                        </ul>
                    @endif
                    @if(empty($is_admin))
                        <button type="submit" class="btn btn-block btn-primary mt-lg">Login</button>
                    @else
                        <button type="submit" class="btn btn-block btn-primary mt-lg">Login as administrator</button>
                    @endif
                </form>
                @if(empty($is_admin))
                    <p class="pt-lg text-center">Need to Signup?</p><a href="{{ url('/register') }}"
                                                                       class="btn btn-block btn-default">Register
                        Now</a>
                @endif
            </div>
        </div>
        <!-- END panel-->
    </div>
@endsection