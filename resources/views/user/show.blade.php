@extends('layouts.admin')

@section('modals')
    @if($wallet)
        <div class="modal fade" id="status-modal" tabindex="-1" role="dialog" aria-labelledby="Confirmation"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-purple-custom text-white">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title">Change User Status</h3>
                    </div>
                    {!! Form::open(['id' => 'change-status-form', 'method' => 'POST', 'data-parsley-validate' => ' ', 'novalidate' => ' ', 'class' => '']) !!}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            {!! Form::select('status', $user_status, $user->activated, ['id' => 'input-status','class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn-confirm">Update</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="modal fade" id="balance-modal" tabindex="-1" role="dialog" aria-labelledby="BTC Balance"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-purple-custom text-white">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title">Balance</h3>
                    </div>
                    {!! Form::open(['id' => 'change-status-form', 'method' => 'POST', 'data-parsley-validate' => ' ', 'novalidate' => ' ', 'class' => '']) !!}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Balance</label>
                            <div class="input-group date mb-lg">
                        <span class="input-group-addon">
                                    <span class="fa fa-bitcoin"></span>
                                 </span>
                                {!! Form::number('balance', $user->btc_balance_in_btc, ['id' => 'input-balance','class' => 'form-control', 'step' => 'any']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn-update">Update</button>
                        <button type="button" class="btn btn-info" id="btn-sync">Sync from Wallet</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="modal fade" id="password-modal" tabindex="-1" role="dialog" aria-labelledby="Wallet Password"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-purple-custom text-white">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title">Wallet Password</h3>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">CLICK COPY BUTTON TO COPY</label>
                            <div class="input-group">
                                <input id="wallet-password-input" type="text" readonly
                                       value="{{ $wallet->pass }}"
                                       class="form-control" style="height: 44px;"/>
                                <span class="input-group-btn">
                                    <button type="button" data-copy-text="#wallet-password-input"
                                            class="btn btn-default"
                                            style="height: 44px;"><em
                                                class="fa fa-files-o"></em></button>
                                 </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('content')
    @if($wallet)
        @if($error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endif
        <h3 class="mt0 mb-xl">Wallet ID# {{ $wallet->identity }}</h3>
        <div class="row">
            <div class="col-md-3">
                <div class="panel widget">
                    <div class="row row-table">
                        <div class="col-xs-4 text-center bg-white pv-lg">
                            <em class="fa fa-bitcoin fa-3x"></em>
                        </div>
                        <div class="col-xs-8 pv-lg">
                            <h4 class="m0 text-uppercase">BTC Balance</h4>
                        </div>
                    </div>
                    <div class="panel-body bg-orange-custom text-white">
                        <div class="row">
                            <div class="col-lg-10 col-sm-12"><h4
                                        class="m0">{{ number_format($user->btc_balance_in_btc, 10) }} BTC</h4></div>
                            <div class="col-lg-2 col-sm-12 text-right">
                                <a href="#balance-modal" data-toggle="modal" class="bg-transparent text-white p0"
                                   style="color: white !important;">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel widget">
                    <div class="row row-table">
                        <div class="col-xs-4 text-center bg-white pv-lg">
                            <em class="fa fa-bitcoin fa-3x"></em>
                        </div>
                        <div class="col-xs-8 pv-lg">
                            <h4 class="m0 text-uppercase">Spent</h4>
                        </div>
                    </div>
                    <div class="panel-body bg-pink-custom text-white">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12"><h4 class="m0">{{ number_format($user->spend, 10) }}
                                    BTC</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel widget">
                    <div class="row row-table">
                        <div class="col-xs-4 text-center bg-white pv-lg">
                            <img src="{{ asset('/img/currency-dark.png') }}" height="42"/>
                        </div>
                        <div class="col-xs-8 pv-lg">
                            <h4 class="m0 text-uppercase">Tokens</h4>
                        </div>
                    </div>
                    <div class="panel-body bg-purple-custom text-white">
                        <h4 class="m0">{{ $user->token_balance }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel widget">
                    <div class="row row-table">
                        <div class="col-xs-4 text-center bg-white pv-lg">
                            <em class="fa fa-bitcoin fa-3x"></em>
                        </div>
                        <div class="col-xs-8 pv-lg">
                            <h4 class="m0 text-uppercase">Status</h4>
                        </div>
                    </div>
                    <div class="panel-body bg-red-custom text-white">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12"><h4 class="m0">{{ $user_status[$user->activated] }}</h4>
                            </div>
                            <div class="col-lg-6 col-sm-12 text-right">
                                <a href="#status-modal" data-toggle="modal" class="bg-transparent text-white p0"
                                   style="color: white !important;">Change
                                    status</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel widget">
                    <div class="row row-table">
                        <div class="col-xs-4 text-center bg-white pv-lg">
                            <em class="fa fa-bitcoin fa-3x"></em>
                        </div>
                        <div class="col-xs-8 pv-lg">
                            <h4 class="m0 text-uppercase">Wallet Password</h4>
                        </div>
                    </div>
                    <div class="panel-body bg-red-custom text-white">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <a href="#password-modal" data-toggle="modal" class="bg-transparent text-white p0"
                                   style="color: white !important;">Show Password</a>
                            </div>
                            <div class="col-lg-6 col-sm-12"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    jQuery(function ($) {
        var wallet_balance = {!! $wallet_balance !!};

        $("#btn-sync").on("click", function (e) {
            $("#input-balance").val(wallet_balance);
        });
    });
</script>
@endpush