@extends('layouts.admin')

@section('content')
    <h3 class="mt0 mb-xl">TX# {{ $transaction->tx_hash }}</h3>
    <div class="row">
        <div class="col-md-3">
            <div class="panel widget">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-primary-light pv-lg">
                        <em class="fa fa-bitcoin fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <h4 class="m0 text-uppercase">Amount</h4>
                    </div>
                </div>
                <div class="panel-body bg-primary">
                    <h4 class="m0">{{ number_format($transaction->amount_in_btc, 10) }} BTC</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel widget">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-warning-light pv-lg">
                        <em class="fa fa-calendar fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <h4 class="m0 text-uppercase">Date/Time</h4>
                    </div>
                </div>
                <div class="panel-body bg-warning">
                    <h4 class="m0">{{ $transaction->created_at }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel widget">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-gray-light pv-lg">
                        <em class="fa fa-clock-o fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <h4 class="m0 text-uppercase">Status</h4>
                    </div>
                </div>
                <div class="panel-body bg-success">
                    <h4 class="m0">{{ $transaction->status }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel widget">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-gray-light pv-lg">
                        <em class="fa fa-sticky-note fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <h4 class="m0 text-uppercase">Confirmations</h4>
                    </div>
                </div>
                <div class="panel-body bg-green-dark">
                    <h4 class="m0">{{ $transaction->confirmations }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel widget">
                <div class="row row-table">
                    <div class="col-xs-2 text-center bg-gray-light pv-lg">
                        <em class="fa fa-calendar fa-3x"></em>
                    </div>
                    <div class="col-xs-10 pv-lg">
                        <h4 class="m0 text-uppercase">Address</h4>
                    </div>
                </div>
                <div class="panel-body bg-gray">
                    <h4 class="m0">{{ $transaction->recipient }}</h4>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush