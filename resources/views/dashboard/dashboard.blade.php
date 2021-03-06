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
    <!-- START widgets box-->
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-purple-custom text-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center pv-lg">
                        <em class="icon-chart fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h3 mt0 mb0">{{ $btc_balance }}</div>
                        <div class="h6 mt0 mb-sm text-dark text-bold">{{ $unc_balance }}</div>
                        <div class="text-uppercase">BTC Deposit</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-pink-custom text-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center pv-lg">
                        <em class="fa fa-bitcoin fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">${{ number_format( $btc_value, 2 ) }}</div>
                        <div class="text-uppercase">BTC Value</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-red-custom text-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center pv-lg">
                        <img src="{{ asset('/img/currency-light.png') }}"/>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">{{ $user->token_balance }}</div>
                        <div class="text-uppercase">Tokens</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-orange-custom text-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center pv-lg">
                        <em class="fa fa-dollar fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">${{ number_format( $token_rate, 2 ) }}</div>
                        <div class="text-uppercase">Token Rate</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- START widget-->
            <div class="panel widget bg-gray">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-gray-dark pv-lg">
                        <em class="icon-wallet fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">0.00</div>
                        <div class="text-uppercase">Gram Coin</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- START date widget-->
            <div class="panel widget">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-green pv-lg">
                        <!-- See formats: https://docs.angularjs.org/api/ng/filter/date-->
                        <div data-now="" data-format="MMMM" class="text-sm">January</div>
                        <br>
                        <div data-now="" data-format="D" class="h2 mt0">00</div>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div data-now="" data-format="dddd" class="text-uppercase">Thursday</div>
                        <br>
                        <div data-now="" data-format="h:mm" class="h2 mt0">00:00</div>
                        <div data-now="" data-format="a" class="text-muted text-sm">pm</div>
                    </div>
                </div>
            </div>
            <!-- END date widget    -->
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- START widget-->
            <div class="panel widget bg-gray">
                <div class="row row-table">
                    <div class="col-xs-12 pv-lg">
                        <div class="text-uppercase">Referral Link</div>
                        <div class="input-group">
                            <input id="address-input" type="text" readonly
                                   value="{{ route('register.referral', $user->guid) }}"
                                   class="form-control" style="height: 44px;"/>
                            <span class="input-group-btn">
                                    <button type="button" data-copy-text="#address-input" class="btn btn-default"
                                            style="height: 44px;"><em
                                                class="fa fa-files-o"></em></button>
                                 </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- START dashboard main content-->
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
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
                                <div class="row bg-purple-custom text-white">
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">Recent Transactions</div>
                        </div>
                        <div class="panel-body">
                            <table class="table table table-striped table-hover table-bordered table-bordered-force"
                                   id="transactions-table">
                                <thead>
                                <tr>
                                    <th style="text-align: left;">Date/Time</th>
                                    <th style="text-align: left;">TX #</th>
                                    <th style="text-align: left;">Recipient</th>
                                    <th style="text-align: left;">Amount</th>
                                    <th style="text-align: left;">Status</th>
                                    <th style="text-align: left;">In/Out</th>
                                </tr>
                                </thead>
                            </table>
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

        var $transactions_table = $('#transactions-table').DataTable({
            responsive: true,
            errMode: 'throw',
            ajax: '{{ route("wallet.transactions.limited_data", [ 10 ]) }}',
            fnInitComplete: function (settings) {
                var $tbl = this;

                $tbl.addClass("linkedrows");
                $($tbl.fnGetNodes()).click(function (e) {
                    var iPos = $tbl.fnGetPosition(this);
                    var row = settings.aoData[iPos]._aData;

                    if ($(e.target).is('td'))
                        document.location.href = '{{ url("wallet/transactions/")}}/' + row.id;
                });
            },
            order: [0, 'desc'],
            columns: [
                {
                    name: 'created_at_human',
                    data: 'created_at_human'
                },
                {
                    bSortable: false,
                    name: 'tx_hash',
                    data: function (row) {
                        return row.tx_hash.substring(0, 40) + (row.tx_hash.length > 40 ? '...' : '');
                    }
                },
                {
                    bSortable: false,
                    name: 'recipient',
                    data: 'recipient'
                },
                {
                    name: 'amount_in_btc',
                    data: function (row) {
                        return row.amount_in_btc + ' BTC';
                    },
                    className: 'text-right',
                },
                {
                    bSortable: false,
                    name: 'status',
                    data: function (row) {
                        return row.status;
                    }
                },
                {
                    bSortable: false,
                    name: 'direction',
                    data: function (row) {
                        if (row.direction == 'sent') {
                            return '<em class="icon icon-arrow-up-circle text-green"></em>';
                        } else {
                            return '<em class="icon icon-arrow-down-circle text-primary"></em>';
                        }
                    }
                }
            ],
            dom: '<"html5buttons"B <"ml pull-right"C>>lTfgitp',
            colVis: {
                buttonText: "Column Visibility",
                activate: "click",
                sButtonClass: 'btn btn-primary'
            },
            buttons: [
                {
                    extend: 'pdf',
                    text: 'PDF',
                }, {
                    extend: 'csv',
                    text: 'CSV'
                }, {
                    extend: 'print',
                    text: 'Print'
                }
            ]
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