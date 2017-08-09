<?php
/**
 * Created by NgocNH.
 * Date: 11/14/15
 * Time: 1:55 AM
 */

namespace Modules\Post\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Post\Entities\Taxonomy;

class TagDatatablesTransformer extends TransformerAbstract
{

    public function transform(Taxonomy $tag)
    {
        $return = [
            'name' => $tag->name,
            'description' => $tag->description,
        ];

        $return['action'] = \Form::open([ 'url' => route('tag.trash', [ 'id' => $tag->id ]) ]);
        $return['action'] .= \Form::button("<i class='fa fa-trash-o'></i>", [ 'type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'title' => trans('post::tag.trash') ]);
        $return['action'] .= "<a href='".route('tag.edit', ['id' => $tag->id])."' class='btn btn-sm btn-default' rel='tooltip' title='".trans('post::tag.edit')."'><i class='fa fa-pencil'></i></a>";
        $return['action'] .= \Form::close();

        return $return;
    }
}