<div class="row">
    {!! Form::open(['url' => isset($role['id']) ? route('role.update', ['id' => $role['id']]) : route('role.store'), 'class' => 'form-horizontal']) !!}
    <div class="col-md-7">
        <div class="panel">
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#permissions"
                                          data-toggle="tab">{!! trans('core::role.tab_permissions') !!}</a></li>
                    <li><a href="#scopes" data-toggle="tab">{!! trans('core::role.tab_scopes') !!}</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane face active in" id="permissions">
                        @if (session()->has('error_permissions'))
                            @foreach(session('error_permissions') as $error)
                                <div id="username-error" class="form-error">{!! $error !!}</div>
                            @endforeach
                        @endif
                        @foreach($permissions as $module => $permission)
                            <div class="col-sm-12">
                                <strong>{!! ucfirst($module) !!}</strong>
                            </div>
                            @foreach($permission as $perm)
                                <div class="row">
                                    <div class="col-sm-9 col-sm-offset-1">
                                        {!! trans($perm['display_name']) !!}
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="onoffswitch2">
                                            <input type="checkbox" class="onoffswitch-checkbox"
                                                   name="permissions[{!! $perm['module'] !!}.{!! $perm['name'] !!}]"
                                                   id="{!! $perm['name'] !!}" value="1"
                                                    {!! isset($role) && (in_array('access.all', array_pluck($role['permissions'], 'name')) || in_array($perm['name'], array_pluck($role['permissions'], 'name'))) ? 'checked' : '' !!} >
                                            <label class="onoffswitch-label" for="{!! $perm['name'] !!}">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="tab-pane face" id="scopes">
                        @if (session()->has('error_permissions'))
                            @foreach(session('error_permissions') as $error)
                                <div id="username-error" class="form-error">{!! $error !!}</div>
                            @endforeach
                        @endif
                        @foreach($api_permissions as $module => $permission)
                            <div class="col-sm-12">
                                <strong>{!! ucfirst($module) !!}</strong>
                            </div>
                            @foreach($permission as $perm)
                                <div class="row">
                                    <div class="col-sm-9 col-sm-offset-1">
                                        {!! trans($perm['display_name']) !!}
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="onoffswitch2">
                                            <input type="checkbox" class="onoffswitch-checkbox"
                                                   name="permissions[{!! $perm['module'] !!}.{!! $perm['name'] !!}]"
                                                   id="{!! $perm['name'] !!}" value="1"
                                                    {!! isset($role) && (in_array('api.access.all', array_pluck($role['permissions'], 'name')) || in_array($perm['name'], array_pluck($role['permissions'], 'name'))) ? 'checked' : '' !!} >
                                            <label class="onoffswitch-label" for="{!! $perm['name'] !!}">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="panel">
            <div class="panel-header">
                <h4 class="panel-title">{!! trans('core::role.detail') !!}</h4>

                <div class="control-btn">
                    <button type="submit" class="btn btn-sm btn-success">{!! trans('core::general.save') !!}</button>
                    <button type="button" class="btn btn-sm btn-default">{!! trans('core::general.cancel') !!}</button>
                </div>
            </div>
            <div class="panel-body">
                <input type="hidden" name="id" value="{!! isset($role) ? $role['id'] : '' !!}">

                <div class="col-sm-12 form-group">
                    <label class="control-label" for="display_name">{!! trans('core::role.display_name') !!}</label>
                    <input type="text"
                           class="form-control input-transparent {!! session()->has('error_display_name') ? 'form-error' : '' !!}"
                           id="display_name" name="display_name"
                           placeholder="{!! trans('core::role.display_name_placeholder') !!}"
                           value="{!! isset($role['display_name']) ? $role['display_name'] : '' !!}"
                           required/>
                    @if (session()->has('error_display_name'))
                        @foreach(session('error_display_name') as $error)
                            <div id="display_name-error" class="form-error">{!! $error !!}</div>
                        @endforeach
                    @endif
                </div>
                <div class="col-sm-12 form-group">
                    <label class="control-label" for="description">{!! trans('core::role.description') !!}</label>
                    <textarea class="form-control" id="description"
                              name="description">{!! isset($role['description']) ? $role['description'] : '' !!}</textarea>
                </div>
                <div class="col-sm-6 form-group">
                    <label class="control-label" for="default">{!! trans('core::role.default') !!}</label>
                </div>
                <div class="col-sm-6 form-group">
                    <div class="onoffswitch2">
                        <input type="checkbox" class="onoffswitch-checkbox"
                               name="default" id="default"
                               value="1"
                                {!! isset($role['default']) && $role['default'] == 1 ? 'checked' : '' !!}>
                        <label class="onoffswitch-label" for="default">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>