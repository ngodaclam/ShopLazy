<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-header">
                <h4 class="panel-title">{!! trans('core::role.list') !!}</h4>

                <div class="control-btn">
                    <a href="{!! route('role.create') !!}" class="btn btn-sm">{!! trans('core::general.add') !!}</a>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline no-footer">
                    <table class="table table-hover dataTable no-footer">
                        <thead>
                        <th class="col-sm-1">{!! trans('core::role.id') !!}</th>
                        <th class="col-sm-3">{!! trans('core::role.display_name') !!}</th>
                        <th class="col-sm-5">{!! trans('core::role.description') !!}</th>
                        <th class="col-sm-3">{!! trans('core::general.action') !!}</th>
                        </thead>
                        <tbody>
                        @if (isset($roles) && $roles)
                            @foreach($roles as $role)
                                <tr>
                                    <td>{!! $role['id'] !!}</td>
                                    <td>{!! $role['display_name'] !!}</td>
                                    <td>{!! $role['description'] !!}</td>
                                    <td>
                                        {!! Form::open(['url' => "role/" . $role['id'], 'method' => 'delete', 'class' => 'form-horizontal']) !!}
                                        @if ($role['id'] != 1 && $role['id'] != 2)
                                            <button type="submit" class="btn btn-sm btn-danger" rel="tooltip"
                                                    title="trash"><i class="fa fa-remove"></i></button>
                                        @endif
                                        @if ($role['id'] != 1)
                                            <a href="{!! URL::route('role.edit', ['id' => $role['id']]) !!}"
                                               class="btn btn-sm btn-default" rel="tooltip" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        @endif
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