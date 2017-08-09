<div class="row">
    {!! Form::open(['url' => route('configuration.save'), 'class' => 'form-horizontal']) !!}
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-header">
                <h3>{!! trans('core::general.settings') !!}</h3>
                <div class="control-btn">
                    <button class="btn btn-sm btn-success">{!! trans('core::general.save') !!}</button>
                    <button class="btn btn-sm btn-default">{!! trans('core::general.cancel') !!}</button>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs nav-primary">
                        <li class="active">
                            <a href="#general" data-toggle="tab">
                                {!! trans('core::setting.general') !!}
                            </a>
                        </li>
                        <li>
                            <a href="#information" data-toggle="tab">
                                {!! trans('core::setting.information') !!}
                            </a>
                        </li>
                        {{--<li>--}}
                            {{--<a href="#mail" data-toggle="tab">--}}
                                {{--{!! trans('core::setting.mail') !!}--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    </ul>
                    <div class="tab-content">
                        <div class='tab-pane fade active in' id='general'>
                            @include('core::partials.settings.general')
                        </div>
                        <div class='tab-pane fade' id='information'>
                            @include('core::partials.settings.information')
                        </div>
                        {{--<div class='tab-pane fade' id='mail'>--}}
                            {{--@include('core::partials.settings.mail')--}}
                        {{--</div>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>