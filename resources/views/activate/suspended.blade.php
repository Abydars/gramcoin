@extends('layouts.admin')

@section('content')
    @if($user->activated == '2')
        <div class="alert alert-warning">
            <strong>Suspended!</strong>
            You are suspended by Gram Coin. Kindly, contact administrator.<br>
        </div>
    @endif
@endsection