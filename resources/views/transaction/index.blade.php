@extends('layouts.admin')

@section('content')
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
            columns: [
                {
                    name: 'created_at_human',
                    data: 'created_at_human'
                },
                {
                    bSortable: false,
                    name: 'tx_hash',
                    data: function (row) {
                        return row.tx_hash;
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
                    data: function(row) {
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