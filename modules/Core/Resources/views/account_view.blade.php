<div class="row">
    {!! Form::open(['url' => isset($user['id']) ? route('user.update', ['id' => $user['id']]) : route('user.store'), 'class' => 'form-horizontal']) !!}
    <div class="col-md-7">
        <div class="panel">
            <div class="panel-header">
                <h4 class="panel-title">
                    <i class="fa fa-pencil"></i> {!! trans('core::user.profile') !!}
                </h4>

                <div class="control-btn">
                    <button class="btn btn-sm btn-success">{!! trans('core::general.save') !!}</button>
                    <button class="btn btn-sm btn-default">{!! trans('core::general.cancel') !!}</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-4 control-label"
                               for="first_name">{!! trans('core::user.first_name') !!}</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="first_name" name="meta[first_name]"
                                   value="{!! isset($user['meta']['first_name']) ? $user['meta']['first_name'] : (old('meta')['first_name'] ?: '') !!}"
                                   placeholder="{!! trans('core::user.first_name_placeholder') !!}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"
                               for="last_name">{!! trans('core::user.last_name') !!}</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="last_name" name="meta[last_name]"
                                   value="{!! isset($user['meta']['last_name']) ? $user['meta']['last_name'] : (old('meta')['first_name'] ?: '') !!}"
                                   placeholder="{!! trans('core::user.last_name') !!}"/>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-4">
                            <button type="submit" class="btn btn-success">{!! trans('core::general.save') !!}</button>
                            <button type="button" class="btn btn-default">{!! trans('core::general.cancel') !!}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="panel">
            <div class="panel-header">
                <h4 class="panel-title">
                    <i class="fa fa-user"></i> {!! trans('core::user.account') !!}
                </h4>
            </div>
            <div class="panel-body">
                <input type="hidden" name="id" value="{!! isset($user['id']) ? $user['id'] : '' !!}"/>
                <input type="hidden" name="type"
                       value="{!! isset($user['type']) ? $user['type'] : (old('type') ?: 'default') !!}"/>

                <div class="form-group row">
                    <label class="control-label" for="username">{!! trans('core::user.username') !!}</label>

                    <div class="input-group input-group-sm">
                        <input type="text"
                               class="form-control {!! $errors->has('error_username') ? 'form-error' : '' !!}"
                               id="username" name="username"
                               value="{!! isset($user['username']) ? $user['username'] : (old('username') ?: '') !!}"
                               placeholder="{!! trans('core::user.username_placeholder') !!}"
                                {!! isset($user['username']) ? 'readonly' : '' !!} />
                        <span class="input-group-addon"><i class="icon-user"></i></span>
                    </div>
                    @if ($errors->has('username'))
                        @foreach($errors->get('username') as $error)
                            <div id="username-error" class="form-error">{!! $error !!}</div>
                        @endforeach
                    @endif
                </div>
                <div class="form-group row">
                    <label class="control-label" for="email">{!! trans('core::user.email') !!}</label>

                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control {!! $errors->has('email') ? 'form-error' : '' !!}"
                               id="email" name="email"
                               value="{!! isset($user['email']) ? $user['email'] :(old('email') ?: '') !!}"
                               placeholder="{!! trans('core::user.email') !!}"
                                {!! isset($user['email']) ? 'readonly' : '' !!} />
                        <span class="input-group-addon"><i class="icon-envelope"></i></span>
                    </div>
                    @if ($errors->has('email'))
                        @foreach($errors->get('email') as $error)
                            <div id="email-error" class="form-error">{!! $error !!}</div>
                        @endforeach
                    @endif
                </div>
                @if (isset($user['id']))
                    <div class="form-group row">
                        <label class="control-label"
                               for="new_password">{!! trans('core::user.new_password') !!}</label>
                        <input type="password"
                               class="form-control {!! $errors->has('new_password') ? 'form-error' : '' !!}"
                               id="new_password" name="new_password"
                               placeholder="{!! trans('core::user.new_password_placeholder') !!}"
                               value="{!! old('new_password') ?: '' !!}"/>
                        @if ($errors->has('new_password'))
                            @foreach($errors->get('new_password') as $error)
                                <div id="new_password-error" class="form-error">{!! $error !!}</div>
                            @endforeach
                        @endif
                    </div>
                @else
                    <div class="form-group row">
                        <label class="control-label" for="password">{!! trans('core::user.password') !!}</label>
                        <input type="password" class="form-control {!! $errors->has('password') ? 'form-error' : '' !!}"
                               id="password" name="password"
                               placeholder="{!! trans('core::user.password_placeholder') !!}"
                               value="{!! old('password') ?: '' !!}"/>
                        @if ($errors->has('password'))
                            @foreach($errors->get('password') as $error)
                                <div id="password-error" class="form-error">{!! $error !!}</div>
                            @endforeach
                        @endif
                    </div>
                @endif
                <div class="form-group row">
                    <label class="control-label"
                           for="re_password">{!! trans('core::user.password_confirm') !!}</label>
                    <input type="password"
                           class="form-control {!! $errors->has('password_confirm') ? 'form-error' : '' !!}"
                           id="password_confirm" name="password_confirm"
                           placeholder="{!! trans('core::user.password_confirm_placeholder') !!}"
                           value="{!! old('password_confirm') ?: '' !!}"/>
                    @if ($errors->has('password_confirm'))
                        @foreach($errors->get('password_confirm') as $error)
                            <div id="password_confirm-error" class="form-error">{!! $error !!}</div>
                        @endforeach
                    @endif
                </div>
                <div class="form-group row">
                    <label class="control-label" for="roles">{!! trans('core::user.role') !!}</label>
                    <select multiple class="form-control {!! $errors->has('roles') ? 'form-error' : '' !!}"
                            id="roles" name="roles[]"
                            data-placeholder="{!! trans('core::user.role_placeholder') !!}">
                        @if (isset($roles) && $roles)
                            @foreach($roles as $role)
                                <option value="{!! $role['id'] !!}" {!! (old('roles') == $role['id']) || (isset($user['roles']) && in_array($role['id'], array_pluck($user['roles'], 'id'))) ? 'selected' : '' !!}>{!! $role['display_name'] !!}</option>
                            @endforeach
                        @else
                            <option></option>
                        @endif
                    </select>
                    @if ($errors->has('roles'))
                        @foreach($errors->get('roles') as $error)
                            <div id="role-error" class="form-error">{!! $error !!}</div>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="status">{!! trans('core::user.status') !!}</label>

                    <div class="col-sm-8">
                        <div class="onoffswitch2">
                            <input type="checkbox" name="status" class="onoffswitch-checkbox" id="status"
                                    {!! isset($user['status']) && $user['status'] == 1 ? 'checked' : '' !!}>
                            <label class="onoffswitch-label" for="status">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>