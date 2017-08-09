<?php
/**
 * Created by NgocNH.
 * Date: 2/18/16
 * Time: 8:22 PM
 */
?>

<div class="row">
    {!! Form::open(['url' => isset($item['id']) ? route($route['update'], ['id' => $item['id']]) : route($route['store']), 'class' => 'form-horizontal']) !!}
    <div class="col-md-{!! isset($form['right']) && $form['right'] ? 7 : 5 !!}">
        <div class="panel">
            <div class="panel-header">
                <h4 class="panel-title">
                    <i class="fa fa-pencil"></i> {!! isset($data['title']) ? trans($data['title']) : trans('core::general.information') !!}
                </h4>

                <div class="control-btn">
                    @if (isset($form['buttons']['left']) && $form['buttons']['left'])
                        @foreach($form['buttons']['left'] as $button)
                            {!! Shortcode::compile($button) !!}
                        @endforeach
                    @else
                        <button class="btn btn-sm btn-success">{!! trans('core::general.save') !!}</button>
                        <button class="btn btn-sm btn-default">{!! trans('core::general.cancel') !!}</button>
                    @endif
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    @foreach($form['left'] as $formInput)
                        <div class="form-group">
                            {!! \Shortcode::compile($formInput) !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @if (isset($form['right']) && $form['right'])
        <div class="col-md-5">
            <div class="panel">
                <div class="panel-header">
                    <h4 class="panel-title">
                        <i class="fa fa-user"></i> {!! isset($data['subtitle']) ? trans('core::user.account') : trans('core::general.publish') !!}
                    </h4>

                    <div class="control-btn">
                        @if (isset($form['buttons']['right']) && $form['buttons']['right'])
                            @foreach($form['buttons']['right'] as $button)
                                {!! Shortcode::compile($button) !!}
                            @endforeach
                        @else
                            <button class="btn btn-sm btn-success">{!! trans('core::general.save') !!}</button>
                            <button class="btn btn-sm btn-default">{!! trans('core::general.cancel') !!}</button>
                        @endif
                    </div>
                </div>
                <div class="panel-body">
                    <input type="hidden" name="id" value="{!! isset($item['id']) ? $item['id'] : '' !!}"/>
                    @foreach($form['right'] as $formInput)
                        <div class="form-group row">
                            {!! \Shortcode::compile($formInput) !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    {!! Form::close() !!}
</div>
