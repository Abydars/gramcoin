@extends('layouts.admin')

@section('modals')
    <div class="modal fade" id="confirmation-modal" tabindex="-1" role="dialog" aria-labelledby="Confirmation"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title">Confirmation</h3>
                </div>
                <div class="modal-body">
                    <p>Please confirm, are you sure you want to buy <span class="h3" data-view-tokens></span> tokens
                        for <span class="h3"
                                  data-view-bitcoins></span> bitcoin(s).</p>
                    <p>Tokens are non-refundable.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn-confirm">Confirm</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    @if($error)
        <div class="alert alert-warning bg-warning-light">{{ $error }}</div>
    @elseif($user->btc_balance <= 0)
        <div class="alert alert-warning bg-warning-light">You don't have enough BTC balance to purchase tokens&nbsp;&nbsp;<a
                    href="{{ url('/user/deposit') }}" class="btn bg-primary-dark">Deposit Now</a></div>
    @endif
    @if($success)
        <div class="alert alert-success bg-success-light">{{ $success }}</div>
    @endif
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
                        <div class="h3 mt0 mb0">{{ $btc_balance }}</div>
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
                        <div class="h3 mt0 mb0">${{ $token_rate }}</div>
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
    <div class="row">
        <div class="col-lg-6 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Buy ICO</div>
                {!! Form::open(['route' => ['token.purchase'], 'id' => 'token-purchase-form', 'method' => 'POST', 'data-parsley-validate' => ' ', 'novalidate' => ' ', 'class' => '']) !!}
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label">BTC Amount</label>
                        {!! Form::number('btc', ($btc_balance > 0 ? $btc_balance : ''), ['id' => 'input-btc','class' => 'form-control', 'placeholder' => 'BTC Amount', 'step' => 'any']) !!}
                        <span class="help-block m-b-none">For which you'll buy the tokens.</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">GC Token Amount</label>
                        {!! Form::number('gc', '', ['id' => 'input-gc','class' => 'form-control', 'placeholder' => '', 'step' => 'any']) !!}
                    </div>
                    <div class="form-group">
                        <label class="control-label">USD Amount</label>
                        {!! Form::number('usd', '', ['id' => 'input-usd','class' => 'form-control', 'placeholder' => '', 'readonly', 'disabled', 'step' => 'any']) !!}
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary">Buy</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-lg-6 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Rates</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label">BTC Value</label>
                        <input type="text" readonly value="${{ $btc_value }}" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">GC Token Value</label>
                        <input type="text" readonly value="${{ $token_rate }}" class="form-control"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    jQuery(function ($) {
        var btc_value = {!! $btc_value !!};
        var gc_value = {!! $token_rate !!};
        var is_confirmed = false;

        var $btc_input = $("#input-btc");
        var $gc_input = $("#input-gc");
        var $token_purchase_form = $("#token-purchase-form");

        $btc_input.each(onBtcChange);

        $btc_input.on("keyup", onBtcChange);
        $gc_input.on("keyup", onGcChange);

        $token_purchase_form.on("submit", function () {

            if (is_confirmed) {
                is_confirmed = false;

                return true;
            }

            $("#confirmation-modal").modal("show");

            return false;
        });

        $("#btn-confirm").on("click", function () {
            is_confirmed = true;

            $token_purchase_form.submit();
        });

        function onGcChange() {
            var gc = $(this).val();
            var gc_in_dollar = gc * gc_value;
            var gc_in_btc = gc_in_dollar / btc_value;

            $("#input-usd").val(gc_in_dollar);
            $("#input-btc").val(gc_in_btc);
        }

        function onBtcChange() {
            var btc = $(this).val();
            var btc_in_dollar = btc * btc_value;
            var btc_in_gc = btc_in_dollar / gc_value;

            $("#input-gc").val(btc_in_gc);
            $("#input-usd").val(btc_in_dollar);
        }
    });
</script>
@endpush