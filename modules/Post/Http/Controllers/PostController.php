<?php namespace Modules\Post\Http\Controllers;

use Elasticquent\ElasticquentResultCollection;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Modules\Core\Http\Controllers\BackendController;
use Modules\Post\Entities\Post;
use Modules\Post\Http\Requests\PostStoreRequest;
use Modules\Post\Http\Requests\PostUpdateRequest;
use Modules\Post\Repositories\PostRepository;
use Modules\Post\Repositories\TaxonomyRepository;
use Modules\Post\Transformers\PostDatatablesTransformer;
use Modules\Post\Transformers\PostTransformer;
use Modules\Post\Transformers\TaxonomyTransformer;
use Yajra\Datatables\Datatables;

class PostController extends BackendController
{

    public function __construct(Manager $manager, PostRepository $post, TaxonomyRepository $taxonomy)
    {
        parent::__construct($manager);
        $this->post     = $post;
        $this->taxonomy = $taxonomy;
    }


    public function getIndex()
    {
        $posts = $this->post->paginate();
        $posts = new Collection($posts, new PostTransformer, 'posts');
        $data  = $this->manager->createData($posts)->toArray();

        return $this->theme->of('post::post_list', $data)->render();
    }


    public function getCreate()
    {
        $taxonomies = $this->taxonomy->getCategoriesByType();
        $taxonomies = new Collection($taxonomies, new TaxonomyTransformer, 'taxonomies');
        $data       = $this->manager->createData($taxonomies)->toArray();

        return $this->theme->of('post::post_view', $data)->render();
    }


    public function postStore(PostStoreRequest $request)
    {
        $attributes = [
            'attributes' => [
                'author'         => auth()->user()->id,
                'parent'         => $request->parent,
                'order'          => $request->order ?: 1,
                'type'           => 'post',
                'status'         => $request->status,
                'comment_status' => $request->comment_status
            ],
            'image'      => urldecode($request->image),
            'tags'       => $request->tags ? explode(',', $request->tags) : false,
            'translate'  => [ ],
            'taxonomies' => $request->taxonomies
        ];

        foreach ($request->translate as $locale_id => $translate) {
            if ($translate['title'] != '' && $translate['content'] != '') {
                $attributes['translate'][] = [
                    'title'     => $translate['title'],
                    'excerpt'   => $translate['excerpt'],
                    'content'   => $translate['content'],
                    'locale_id' => $locale_id
                ];
            }
        }

        if ($response = event('post.before.store', [ $attributes ])) {
            $attributes = $response;
        }

        if ($post = $this->post->create($attributes)) {
            event('post.after.store');
            flash(trans('post::post.update_success', [ 'post' => $post->title ]));

            return $request->redirect ? redirect()->route($request->redirect) : redirect()->route('post.index');
        }

        flash(trans('core::general.error'));

        return redirect()->back()->withInput();
    }


    public function getEdit($id)
    {
        if ($post = $this->post->find($id)) {
            $post       = new Item($post, new PostTransformer(true), 'post');
            $taxonomies = $this->taxonomy->getCategoriesByType();
            $taxonomies = new Collection($taxonomies, new TaxonomyTransformer, 'taxonomies');
            $taxonomies = $this->manager->createData($taxonomies)->toArray();

            $data = [
                'post'       => $this->manager->createData($post)->toArray(),
                'taxonomies' => $taxonomies['taxonomies']
            ];

            return $this->theme->of('post::post_view', $data)->render();
        }

        flash(trans('post::post.find_not_found', [ 'id' => $id ]));

        return redirect()->route('post.index');
    }

    public function postUpdate(PostUpdateRequest $request)
    {
        $attributes = [
            'attributes' => [
                'parent'         => $request->parent,
                'order'          => $request->order,
                'status'         => $request->status,
                'comment_status' => $request->comment_status
            ],
            'image'      => urldecode($request->image),
            'tags'       => $request->tags ? explode(",", $request->tags) : false,
            'translate'  => [ ],
            'taxonomies' => $request->taxonomies
        ];

        foreach ($request->translate as $locale_id => $translate) {
            if ($translate['title'] != '' && $translate['content'] != '') {
                $attributes['translate'][] = [
                    'title'     => $translate['title'],
                    'excerpt'   => $translate['excerpt'],
                    'content'   => $translate['content'],
                    'locale_id' => $locale_id
                ];
            }
        }

        if ($response = event('post.before.update', [ $attributes ])) {
            $attributes = $response;
        }

        if ($post = $this->post->update($request->one, $attributes)) {
            event('post.after.update');
            flash(trans('post::post.update_success', [ 'post' => $post->title ]));

            return $request->redirect ? redirect()->route($request->redirect) : redirect()->route('post.index');
        } else {
            flash(trans('core::general.error'));

            return redirect()->back()->withInput();
        }
    }


    public function postLock($id)
    {
        return true;
    }


    public function postTrash($id, $external = false)
    {
        if ($post = $this->post->find($id)) {
            if ($this->post->trash($id)) {
                flash(trans('post::post.trash_success', [ 'post' => $post->title ]));
            } else {
                flash(trans('core::general.error'));

                return $external ? false : redirect()->back();
            }
        } else {
            flash(trans('post::post.find_not_found', [ 'id' => $id ]));

            return $external ? false : redirect()->back();
        }

        return $external ? $post : redirect()->route('post.index');
    }


    public function postRestore($id, $external = false)
    {
        if ($post = $this->post->find($id)) {
            if ($this->post->restore($id)) {
                flash(trans('post::post.restore_success', [ 'post' => $post->title ]));
            } else {
                flash(trans('core::general.error'));

                return $external ? false : redirect()->back();
            }
        } else {
            flash(trans('post::post.find_not_found', [ 'id' => $id ]));

            return $external ? false : redirect()->back();
        }

        return $external ? $post : redirect()->route('post.index');
    }


    public function postDestroy($id, $external = false)
    {
        if ($post = $this->post->find($id)) {
            if ($this->post->destroy($id)) {
                flash(trans('post::post.destroy_success', [ 'post' => $post->title ]));
            } else {
                flash(trans('core::general.error'));

                return $external ? false : redirect()->back();
            }
        } else {
            flash(trans('post::post.find_not_found', [ 'id' => $id ]));

            return $external ? false : redirect()->back();
        }

        return $external ? $post : redirect()->route('post.index');
    }


    public function postDatatables()
    {
        return Datatables::of($this->post->getPostsByType())->setTransformer(PostDatatablesTransformer::class)->make(true);
    }
}