@extends('layouts.admin')

@section('content')
    <div class="panel panel-default" id="customer-list-panel">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <table class="table table table-striped table-hover table-bordered table-bordered-force"
                   id="transactions-table">
                <thead>
                <tr>
                    <th style="text-align: left;">TX #</th>
                    <th style="text-align: left;">Recipient</th>
                    <th style="text-align: left;">Amount</th>
                    <th style="text-align: left;">Confirmations</th>
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
                        document.location.href = '{{ url("wallet/transaction/")}}/' + row.id;
                });
            },
            columns: [
                {
                    name: 'tx_hash',
                    data: function (row) {
                        return row.tx_hash;
                    }
                },
                {
                    name: 'recipient',
                    data: 'recipient'
                },
                {
                    name: 'amount',
                    data: function (row) {
                        return '$' + Math.round(row.amount);
                    },
                    className: 'text-right',
                },
                {
                    name: 'confirmations',
                    data: 'confirmations'
                },
                {
                    name: 'status',
                    data: 'status'
                },
                {
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