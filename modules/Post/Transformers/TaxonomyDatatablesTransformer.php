<?php
/**
 * Created by NgocNH.
 * Date: 11/14/15
 * Time: 1:54 AM
 */

namespace Modules\Post\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Post\Entities\Taxonomy;

class TaxonomyDatatablesTransformer extends TransformerAbstract
{

    public function transform(Taxonomy $taxonomy)
    {
        $return = [
            'name' => $taxonomy->name,
            'description' => $taxonomy->description,
            'action' => ''
        ];

        $return['action'] = \Form::open([ 'url' => route('category.trash', [ 'id' => $taxonomy->id ]) ]);
        $return['action'] .= \Form::button("<i class='fa fa-trash-o'></i>", [ 'type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'title' => trans('post::taxonomy.trash') ]);
        $return['action'] .= "<a href='".route('category.edit', ['id' => $taxonomy->id])."' class='btn btn-sm btn-default' rel='tooltip' title='".trans('post::taxonomy.edit')."'><i class='fa fa-pencil'></i></a>";
        $return['action'] .= \Form::close();

        return $return;
    }
}