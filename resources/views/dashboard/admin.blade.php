@extends('layouts.admin')

@section('modals')
@endsection

@section('content')
    <!-- START widgets box-->
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-primary">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-primary-dark pv-lg">
                        <em class="icon-user fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">{{ $active_users }}</div>
                        <div class="text-uppercase">Active Users</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-warning-light">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-warning-dark pv-lg">
                        <em class="fa fa-user fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">{{ $top_user->full_name }}</div>
                        <div class="text-uppercase">Top User</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-purple">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-purple-dark pv-lg">
                        <em class="icon-tag fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h3 mt0 mb0">{{ $sold_tokens }}</div>
                        <div class="h6 mt0 mb-sm text-white text-bold">Total: {{ $tokens }}</div>
                        <div class="text-uppercase">Sold Tokens</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-green">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-green-dark pv-lg">
                        <em class="fa fa-dollar fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">${{ number_format( $token_rate, 2 ) }}</div>
                        <div class="text-uppercase">Token Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- START dashboard main content-->
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-body pt0 pb0">
                            @foreach($past_phases as $phase)
                                <div class="row bg-gray">
                                    <div class="col-lg-6">
                                        <h3 class="text-muted">{{ $phase->title }}</h3>
                                        <p class="text-muted"><span>{{ $phase->tokens }} GRM</span></p>
                                    </div>
                                    <div class="col-lg-6 h4 text-right text-muted">
                                        <span>{{ \Carbon\Carbon::parse($phase->launch_time)->toFormattedDateString() }}
                                            at {{ \Carbon\Carbon::parse($phase->launch_time)->toTimeString() }}</span>
                                        <br/>
                                        <span>Token Price: ${{ number_format($phase->token_rate, 2) }}</span>
                                    </div>
                                </div>
                            @endforeach
                            @if($active_phase)
                                <div class="row bg-info text-white">
                                    <div class="clearfix">
                                        <div class="col-lg-6">
                                            <h3>{{ $active_phase->title }}</h3>
                                            <p>Bought: <span>{{ $active_phase->bought }}
                                                    /{{ $active_phase->tokens }} GRM</span></p>
                                        </div>
                                        <div class="col-lg-6 text-right text-bold">
                                            <div class="h2">Token Price:
                                                ${{ number_format($active_phase->token_rate, 2) }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="progress progress-striped progress-xs">
                                            <div class="progress-bar progress-bar-danger" role="progressbar"
                                                 aria-valuenow="{{ (($active_phase->bought * 100) / $active_phase->tokens) }}"
                                                 aria-valuemin="0" aria-valuemax="100"
                                                 style="width: {{ (($active_phase->bought * 100) / $active_phase->tokens) }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @foreach($inactive_phases as $phase)
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h3 class="text-muted">{{ $phase->title }}</h3>
                                        <p class="text-muted"><span>{{ $phase->tokens }} GRM</span></p>
                                    </div>
                                    <div class="col-lg-6 h4 text-right text-muted">
                                        <span>{{ \Carbon\Carbon::parse($phase->launch_time)->toFormattedDateString() }}
                                            at {{ \Carbon\Carbon::parse($phase->launch_time)->toTimeString() }}</span>
                                        <br/>
                                        <span>Token Price: ${{ number_format($phase->token_rate, 2) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END dashboard main content-->
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
        var $countdown = $("#countdown");
        var $token_purchase_form = $("#token-purchase-form");

        $btc_input.each(onBtcChange);

        $btc_input.on("keyup", onBtcChange);
        $gc_input.on("keyup", onGcChange);

        var countdown_interval = setInterval(updateCountdown, 1000);

        $token_purchase_form.on("submit", function () {

            if ($gc_input.val() <= 0)
                return false;

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

            $("#input-gc").val(Math.round(btc_in_gc));
            $("#input-usd").val(btc_in_dollar);
        }

        function updateCountdown() {
            var date = new Date(Date.parse($countdown.data('date')));
            var now = new Date();

            now = new Date(now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate(), now.getUTCHours(), now.getUTCMinutes(), now.getUTCSeconds());

            console.log(now);
            var diff = window.grm.daysBetween(now, date);

            if (diff.days <= 0 && diff.hours <= 0 && diff.minutes <= 0 && diff.seconds <= 0) {
                $countdown.fadeOut();
                clearInterval(countdown_interval);

                window.location.href = window.location.href;
            }

            $countdown.find('[data-countdown-days]').text((diff.days > 9 ? diff.days : "0" + diff.days));
            $countdown.find('[data-countdown-hours]').text(diff.hours > 9 ? diff.hours : "0" + diff.hours);
            $countdown.find('[data-countdown-minutes]').text(diff.minutes > 9 ? diff.minutes : "0" + diff.minutes);
            $countdown.find('[data-countdown-seconds]').text(diff.seconds > 9 ? diff.seconds : "0" + diff.seconds);
        }
    });
</script>
@endpush