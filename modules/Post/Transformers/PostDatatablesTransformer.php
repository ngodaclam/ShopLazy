<?php
/**
 * Created by NgocNH.
 * Date: 11/13/15
 * Time: 11:09 PM
 */

namespace Modules\Post\Transformers;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\TransformerAbstract;
use Modules\Core\Transformers\UserTransformer;
use Modules\Post\Entities\Post;

class PostDatatablesTransformer extends TransformerAbstract
{

    public function transform(Post $post)
    {
        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer());

        $return = [
            'id'     => $post->id,
            'title'  => $post->title,
            'status' => $post->status,
            'author' => [ ],
        ];

        if ($author = $post->author()) {
            $author           = new Item($author, new UserTransformer, 'user');
            $author           = $manager->createData($author)->toArray();
            $return['author'] = isset( $author['meta']['fullname'] ) ? $author['meta']['fullname'] : ( ( isset( $author['meta']['first_name'] ) ? $author['meta']['first_name'] . '' : '' ) . ( isset( $author['meta']['last_name'] ) ? $author['meta']['last_name'] : '' ) );
        }
        if ($taxonomies = $post->taxonomies()) {
            $taxonomy_collection  = new Collection($taxonomies, new TaxonomyTransformer('taxonomies'), 'taxonomies');
            $taxonomies           = $manager->createData($taxonomy_collection)->toArray();
            $return['taxonomies'] = implode(', ', array_pluck($taxonomies['taxonomies'], 'name'));
        }

        $return['action'] = \Form::open([ 'url' => route('post.trash', [ 'id' => $post->id ]) ]);
        $return['action'] .= \Form::button("<i class='fa fa-trash-o'></i>", [ 'type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'title' => trans('post::post.trash') ]);
        $return['action'] .= "<a href='".route('post.lock', ['id' => $post->id])."' class='btn btn-sm btn-warning' rel='tooltip' title='".trans('post::post.lock')."'><i class='fa fa-lock'></i></a>";
        $return['action'] .= "<a href='".route('post.edit', ['id' => $post->id])."' class='btn btn-sm btn-default' rel='tooltip' title='".trans('post::post.edit')."'><i class='fa fa-pencil'></i></a>";
        $return['action'] .= \Form::close();

        return $return;
    }
}