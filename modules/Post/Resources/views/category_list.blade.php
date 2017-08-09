<div class="row">
    {!! Form::open(['url' => isset($category['id']) ? route('category.update', [$category['id']]) : route('category.store')]) !!}
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
                                           for="name_{!! $locale->code !!}">{!! trans('post::category.name') !!}</label>
                                    <input type="text" class="form-control" id="name_{!! $locale->code !!}"
                                           name="translate[{!! $locale->id !!}][name]"
                                           value="{!! isset($category) ? $category['translate'][$locale->code]['name'] : (old("translate.{$locale->id}.name") ?: '') !!}"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"
                                           for="description_{!! $locale->code !!}">{!! trans('post::category.description') !!}</label>
                                    <textarea class="form-control" id="description_{!! $locale->code !!}"
                                              name="translate[{!! $locale->id !!}][description]"
                                            >{!! isset($category) ? $category['translate'][$locale->code]['description'] : (old("translate.{$locale->id}.description") ?: '') !!}</textarea>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label class="control-label" for="parent">{!! trans('post::category.parent') !!}</label>
                            <select class="form-control" id="parent" name="parent">
                                <option></option>
                                @foreach($taxonomies as $taxonomy)
                                    @if (!isset($category) || (!$taxonomy['parent'] && $taxonomy['id'] != $category['id']))
                                        <option value="{!! $taxonomy['id'] !!}" {!! isset($category) && $category['parent'] == $taxonomy['id'] ? 'selected' : (old('parent') == $taxonomy['id'] ? 'selected' : '') !!}>{!! $taxonomy['name'] !!}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="order">{!! trans('post::category.order') !!}</label>
                            <input class="form-control" type="number" id="order" name="order"
                                   value="{!! isset($category) ? $category['order'] : (old('order') ?: '') !!}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="order">{!! trans('post::category.order') !!}</label>
                            <input class="form-control" type="number" id="order" name="order"
                                   value="{!! isset($category) ? $category['order'] : (old('order') ?: '') !!}"/>
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
                    <i class="fa fa-table"></i> {!! trans('post::category.list') !!}
                </span>
            </div>
            <div class="panel-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline no-footer">
                    <table id="category-datatables" class="table table-hover dataTable no-footer">
                        <thead>
                        <th class="col-sm-3">{!! trans('post::category.name') !!}</th>
                        <th class="col-sm-6">{!! trans('post::category.description') !!}</th>
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
        $('#category-datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('category.datatables') !!}',
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