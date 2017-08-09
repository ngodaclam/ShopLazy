<?php
/**
 * Created by NgocNH.
 * Date: 6/7/16
 * Time: 7:42 PM
 */
?>
<div class="row">
    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="mail_protocol">{!! trans('core::setting.mail_protocol') !!}</label>
        <div class="col-sm-8">
            <select class="form-control"
                    id="mail_protocol" name="mail[protocol]">
                <option>{!! trans('core::setting.mail_protocol_placeholder') !!}</option>
                <option value="mail" {!! old('mail.protocol') == 'mail' || (isset($settings['mail']['protocol']) && $settings['mail']['protocol'] == 'mail')  ? 'selected' : '' !!}>Mail</option>
                <option value="smtp" {!! old('mail.protocol') == 'smtp' || (isset($settings['mail']['protocol']) && $settings['mail']['protocol'] == 'smtp')  ? 'selected' : '' !!}>SMTP</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="mail_server">{!! trans('core::setting.mail_server') !!}</label>
        <div class="col-sm-8">
            <input type="text" class="form-control"
                   placeholder="{!! trans('core::setting.mail_server') !!}"
                   id="mail_server" name="mail[server]"
                   value="{!! old('mail.server') ?: (isset($settings['mail']['server']) ? $settings['mail']['server'] : '') !!}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="mail_username">{!! trans('core::setting.mail_username') !!}</label>
        <div class="col-sm-8">
            <input type="text" class="form-control"
                   placeholder="{!! trans('core::setting.mail_username_placeholder') !!}"
                   id="mail_username" name="mail[username]"
                   value="{!! old('mail.username') ?: (isset($settings['mail']['username']) ? $settings['mail']['username'] : '') !!}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="mail_password">{!! trans('core::setting.mail_password') !!}</label>
        <div class="col-sm-8">
            <input type="password" class="form-control"
                   placeholder="{!! trans('core::setting.mail_password_placeholder') !!}"
                   id="mail_password" name="mail[password]"
                   value="{!! old('mail.password') ?: (isset($settings['mail']['password']) ? $settings['mail']['password'] : '') !!}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="mail_port">{!! trans('core::setting.mail_port') !!}</label>
        <div class="col-sm-8">
            <input type="number" class="form-control"
                   placeholder="{!! trans('core::setting.mail_port_placeholder') !!}"
                   id="mail_port" name="mail[port]"
                   value="{!! old('mail.port') ?: (isset($settings['mail']['port']) ? $settings['mail']['port'] : '') !!}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="mail_encryption">{!! trans('core::setting.mail_encryption') !!}</label>
        <div class="col-sm-8">
            <select class="form-control" id="mail_encryption" name="mail[encryption]">
                <option>{!! trans('core::setting.mail_encryption_placeholder') !!}</option>
                <option value="0" {!! old('mail.encryption') == 0 || (isset($settings['mail']['encryption']) && $settings['mail']['encryption'] == 0)  ? 'selected' : '' !!}>Mail</option>
                <option value="1" {!! old('mail.encryption') == 1 || (isset($settings['mail']['encryption']) && $settings['mail']['encryption'] == 1)  ? 'selected' : '' !!}>Mail</option>
            </select>
        </div>
    </div>
</div>
