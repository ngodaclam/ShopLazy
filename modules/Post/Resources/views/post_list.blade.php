<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-header">
                <h3 class="panel-title">
                    <i class="fa fa-table"></i> {!! trans('post::post.posts') !!}
                </h3>

                <div class="control-btn">
                    <a href="{!! route('post.create') !!}" class="btn btn-sm">{!! trans('core::general.add') !!}</a>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline no-footer">
                    <table id="postDatatables" class="table table-hover dataTable no-footer">
                        <thead>
                        <th>{!! trans('post::post.title') !!}</th>
                        <th>{!! trans('post::post.author') !!}</th>
                        <th>{!! trans('post::post.taxonomies') !!}</th>
                        <th>{!! trans('core::general.action') !!}</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#postDatatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('post.datatables') !!}',
                type: 'POST'
            },
            columns: [
                {data: 'title', name: 'title'},
                {data: 'author', name: 'author'},
                {data: 'taxonomies', name: 'taxonomies'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>