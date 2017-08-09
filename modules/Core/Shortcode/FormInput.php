<?php
/**
 * Created by NgocNH.
 * Date: 2/17/16
 * Time: 9:13 PM
 */

namespace Modules\Core\Shortcode;

class FormInput
{

    public function __construct()
    {
        \Shortcode::register('form_open', 'Modules\Core\Shortcode\FormInput@formOpen');
        \Shortcode::register('form_close', 'Modules\Core\Shortcode\FormInput@formClose');
        \Shortcode::register('h4', 'Modules\Core\Shortcode\FormInput@h4');
        \Shortcode::register('button', 'Modules\Core\Shortcode\FormInput@button');
        \Shortcode::register('div', 'Modules\Core\Shortcode\FormInput@div');
        \Shortcode::register('span', 'Modules\Core\Shortcode\FormInput@span');
        \Shortcode::register('i', 'Modules\Core\Shortcode\FormInput@i');
        \Shortcode::register('a', 'Modules\Core\Shortcode\FormInput@a');
        \Shortcode::register('li', 'Modules\Core\Shortcode\FormInput@li');
        \Shortcode::register('label', 'Modules\Core\Shortcode\FormInput@label');
        \Shortcode::register('input', 'Modules\Core\Shortcode\FormInput@input');
        \Shortcode::register('textarea', 'Modules\Core\Shortcode\FormInput@textArea');
        \Shortcode::register('select', 'Modules\Core\Shortcode\FormInput@select');
        \Shortcode::register('option', 'Modules\Core\Shortcode\FormInput@option');
        \Shortcode::register('switch2', 'Modules\Core\Shortcode\FormInput@switch2');
        \Shortcode::register('tab', 'Modules\Core\Shortcode\FormInput@tab');
        \Shortcode::register('ckimage', 'Modules\Core\Shortcode\FormInput@ckimage');
    }


    public function h4($attr, $content = '', $name = '')
    {
        $content = \Shortcode::compile($content);

        return "<h4 " . \Html::attributes($attr) . ">$content</h4>";
    }

    public function formOpen($attr)
    {
        return "<form " . \Html::attributes($attr) . ">";
    }

    public function formClose()
    {
        return "</form>";
    }


    public function button($attr, $content = '', $name = '')
    {
        $content = \Shortcode::compile($content);

        return "<button " . \Html::attributes($attr) . ">$content</button>";
    }


    public function div($attr, $content = '', $name = '')
    {
        $content = \Shortcode::compile($content);

        return "<div " . \Html::attributes($attr) . ">$content</div>";
    }


    public function span($attr, $content = '', $name = '')
    {
        $content = \Shortcode::compile($content);

        return "<span " . \Html::attributes($attr) . ">$content</span>";
    }


    public function i($attr, $content = '', $name = '')
    {
        $content = \Shortcode::compile($content);

        return "<i " . \Html::attributes($attr) . ">$content</i>";
    }


    public function a($attr, $content = '', $name = '')
    {
        $content = \Shortcode::compile($content);

        return "<a " . \Html::attributes($attr) . ">$content</a>";
    }


    public function li($attr, $content = '', $name = '')
    {
        $content = \Shortcode::compile($content);

        return "<li " . \Html::attributes($attr) . ">$content</li>";
    }


    public function label($attr, $content = '', $name = '')
    {
        $content = \Shortcode::compile($content);

        return "<label " . \Html::attributes($attr) . ">$content</label>";
    }


    public function input($attr, $content = '', $name = '')
    {
        $content      = \Shortcode::compile($content);

        if (isset($attr['name'])) {
            $attr['name'] = strpos($attr['name'], '.') ? str_replace('.', '[', $attr['name']) . ']' : $attr['name'];
        }

        return "<input " . \Html::attributes($attr) . ">$content</input>";
    }


    public function textArea($attr, $content = '', $name = '')
    {
        $content      = \Shortcode::compile($content);

        if (isset($attr['name'])) {
            $attr['name'] = strpos($attr['name'], '.') ? str_replace('.', '[', $attr['name']) . ']' : $attr['name'];
        }

        return "<textarea " . \Html::attributes($attr) . ">$content</textarea>";
    }

    public function select($attr, $content = '', $name = '')
    {
        $content      = \Shortcode::compile($content);

        if (isset($attr['name'])) {
            $attr['name'] = strpos($attr['name'], '.') ? str_replace('.', '[', $attr['name']) . ']' : $attr['name'];
        }

        return "<select " . \Html::attributes($attr) . ">$content</select>";
    }


    public function option($attr, $content = '', $name = '')
    {
        $content = \Shortcode::compile($content);

        return "<option " . \Html::attributes($attr) . ">$content</option>";
    }


    public function switch2($attr, $content = '', $name = '')
    {
        $content   = \Shortcode::compile($content);
        $inputName = strpos($attr['name'], '.') ? str_replace('.', '[', $attr['name']) . ']' : $attr['name'];
        $id        = array_get($attr, 'id') ?: '';
        $checked   = array_get($attr, 'checked') ?: '';

        $return = '<div class="onoffswitch2">';
        $return .= "<input type='checkbox' name='$inputName' class='onoffswitch-checkbox' id='$id' $checked />";
        $return .= "<label class='onoffswitch-label' for='$id'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label>";
        $return .= '</div>';

        return $return;
    }


    public function tab($attr, $content = '', $name = '')
    {
        $content = \Shortcode::compile($content);
        $class   = array_get($attr, 'class');
        $id      = array_get($attr, 'id');

        return "<div class='$class tab-pane fade in' id='$id'>$content</div>";
    }


    public function ckimage($attr, $content = '', $name = '')
    {
        $content = \Shortcode::compile($content);

        if (isset($attr['name'])) {
            $attr['name'] = strpos($attr['name'], '.') ? str_replace('.', '[', $attr['name']) . ']' : $attr['name'];
        }

        $html = "<div class='fileinput fileinput-new'>";
        $html .= "<input type='hidden' id='" . (isset($attr['id']) ? $attr['id'] : '') ."' name='" . (isset($attr['name']) ? $attr['name'] : 'image') . "' value='" . (isset($attr['value']) ? $attr['value'] : '') . "' />";
        $html .= "<div class='fileinput-new thumbnail' style='min-height: 150px;min-width: 150px;'>";
        $html .= "<img id='" . (isset($attr['id']) ? $attr['id'] . '_src' : '') ."' src='". (isset($attr['value']) ? $attr['value'] : '') . "' class='img-responsive'/>";
        $html .= "</div>";
        $html .= "<div class='fileinput-preview fileinput-exists thumbnail\'></div>";
        $html .= "<div class='col-sm-12'>";
        $html .= "<button type='button' class='btn btn-default' onclick=\"ckfinder($('#" . (isset($attr['id']) ? $attr['id'] : 'image') . "_src'), $('#" . (isset($attr['id']) ? $attr['id'] : 'image') . "'))\">".trans('post::post.add_image')."</button>";
        $html .= "</div>";
        $html .= "</div>";

        return $html;
    }
}