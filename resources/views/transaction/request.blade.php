@extends('layouts.admin')

@section('content')
    <h3 class="mt0 mb-xl">TX# {{ $transaction->tx_hash }}</h3>
    <div class="row">
        <div class="col-md-3">
            <div class="panel widget">
                <div class="row row-table bg-primary">
                    <div class="col-xs-4 text-center bg-primary-light pv-lg">
                        <em class="fa fa-bitcoin fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <h4 class="m0 text-uppercase">Amount</h4>
                    </div>
                </div>
                <div class="panel-body">
                    <h4 class="m0">{{ number_format($transaction->amount_in_btc, 10) }} BTC</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel widget">
                <div class="row row-table bg-warning">
                    <div class="col-xs-4 text-center bg-warning-light pv-lg">
                        <em class="fa fa-calendar fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <h4 class="m0 text-uppercase">Date/Time</h4>
                    </div>
                </div>
                <div class="panel-body">
                    <h4 class="m0">{{ $transaction->created_at }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel widget">
                <div class="row row-table bg-gray">
                    <div class="col-xs-2 text-center bg-gray-light pv-lg">
                        <em class="fa fa-calendar fa-3x"></em>
                    </div>
                    <div class="col-xs-10 pv-lg">
                        <h4 class="m0 text-uppercase">Address</h4>
                    </div>
                </div>
                <div class="panel-body">
                    <h4 class="m0">{{ $transaction->recipient }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="inline mt-lg">
        {!! Form::open(['route' => ['wallet.transactions.request_response', $transaction->id], 'method' => 'POST']) !!}
            <button class="btn btn-danger">Decline Request</button>
            <input type="hidden" name="accepted" value="0"/>
        {!! Form::close() !!}
    </div>
    <div class="inline">
        {!! Form::open(['route' => ['wallet.transactions.request_response', $transaction->id], 'method' => 'POST']) !!}
            <button class="btn btn-primary">Accept Request</button>
            <input type="hidden" name="accepted" value="1"/>
        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
@endpush