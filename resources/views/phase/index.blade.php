@extends('layouts.admin')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <table class="table table table-striped table-hover table-bordered table-bordered-force"
                   id="phases-table">
                <thead>
                <tr>
                    <th style="text-align: left;">Title</th>
                    <th style="text-align: left;">Launch Date/Time</th>
                    <th style="text-align: left;">Number of Tokens</th>
                    <th style="text-align: left;">Status</th>
                    <th style="text-align: left;">Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('modals')
    @include('layouts.delete-modal')
@endsection

@push('scripts')
<script>
    $(function () {

        var $phases_table = $('#phases-table').DataTable({
            responsive: true,
            errMode: 'throw',
            ajax: '{{ route("phase.data") }}',
            fnInitComplete: function (settings) {
                var $tbl = this;

                $tbl.addClass("linkedrows");
                $($tbl.fnGetNodes()).click(function (e) {
                    var iPos = $tbl.fnGetPosition(this);
                    var row = settings.aoData[iPos]._aData;

                    if ($(e.target).is('td'))
                        document.location.href = '{{ url("phases/")}}/' + row.id + '/edit';
                });
            },
            order: [0, 'desc'],
            columns: [
                {
                    name: 'title',
                    data: 'title'
                },
                {
                    name: 'launch_time',
                    data: 'launch_time'
                },
                {
                    name: 'tokens',
                    data: 'tokens'
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
                    mRender: function (o) {
                        return "<div class='btn-group'><button class='btn btn-primary btn-sm' role='edit'><i class='fa fa-edit'></i></button><button class='btn btn-danger btn-sm' role='delete'><i class='fa fa-trash'></button></div>";
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

        var $delete_modal = $('#delete-modal');
        var $delete_modal_ids = $('#delete-modal-ids');

        $('#phases-table tbody').on('click', '.btn-group button', function () {
            var $button = $(this);
            var role = $button.attr('role');
            var data = $phases_table.row($button.parents('tr')).data();
            if (role == 'edit') {
                document.location.href = window.grm.url + "phases/" + data['id'] + "/edit";
            } else if (role == 'delete') {
                console.log(data);
                $delete_modal.on('show.bs.modal', function () {
                    $delete_modal.find('#delete-modal-message').html('Are you sure to delete `' + data['title'] + '` Phase?');
                    $delete_modal_ids.val(data['id']);
                });
                $delete_modal.modal('show');
            }
        });

        $delete_modal.on('click', '#delete-modal-confirmed', function () {
            $delete_modal.modal('hide');
            $.ajax({
                type: 'DELETE',
                url: '{{ url("phases") }}/' + $delete_modal_ids.val(),
                success: function (data) {
                    $.notify(data);
                    $phases_table.ajax.reload();
                },
                error: function (jqXHR, textStatus) {
                    $.notify({
                        status: 'danger',
                        title: 'Delete',
                        message: 'Phase couldn`t be deleted'
                    });
                },
                complete: function (jqXHR) {

                }
            });
        });

    })(jQuery);
</script>
@endpush