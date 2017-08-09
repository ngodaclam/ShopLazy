<div class="row">
    {!! Form::open(['url' => isset($tag['id']) ? route('tag.update', [$tag['id']]) : route('tag.store')]) !!}
    <div class="col-sm-5 col-md-5">
        <div class="panel">
            <div class="panel-header">
                <h3 class="panel-title">
                    <i class="fa fa-table"></i> {!! trans('core::general.add') !!}
                </h3>

                <div class="control-btn">
                    <button type="submit" class="btn btn-sm btn-success">{!! trans('core::general.save') !!}</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab_left">
                    <ul class="nav nav-tabs nav-red">
                        @foreach($locales as $locale)
                            <li class="{!! $locale->code == app()->getLocale() ? 'active' : '' !!}">
                                <a href="#{!! $locale->code !!}" data-toggle="tab">{!! strtoupper($locale->code) !!}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($locales as $locale)
                            <div class="tab-pane fade {!! $locale->code == app()->getLocale() ? 'active in' : '' !!}"
                                 id="{!! $locale->code !!}">
                                <div class="form-group">
                                    <label class="control-label"
                                           for="name_{!! $locale->code !!}">{!! trans('post::tag.name') !!}</label>
                                    <input type="text" class="form-control" id="name_{!! $locale->code !!}"
                                           name="translate[{!! $locale->id !!}][name]"
                                           value="{!! isset($tag) ? $tag['translate'][$locale->code]['name'] : (old("translate.{$locale->id}.name") ?: '') !!}"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"
                                           for="description_{!! $locale->code !!}">{!! trans('post::tag.description') !!}</label>
                                    <textarea class="form-control" id="description_{!! $locale->code !!}"
                                              name="translate[{!! $locale->id !!}][description]"
                                            >{!! isset($tag) ? $tag['translate'][$locale->code]['description'] : (old("translate.{$locale->id}.description") ?: '') !!}</textarea>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label class="control-label" for="order">{!! trans('post::tag.order') !!}</label>
                            <input class="form-control" type="number" id="order" name="order"
                                   value="{!! isset($tag) ? $tag['order'] : (old('order') ?: '') !!}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="col-sm-7 col-md-7">
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">
                    <i class="fa fa-table"></i> {!! trans('post::tag.list') !!}
                </span>
            </div>
            <div class="panel-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline no-footer">
                    <table id="tag-datatables" class="table table-hover dataTable no-footer">
                        <thead>
                        <th class="col-sm-3">{!! trans('post::tag.name') !!}</th>
                        <th class="col-sm-6">{!! trans('post::tag.description') !!}</th>
                        <th class="col-sm-3">{!! trans('core::general.action') !!}</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#tag-datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('tag.datatables') !!}',
                type: 'POST'
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>