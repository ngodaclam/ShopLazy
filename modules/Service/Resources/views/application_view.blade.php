<div class="row">
    {!! Form::open(['url' => isset($client['id']) ? route('configuration.application.update', $client['id']) : route('configuration.application.store'), 'class' => 'form-horizontal', 'method' => isset($client['id']) ? 'put' : 'post']) !!}
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-header">
                <h4 class="panel-title">
                    <i class="fa fa-pencil"></i> Scopes
                </h4>

                <div class="control-btn">
                    <button class="btn btn-sm btn-success">{!! trans('core::general.save') !!}</button>
                    <button class="btn btn-sm btn-default">{!! trans('core::general.cancel') !!}</button>
                </div>
            </div>
            <div class="panel-body">
                @foreach($permissions as $key => $permission)
                    <div class="row">
                        <div class="col-sm-12">
                            <strong>{!! strtoupper($key) !!}</strong>
                        </div>
                        @foreach($permission as $perm)
                            <div class="col-sm-9 col-sm-offset-1">
                                {!! trans($perm['display_name']) !!}
                            </div>
                            <div class="col-sm-2">
                                <div class="onoffswitch2">
                                    {{--<input type="hidden" name="scopes[{!! $perm['module'] !!}.{!! $perm['name'] !!}]" value="0"/>--}}
                                    <input type="checkbox" class="onoffswitch-checkbox"
                                           name="scopes[{!! $perm['module'] !!}.{!! $perm['name'] !!}]" id="{!! $perm['name'] !!}" value="1"
                                            {!! isset($client) && in_array($perm['name'], $client['scopes']) ? 'checked' : '' !!} >
                                    <label class="onoffswitch-label" for="{!! $perm['name'] !!}">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel">
            <div class="panel-header">
                <h4 class="panel-title">
                    <i class="fa fa-pencil"></i> Information
                </h4>
            </div>
            <div class="panel-body">
                <input type="hidden" name="id" value="{!! isset($client) && $client ? $client['id'] : '' !!}"/>

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="client_name">App Name</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="client_name" name="client_name"
                               value="{!! isset($client) && $client ? $client['name'] : '' !!}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="client_url">App URL</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="client_url" name="client_url"
                               value="{!! isset($client['endpoint']) ? $client['endpoints'][0] : '' !!}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>