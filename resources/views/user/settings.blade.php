@extends('layouts.admin')

@section('modals')

@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="mb0">Change Password</h4>
                </div>
                <div class="panel-body">
                    {!! Form::open(['role'=>'form', 'method'=>'POST', 'data-parsley-validate'=>' ', 'novalidate'=>' ', 'class'=>'mb-lg']) !!}
                    {{ csrf_field() }}
                    @if($error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endif
                    @if($success)
                        <div class="alert alert-success">{{ $success }}</div>
                    @endif
                    <div class="form-group has-feedback">
                        <label for="change_password" class="text-muted">Password</label>
                        {!! Form::password('password', ['id'=>'change_password', 'placeholder'=>'Password', 'autocomplete'=>'off', 'required', 'class'=>'form-control']) !!}
                        <span class="fa fa-lock form-control-feedback text-muted"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="change_password_confirm" class="text-muted">Retype Password</label>
                        {!! Form::password('password_confirmation', ['id'=>'change_password_confirm', 'placeholder'=>'Retype Password', 'autocomplete'=>'off', 'required', 'data-parsley-equalto'=>'#change_password', 'class'=>'form-control']) !!}
                        <span class="fa fa-lock form-control-feedback text-muted"></span>
                    </div>
                    <button type="submit" class="btn btn-primary mt-lg">Change Password</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading mb-lg">
                    <div class="row">
                        <div class="col-lg-10">
                            <h4 class="mt-lg">Two Factor Authentication</h4>
                        </div>
                        <div class="col-lg-2">
                            {!! Form::open(['route' => ['user.settings.google2fa'], 'method' => 'POST']) !!}
                            <label class="switch mt-lg">
                                <input name="google2fa" type="checkbox"
                                       id="google2fa"{{ ($user->google2fa_secret ? " checked" : "") }}/>
                                <span></span>
                            </label>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="panel-body pt0 text-center">
                    @if($user->google2fa_secret && $google2fa_url)
                        <p>Open up your 2FA mobile app and scan the following QR barcode:</p>
                        <img src="{{ $google2fa_url }}" alt="google2fa_code"/>
                        <p class="text-md">Code: {{ $user->google2fa_secret }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    jQuery(function ($) {
        $("#google2fa").on("change", function () {
            $(this).parents('form').submit();
        });
    });
</script>
@endpush