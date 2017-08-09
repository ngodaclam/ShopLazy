<?php
/**
 * Created by NgocNH.
 * Date: 6/7/16
 * Time: 7:33 PM
 */
?>
<div class="row">
    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="information_site_name">{!! trans('core::setting.information_site_name') !!}</label>
        <div class="col-sm-8">
            <input type="text" class="form-control"
                   placeholder="{!! trans('core::setting.information_site_name_placeholder') !!}"
                   id="information_site_name" name="information[site_name]"
                   value="{!! old('information.site_name') ?: (isset($settings['information']['site_name']) ? $settings['information']['site_name'] : '') !!}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="information_site_owner">{!! trans('core::setting.information_site_owner') !!}</label>
        <div class="col-sm-8">
            <input type="text" class="form-control"
                   placeholder="{!! trans('core::setting.information_site_owner') !!}"
                   id="information_site_owner" name="information[site_owner]"
                   value="{!! old('information.site_owner') ?: (isset($settings['information']['site_owner']) ? $settings['information']['site_owner'] : '') !!}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="information_address">{!! trans('core::setting.information_address') !!}</label>
        <div class="col-sm-8">
            <textarea class="form-control"
                      placeholder="{!! trans('core::setting.information_address_placeholder') !!}"
                      id="information_address" name="information[information_address]"
                      rows="3">{!! old('information.information_address') ?: (isset($settings['information']['information_address']) ? $settings['information']['information_address'] : '') !!}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="information_email">{!! trans('core::setting.information_email') !!}</label>
        <div class="col-sm-8">
            <input type="email" class="form-control"
                   placeholder="{!! trans('core::setting.information_email_placeholder') !!}"
                   id="information_email" name="information[email]"
                   value="{!! old('information.email') ?: (isset($settings['information']['email']) ? $settings['information']['email'] : '') !!}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="information_phone">{!! trans('core::setting.information_phone') !!}</label>
        <div class="col-sm-8">
            <input type="tel" class="form-control"
                   placeholder="{!! trans('core::setting.information_phone_placeholder') !!}"
                   id="information_phone" name="information[phone]"
                   value="{!! old('information.phone') ?: (isset($settings['information']['phone']) ? $settings['information']['phone'] : '') !!}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="information_mobile">{!! trans('core::setting.information_mobile') !!}</label>
        <div class="col-sm-8">
            <input type="tel" class="form-control"
                   placeholder="{!! trans('core::setting.information_mobile_placeholder') !!}"
                   id="information_mobile" name="information[mobile]"
                   value="{!! old('information.mobile') ?: (isset($settings['information']['mobile']) ? $settings['information']['mobile'] : '') !!}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="information_fax">{!! trans('core::setting.information_fax') !!}</label>
        <div class="col-sm-8">
            <input type="tel" class="form-control"
                   placeholder="{!! trans('core::setting.information_fax_placeholder') !!}"
                   id="information_fax" name="information[fax]"
                   value="{!! old('information.fax') ?: (isset($settings['information']['fax']) ? $settings['information']['fax'] : '') !!}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="information_logo">{!! trans('core::setting.information_logo') !!}</label>
        <div class="col-sm-8">
            <input type="hidden" class="form-control"
                   id="information_logo" name="information[logo]"
                   value="{!! old('information.logo') ?: (isset($settings['information']['logo']) ? $settings['information']['logo'] : '') !!}"/>
            <div class="thumbnail" style="height: 150px; width: 150px;" onclick="ckfinder($('#information_logo_src'), $('#information_logo'))">
                <img id="information_logo_src"
                     src="{!! old('information.logo') ?: (isset($settings['information']['logo']) ? url($settings['information']['logo']) : '') !!}"
                     class="img-responsive"/>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="information_icon">{!! trans('core::setting.information_icon') !!}</label>
        <div class="col-sm-8">
            <input type="hidden" class="form-control"
                   id="information_icon" name="information[icon]"
                   value="{!! old('information.icon') ?: (isset($settings['information']['icon']) ? $settings['information']['icon'] : '') !!}"/>
            <div class="thumbnail" style="height: 150px; width: 150px;" onclick="ckfinder($('#information_icon_src'), $('#information_icon'))">
                <img id="information_icon_src"
                     src="{!! old('information.icon') ?: (isset($settings['information']['icon']) ? url($settings['information']['icon']) : '') !!}"
                     class="img-responsive"/>
            </div>
        </div>
    </div>
</div>
