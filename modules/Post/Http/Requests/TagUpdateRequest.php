<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/13/15
 * Time: 2:46 PM
 */

namespace Modules\Post\Http\Requests;

use Modules\Post\Repositories\TaxonomyRepository;

class TagUpdateRequest extends TaxonomyUpdateRequest
{

    public function authorize(TaxonomyRepository $taxonomy)
    {
        return $taxonomy->find($this->route('one')) && auth()->user()->can([ 'access.all', 'post.tag.update' ]);
    }
}