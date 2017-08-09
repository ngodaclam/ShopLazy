<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/11/15
 * Time: 4:49 PM
 */

namespace Modules\Post\Http\Controllers;

use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Modules\Core\Http\Controllers\BackendController;
use Modules\Post\Http\Requests\TagStoreRequest;
use Modules\Post\Http\Requests\TagTrashRequest;
use Modules\Post\Http\Requests\TagUpdateRequest;
use Modules\Post\Repositories\TaxonomyRepository;
use Modules\Post\Transformers\TagDatatablesTransformer;
use Modules\Post\Transformers\TaxonomyTransformer;
use Yajra\Datatables\Datatables;

class TagController extends BackendController
{

    public function __construct(Manager $manager, TaxonomyRepository $taxonomy)
    {
        parent::__construct($manager);
        $this->taxonomy = $taxonomy;
    }


    public function getIndex()
    {
        $taxonomies = $this->taxonomy->paginateCategoriesByType('post_tag');
        $collection = new Collection($taxonomies->getCollection(), new TaxonomyTransformer, 'taxonomies');
        $collection->setPaginator(new IlluminatePaginatorAdapter($taxonomies));
        $data = $this->manager->createData($collection)->toArray();

        return $this->theme->of('post::tag_list', $data)->render();
    }


    public function postStore(TagStoreRequest $request)
    {
        $attributes = [
            'attributes' => [
                'type'   => $request->type ?: 'post_tag',
                'parent' => null,
                'order'  => $request->oreder ?: 1,
                'count'  => 0
            ],
            'translate'  => [ ]
        ];

        foreach ($request->translate as $locale_id => $translate) {
            if ($translate['name']) {
                $attributes['translate'][] = [
                    'name'        => $translate['name'],
                    'description' => $translate['description'],
                    'locale_id'   => $locale_id
                ];
            }
        }

        if ($tag = $this->taxonomy->create($attributes)) {
            event('tag.after.store');

            return $request->redirect ? redirect()->route($request->redirect) : redirect()->route('tag.index');
        }

        return redirect()->back()->withInput();
    }


    public function getEdit($id)
    {
        $taxonomies = $this->taxonomy->paginateCategoriesByType('post_tag');
        $collection = new Collection($taxonomies->getCollection(), new TaxonomyTransformer, 'taxonomies');
        $collection->setPaginator(new IlluminatePaginatorAdapter($taxonomies));
        $data = $this->manager->createData($collection)->toArray();

        $taxonomy          = $this->taxonomy->find($id);
        $taxonomy          = new Item($taxonomy, new TaxonomyTransformer(true), 'tag');
        $taxonomy          = $this->manager->createData($taxonomy)->toArray();
        $data['tag']       = $taxonomy;
        $data['paginator'] = $taxonomies;

        return $this->theme->of('post::tag_list', $data)->render();
    }


    public function postUpdate(TagUpdateRequest $request)
    {
        $attributes = [
            'attributes' => [
                'parent' => null,
                'order'  => $request->oreder ?: 1
            ],
            'translate'  => [ ]
        ];

        foreach ($request->translate as $locale_id => $translate) {
            if ($translate['name']) {
                $attributes['translate'][] = [
                    'name'        => $translate['name'],
                    'description' => $translate['description'],
                    'locale_id'   => $locale_id
                ];
            }
        }

        if ($response = event('tag.before.update', [ $attributes ])) {
            $attributes = $response[0];
        }

        if ($tag = $this->taxonomy->update($request->one, $attributes)) {
            event('tag.after.update');
            flash(trans('post::tag.update_success', [ 'name' => $tag->name ]));

            return $request->redirect ? redirect()->route($request->redirect) : redirect()->route('tag.index');
        }

        flash()->error(trans('core::general.error'));

        return redirect()->back()->withInput();
    }


    public function postTrash(TagTrashRequest $request, $external = false)
    {
        if ($tag = $this->taxonomy->find($request->route('id'))) {
            if ($this->taxonomy->trash($request->route('id'))) {
                flash(trans('post::tag.trash_success', [ 'name' => $tag->name ]));
            } else {
                flash()->error(trans('post::tag.find_not_found', [ 'name' => $tag->name ]));

                return $external ? false : redirect()->back();
            }
        } else {
            flash()->error(trans('core::general.error'));

            return redirect()->back();
        }

        return $request->redirect ? redirect()->route($request->redirect) : redirect()->route('tag.index');
    }


    public function postDatatables()
    {
        return Datatables::of($this->taxonomy->getCategoriesByType('post_tag'))->setTransformer(TagDatatablesTransformer::class)->make(true);
    }
}