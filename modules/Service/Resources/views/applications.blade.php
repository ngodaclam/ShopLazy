<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-header">
                <h3 class="panel-title">
                    <i class="fa fa-table"></i> {!! trans('service::application.applications') !!}
                </h3>

                <div class="control-btn">
                    <a href="{!! route('configuration.application.create') !!}"
                       class="btn btn-sm">{!! trans('core::general.add') !!}</a>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline no-footer">
                    <table class="table table-hover dataTable no-footer">
                        <thead>
                        <th class="col-sm-2">{!! trans('service::application.name') !!}</th>
                        <th class="col-sm-3">{!! trans('service::application.client_id') !!}</th>
                        <th class="col-sm-5">{!! trans('service::application.client_secret') !!}</th>
                        <th class="col-sm-2">{!! trans('core::general.action') !!}</th>
                        </thead>
                        <tbody>
                        @if (isset($clients) && $clients)
                            @foreach($clients as $client)
                                <tr>
                                    <td>{!! $client['name'] !!}</td>
                                    <td>{!! $client['id'] !!}</td>
                                    <td>{!! $client['secret'] !!}</td>
                                    <td>
                                        {!! Form::open(['url' => route('configuration.application.destroy', $client['id']), 'method' => 'delete', 'class' => 'form-horizontal']) !!}
                                        <button type="submit" class="btn btn-sm btn-danger" rel="tooltip"
                                                title="Destroy"><i class="fa fa-remove"></i></button>
                                        <a href="{!! route('configuration.application.edit', $client['id']) !!}"
                                           class="btn btn-sm btn-default" rel="tooltip" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="row">
                        {!! theme()->partial('paginator', ['paginator' => $paginator]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>