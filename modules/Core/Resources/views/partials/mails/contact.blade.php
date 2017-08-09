<?php
/**
 * Created by NgocNH.
 * Date: 6/7/16
 * Time: 10:02 PM
 */
?>
<div class="tab_left">
    <ul class="nav nav-tabs nav-primary">
        @foreach($locales as $locale)
            <li class="{!! $locale->code == App::getLocale() ? 'active' : '' !!}">
                <a href="#{!! $locale->code !!}" data-toggle="tab">
                    {!! $locale->name !!}
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach($locales as $locale)
            <div class='tab-pane fade {!! $locale->code == App::getLocale() ? 'active in' : '' !!}'
                 id='{!! $locale->code !!}'>
                <div class="form-group row">
                    <label class="control-label" for="mail_template_contact_{!! $locale->code !!}_subject">
                        {!! trans('core::setting.mail_template_subject') !!}
                    </label>
                    <input type="text" class="form-control"
                           id="mail_template_contact_{!! $locale->code !!}_subject"
                           name="mail_template_contact_subject[{!! $locale->code !!}]"
                           value="{!! old("mail_template_contact_subject.{$locale->code}") ?: (isset($settings['mail_template_contact_subject'][$locale->code]) ? $settings['mail_template_contact_subject'][$locale->code] : '') !!}"/>
                </div>

                <div class="form-group row">
                    <label class="control-label" for="mail_template_contact_{!! $locale->code !!}_message">
                        {!! trans('core::setting.mail_template_message') !!}
                    </label>
                        <textarea class="form-control editor" id="mail_template_contact_{!! $locale->code !!}_message"
                                  name="mail_template_contact_message[{!! $locale->code !!}]">{!! old("mail_template_contact_subject.{$locale->code}") ?: (isset($settings['mail_template_contact_message'][$locale->code]) ? $settings['mail_template_contact_message'][$locale->code] : '') !!}</textarea>
                </div>
            </div>
        @endforeach
    </div>
</div>
