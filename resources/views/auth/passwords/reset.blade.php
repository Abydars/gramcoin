@extends('layouts.single')

@section('style')
<style>
    body {
        background-image: url('{{ Option::getOption("setting", "signin_bg") }}'), url('{{ Config::get("constants.settings.default.signin_bg") }}');
    }
</style>
@endsection

@section('content')
<div class="block-center wd-xl">
    <!-- START panel-->
    <div class="panel panel-dark panel-flat">
        <div class="panel-heading text-center">
            <h3 class="m0">{{ config('app.name') }}</h3>
        </div>

        <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form role="form" data-parsley-validate="" novalidate="" class="mb-lg" method="POST" action="{{ url('/password/reset') }}">
                {{ csrf_field() }}

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input value="{{ old('email') }}" name="email" type="text" placeholder="Enter email or username" autocomplete="off" required class="form-control">
                    <span class="fa fa-envelope form-control-feedback text-muted"></span>
                    @if ($errors->has('email'))
                    <ul class="parsley-errors-list filled">
                        <li class="parsley-required">{{ $errors->first('email') }}</li>
                    </ul>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input value="{{ old('password') }}" name="password" type="password" placeholder="Enter password" autocomplete="off" required class="form-control">
                    <span class="fa fa-lock form-control-feedback text-muted"></span>
                    @if ($errors->has('password'))
                    <ul class="parsley-errors-list filled">
                        <li class="parsley-required">{{ $errors->first('password') }}</li>
                    </ul>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <input value="{{ old('password_confirmation') }}" name="password_confirmation" type="password" placeholder="Confirm password" data-parsley-equalto="password" autocomplete="off" required class="form-control">
                    <span class="fa fa-lock form-control-feedback text-muted"></span>
                    @if ($errors->has('password_confirmation'))
                    <ul class="parsley-errors-list filled">
                        <li class="parsley-required">{{ $errors->first('password_confirmation') }}</li>
                    </ul>
                    @endif
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Reset Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
