@extends('layouts.single')

@section('style')
@endsection

@section('content')
    <div class="block-center wd-xxl">
        <!-- START panel-->
        <div class="panel panel-dark panel-flat">
            <div class="panel-heading text-center">
                <h3 class="m0">{{ config('app.name') }}</h3>
            </div>
            <div class="panel-body">
                <p class="text-center pv">Two Factor Authentication</p>
                @if($error)
                    <div class="alert alert-danger">{{ $error }} ({{ $tries }} remaining)</div>
                @endif
                <form role="form" data-parsley-validate="" novalidate="" class="mb-lg" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group has-feedback">
                        <input id="secret" name="secret" type="text" placeholder="Enter your code here"
                               autocomplete="off" required class="form-control">
                        <span class="fa fa-key form-control-feedback text-muted"></span>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary mt-lg">Verify</button>
                </form>
                <a href="{{ url('/logout') }}"
                   class="btn btn-block btn-default">Logout</a>
            </div>
        </div>
        <!-- END panel-->
    </div>
@endsection
