@extends('layouts.admin')

@section('content')
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
        <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- START widget-->
            <div class="panel widget bg-gray">
                <div class="row row-table">
                    <div class="col-xs-12 pv-lg">
                        <div class="text-uppercase">ADDRESS TO ACCEPT BITCOIN PAYMENTS</div>
                        <div class="input-group">
                            <input id="address-input" type="text" readonly
                                   value="{{ $address }}"
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
    <div class="panel panel-default" id="customer-list-panel">
        <div class="panel-heading"></div>
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
@endsection

@push('scripts')
<script>
    $(function () {

        var $transactions_table = $('#transactions-table').DataTable({
            responsive: true,
            errMode: 'throw',
            ajax: '{{ route("wallet.transactions.data") }}',
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

    })(jQuery);
</script>
@endpush