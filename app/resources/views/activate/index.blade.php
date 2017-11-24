@extends('layouts.admin')

@section('content')

<?php $user = Auth::user() ?>
<p class="lead">Welcome to our system.</p>

@if(!$user->activated)
    <div class="alert alert-warning">
        <strong>Warning!</strong>
        You are not activated yet. We sent the email verification. If you not received, please click here to resend it.<br>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Activate User</div>
        </div>
        <div class="panel-body">
            {{ link_to_route('activate.send','Resend Verification', [], ['class'=>'btn btn-primary']) }}
        </div>
    </div>

@else
    <div class="alert alert-warning">
        <strong>Warning!</strong>
        We are reviewing your profile. We will approve soon. If you are urgent to do this, please click here to send us notification again.<br>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">User Reviewing</div>
        </div>
        <div class="panel-body">
            <button class="btn btn-primary">Send Notification to Administrator</button>
        </div>
    </div>
@endif

@endsection

@push('scripts')

@endpush
