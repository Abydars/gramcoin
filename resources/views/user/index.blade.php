@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-purple-custom text-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center pv-lg">
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
            <div class="panel widget bg-pink-custom text-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center pv-lg">
                        <em class="icon-user fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">{{ $inactive_users }}</div>
                        <div class="text-uppercase">Inactive Users</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default" id="users-panel">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <table class="table table table-striped table-hover table-bordered table-bordered-force"
                   id="users-table">
                <thead>
                <tr>
                    <th style="text-align: left;">Full Name</th>
                    <th style="text-align: left;">Email</th>
                    <th style="text-align: left;">Balance</th>
                    <th style="text-align: left;">Spend</th>
                    <th style="text-align: left;">Status</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function () {

        var $users_table = $('#users-table').DataTable({
            responsive: true,
            errMode: 'throw',
            ajax: '{{ route("user.data") }}',
            fnInitComplete: function (settings) {
                var $tbl = this;

                $tbl.addClass("linkedrows");
                $($tbl.fnGetNodes()).click(function (e) {
                    var iPos = $tbl.fnGetPosition(this);
                    var row = settings.aoData[iPos]._aData;

                    if ($(e.target).is('td'))
                        document.location.href = '{{ url("user/")}}/' + row.id;
                });
            },
            columns: [
                {
                    name: 'full_name',
                    data: 'full_name'
                },
                {
                    name: 'email',
                    data: 'email'
                },
                {
                    name: 'btc_balance_in_btc',
                    data: function (row) {
                        return row.btc_balance_in_btc + ' BTC';
                    },
                    className: 'text-right',
                },
                {
                    name: 'spend',
                    data: function (row) {
                        return row.spend + ' BTC';
                    },
                    className: 'text-right',
                },
                {
                    bSortable: false,
                    name: 'status',
                    data: function (row) {
                        return row.status;
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