@extends('layouts.admin')

@section('modals')

@endsection
@section('content')
    <!-- START widgets box-->
    <div class="row">
        <div class="col-lg-4 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-warning-dark pv-lg">
                        <em class="fa fa-bitcoin fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h3 mt0 mb0">{{ $user->btc_balance }}</div>
                        <div class="text-uppercase">BTC Deposit</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-primary-dark pv-lg">
                        <em class="fa fa-dollar fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h3 mt0 mb0">$9.05</div>
                        <div class="text-uppercase">Token Rate</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-danger-dark pv-lg">
                        <em class="icon-basket-loaded fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h3 mt0 mb0">5,000</div>
                        <div class="text-uppercase">Tokens Purchase Limit</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::open(['route' => ['user.deposit'], 'id' => 'deposit-form', 'method' => 'POST', 'data-parsley-validate' => ' ', 'novalidate' => ' ', 'class' => '']) !!}
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-2 control-label">BitCoin Address</label>
                    <div class="col-sm-10">
                        {!! Form::text('btc_address', false, ['id' => 'input-btc-address','class' => 'form-control', 'placeholder' => 'Your BitCoin Address']) !!}
                    </div>
                </div>
            </fieldset>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('scripts')
<script>
    jQuery(function ($) {

    });
</script>
@endpush