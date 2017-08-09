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
use Modules\Post\Http\Requests\TaxonomyStoreRequest;
use Modules\Post\Http\Requests\TaxonomyTrashRequest;
use Modules\Post\Http\Requests\TaxonomyUpdateRequest;
use Modules\Post\Repositories\TaxonomyRepository;
use Modules\Post\Transformers\TaxonomyDatatablesTransformer;
use Modules\Post\Transformers\TaxonomyTransformer;
use Yajra\Datatables\Datatables;

class CategoryController extends BackendController
{

    public function __construct(Manager $manager, TaxonomyRepository $taxonomy)
    {
        parent::__construct($manager);
        $this->taxonomy = $taxonomy;
    }


    public function getIndex()
    {
        $taxonomies = $this->taxonomy->paginateCategoriesByType('post_category');
        $collection = new Collection($taxonomies->getCollection(), new TaxonomyTransformer, 'taxonomies');
        $collection->setPaginator(new IlluminatePaginatorAdapter($taxonomies));
        $data = $this->manager->createData($collection)->toArray();

        return $this->theme->of('post::category_list', $data)->render();
    }


    public function postStore(TaxonomyStoreRequest $request)
    {
        $attributes = [
            'attributes' => [
                'type'   => $request->type ?: 'post_category',
                'parent' => $request->parent ?: null,
                'order'  => $request->order ?: 1,
                'count'  => 0
            ],
            'meta'       => $request->meta ?: false,
            'featured'   => $request->image ?: false,
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

        if ($category = $this->taxonomy->create($attributes)) {
            event('category.after.store');
            flash(trans('post::category.create_success', [ 'name' => $category->name ?: $category->name ]));

            return $request->redirect ? redirect()->route($request->redirect) : redirect()->route('category.index');
        }

        flash()->error(trans('core::general.error'));

        return redirect()->back()->withInput();

    }


    public function getEdit($id)
    {
        $taxonomies = $this->taxonomy->paginateCategoriesByType('post_category');
        $collection = new Collection($taxonomies->getCollection(), new TaxonomyTransformer, 'taxonomies');
        $collection->setPaginator(new IlluminatePaginatorAdapter($taxonomies));
        $data = $this->manager->createData($collection)->toArray();

        $taxonomy          = $this->taxonomy->find($id);
        $taxonomy          = new Item($taxonomy, new TaxonomyTransformer(true), 'category');
        $taxonomy          = $this->manager->createData($taxonomy)->toArray();
        $data['category']  = $taxonomy;
        $data['paginator'] = $taxonomies;

        return $this->theme->of('post::category_list', $data)->render();
    }


    public function postUpdate(TaxonomyUpdateRequest $request)
    {
        $attributes = [
            'attributes' => [
                'parent' => $request->parent ?: null,
                'order'  => $request->order ?: 1
            ],
            'meta'       => $request->meta ?: false,
            'featured'   => $request->image ?: false,
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

        if ($response = event('category.before.update', [ $attributes ])) {
            $attributes = $response[0];
        }

        if ($category = $this->taxonomy->update($request->one, $attributes)) {
            event('category.after.update');

            flash(trans('post::category.update_success', [ 'name' => $category->name ?: $category->name ]));

            return $request->redirect ? redirect()->route($request->redirect) : redirect()->route('category.index');
        }

        flash()->error(trans('core::general.error'));

        return redirect()->back()->withInput();
    }


    public function postTrash(TaxonomyTrashRequest $request)
    {
        if ($category = $this->taxonomy->find($request->one)) {
            if ($this->taxonomy->trash($request->one)) {
                flash(trans('post::category.trash_success', [ 'name' => $category->name ]));
            } else {
                flash()->error(trans('post::category.find_not_found', [ 'name' => $category->name ]));

                return redirect()->back();
            }
        } else {
            flash()->error(trans('core::general.error'));

            return redirect()->back()->withInput();
        }

        return $request->redirect ? redirect()->route($request->redirect) : redirect()->route('category.index');
    }


    public function postDatatables()
    {
        return Datatables::of($this->taxonomy->getCategoriesByType('post_category'))->setTransformer(TaxonomyDatatablesTransformer::class)->make(true);
    }


    public function getSelect2()
    {
        $taxonomy   = $this->taxonomy->paginateCategoriesByType('post_category', 20);
        $collection = new Collection($taxonomy->getCollection(), new TaxonomyTransformer, 'items');
        $collection->setPaginator(new IlluminatePaginatorAdapter($taxonomy));
        $data = $this->manager->createData($collection)->toArray();

        return $data;
    }
}