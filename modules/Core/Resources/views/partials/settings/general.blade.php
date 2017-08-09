<?php
/**
 * Created by NgocNH.
 * Date: 6/7/16
 * Time: 7:32 PM
 */
?>

<div class="row">
    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="general_meta_title">{!! trans('core::setting.general_meta_title') !!}</label>
        <div class="col-sm-8">
            <input type="text" class="form-control"
                   placeholder="{!! trans('core::setting.general_meta_title_placeholder') !!}"
                   id="general_meta_title" name="general[meta_title]"
                   value="{!! old('general.meta_title') ?: (isset($settings['general']['meta_title']) ? $settings['general']['meta_title'] : '') !!}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="general_meta_description">{!! trans('core::setting.general_meta_description') !!}</label>
        <div class="col-sm-8">
            <textarea class="form-control"
                      placeholder="{!! trans('core::setting.general_meta_description_placeholder') !!}"
                      id="general_meta_description" name="general[meta_description]"
                      rows="3">{!! old('general.meta_description') ?: (isset($settings['general']['meta_description']) ? $settings['general']['meta_description'] : '') !!}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="general_meta_keyword">{!! trans('core::setting.general_meta_keyword') !!}</label>
        <div class="col-sm-8">
            <textarea class="form-control"
                      placeholder="{!! trans('core::setting.general_meta_keyword_placeholder') !!}"
                      id="general_meta_keyword" name="general[general_meta_keyword]"
                      rows="3">{!! old('general.general_meta_keyword') ?: (isset($settings['general']['general_meta_keyword']) ? $settings['general']['general_meta_keyword'] : '') !!}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="general_admin_language">{!! trans('core::setting.general_admin_language') !!}</label>
        <div class="col-sm-8">
            <select class="form-control" id="general_admin_language" name="general[admin_language]">
                @if(isset($locales) && $locales)
                    @foreach($locales as $locale)
                        <option value="{!! $locale->id !!}" {!! old('general.admin_language') == $locale->id || (isset($settings['general']['admin_language']) && $settings['general']['admin_language'] == $locale->id) ? 'seleced' : '' !!}>{!! $locale->name !!}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label"
               for="general_site_language">{!! trans('core::setting.general_site_language') !!}</label>
        <div class="col-sm-8">
            <select class="form-control" id="general_site_language" name="general[site_language]">
                @if(isset($locales) && $locales)
                    @foreach($locales as $locale)
                        <option value="{!! $locale->id !!}" {!! old('general.site_language') == $locale->id || (isset($settings['general']['site_language']) && $settings['general']['site_language'] == $locale->id) ? 'seleced' : '' !!}>{!! $locale->name !!}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
