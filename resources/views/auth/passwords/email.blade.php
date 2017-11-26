@extends('layouts.single')

@section('style')
<style>
    body {
        background-image: url('{{ Option::getOption("setting", "signin_bg") }}'), url('{{ Config::get("constants.settings.default.signin_bg") }}');
    }
</style>
@endsection

<!-- Main Content -->
@section('content')
<div class="block-center wd-xl">
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
            <form role="form" data-parsley-validate="" novalidate="" class="mb-lg" method="POST" action="{{ url('/password/email') }}">
                {{ csrf_field() }}

                <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input value="{{ old('email') }}" name="email" type="text" placeholder="Enter email or username" autocomplete="off" required class="form-control">
                    <span class="fa fa-envelope form-control-feedback text-muted"></span>
                    @if ($errors->has('email'))
                    <ul class="parsley-errors-list filled">
                        <li class="parsley-required">{{ $errors->first('email') }}</li>
                    </ul>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Send Password Reset Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
