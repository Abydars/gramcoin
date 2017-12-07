@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-warning-dark pv-lg">
                        <em class="fa fa-bitcoin fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h3 mt0 mb0">{{ $user->btc_balance }}</div>
                        <div class="text-uppercase">BTC Balance</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-primary-dark pv-lg">
                        <em class="fa fa-dollar fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h3 mt0 mb0">${{ $token_rate }}</div>
                        <div class="text-uppercase">Token Rate</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-green-dark pv-lg">
                        <em class="icon-basket-loaded fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h3 mt0 mb0">${{ $bonus }}</div>
                        <div class="text-uppercase">Referral Bonus</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-green-dark pv-lg">
                        <em class="icon-basket-loaded fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h3 mt0 mb0">{{ $referrals }}</div>
                        <div class="text-uppercase">Referrals</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><h2><em class="icon-wallet fa"></em>&nbsp;Bitcoin Wallet</h2></div>
                </div>
                <div class="panel-body">
                    <h4>Get address to accept Bitcoin payments</h4>
                    <div class="input-group">
                        <input type="text" readonly value="{{ $address }}"
                               class="form-control" style="height: 44px;"/>
                        <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" style="height: 44px;"><em
                                                class="fa fa-files-o"></em></button>
                                 </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><h2><em class="fa-sign-out fa"></em>&nbsp;Withdraw</h2></div>
                </div>
                {!! Form::open(['route' => ['wallet.withdraw'], 'id' => 'withdraw-form', 'method' => 'POST', 'data-parsley-validate' => ' ', 'novalidate' => ' ', 'class' => '']) !!}
                <div class="panel-body">
                    <h4>Withdraw from your wallet balance to your BTC wallet</h4>
                    <div class="form-group">
                        <label>Amount to Withdraw</label>
                        {!! Form::number('amount', false, ['id' => 'input-amount','class' => 'form-control', 'placeholder' => 'Enter BTC amount']) !!}
                    </div>
                    <div class="form-group">
                        <label>BTC Address</label>
                        {!! Form::text('address', false, ['id' => 'input-address','class' => 'form-control', 'placeholder' => 'Enter your address']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection