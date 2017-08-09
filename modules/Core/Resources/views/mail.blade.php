<?php
/**
 * Created by NgocNH.
 * Date: 6/7/16
 * Time: 9:58 PM
 */
?>
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
                            <a href="#contact" data-toggle="tab">
                                {!! trans('core::setting.mail_template_contact') !!}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class='tab-pane fade active in' id='contact'>
                            @include('core::partials.mails.contact')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>