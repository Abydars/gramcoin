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
            {!! Form::open(['route' => ['token.purchase'], 'id' => 'token-purchase-form', 'method' => 'POST', 'data-parsley-validate' => ' ', 'novalidate' => ' ', 'class' => '']) !!}
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-2 control-label">How much Bitcoins?</label>
                    <div class="col-sm-10">
                        {!! Form::number('bitcoins', $user->btc_balance, ['id' => 'input-bitcoins','class' => 'form-control', 'placeholder' => 'Number of Bitcoins', 'min' => 0]) !!}
                        <span class="help-block m-b-none">For which you'll buy the tokens.</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <span>You'll get <span class="h3" data-view-tokens>0</span> Tokens for <span class="h3"
                                                                                                         data-view-bitcoins>0</span> bitcoin(s).</span>
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
        var btc_value = {!! $btc_value !!};
        var token_rate = {!! $token_rate !!};
        var is_confirmed = false;

        var $btc_input = $("#input-bitcoins");
        var $token_purchase_form = $("#token-purchase-form");

        $btc_input.each(onBtcInputChange);
        $btc_input.on("change", onBtcInputChange);

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

        function onBtcInputChange() {
            var btc = $(this).val();
            var dollars = btc * btc_value;
            var tokens = dollars / token_rate;

            $("span[data-view-tokens]").text(tokens);
            $("span[data-view-bitcoins]").text(btc);
        }
    });
</script>
@endpush