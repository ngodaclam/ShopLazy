<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-header">
                <h3 class="panel-title">
                    <i class="fa fa-table"></i> {!! trans('core::user.user_list') !!}
                </h3>

                <div class="control-btn">
                    <a href="{!! route('user.create') !!}" class="btn btn-sm">{!! trans('core::general.add') !!}</a>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline no-footer">
                    <table id="user-datatables" class="table table-hover dataTable no-footer">
                        <thead>
                        <tr>
                            <th>{!! trans('core::user.email') !!}</th>
                            <th>{!! trans('core::user.fullname') !!}</th>
                            <th>{!! trans('core::user.role') !!}</th>
                            <th>{!! trans('core::general.action') !!}</th>
                        </tr>
                        </thead>
                        <tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#user-datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('user.datatables') !!}',
                type: 'POST'
            },
            columns: [
                {data: 'email', name: 'email'},
                {data: 'name', name: 'name'},
                {data: 'roles', name: 'roles'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>