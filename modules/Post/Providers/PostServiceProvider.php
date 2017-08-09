<?php namespace Modules\Post\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Post\Events\EventHandler;
use Modules\Post\Models\EloquentComment;
use Modules\Post\Models\EloquentCommentMeta;
use Modules\Post\Models\EloquentPost;
use Modules\Post\Models\EloquentPostDetail;
use Modules\Post\Models\EloquentPostMeta;
use Modules\Post\Models\EloquentPostTaxonomy;
use Modules\Post\Models\EloquentTaxonomy;
use Modules\Post\Models\EloquentTaxonomyDetail;
use Modules\Post\Models\EloquentTaxonomyFile;
use Modules\Post\Repositories\CommentMetaRepository;
use Modules\Post\Repositories\CommentRepository;
use Modules\Post\Repositories\PostDetailRepository;
use Modules\Post\Repositories\PostMetaRepository;
use Modules\Post\Repositories\PostRepository;
use Modules\Post\Repositories\PostTaxonomyRepository;
use Modules\Post\Repositories\TaxonomyDetailRepository;
use Modules\Post\Repositories\TaxonomyFileRepository;
use Modules\Post\Repositories\TaxonomyRepository;

class PostServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->events->subscribe(new EventHandler);

        $this->app->bind(PostRepository::class, function () {
            return new EloquentPost();
        });
        $this->app->bind(PostDetailRepository::class, function () {
            return new EloquentPostDetail;
        });
        $this->app->bind(PostMetaRepository::class, function () {
            return new EloquentPostMeta;
        });
        $this->app->bind(TaxonomyRepository::class, function () {
            return new EloquentTaxonomy;
        });
        $this->app->bind(TaxonomyDetailRepository::class, function () {
            return new EloquentTaxonomyDetail;
        });
        $this->app->bind(TaxonomyFileRepository::class, function () {
            return new EloquentTaxonomyFile;
        });
        $this->app->bind(CommentRepository::class, function () {
            return new EloquentComment;
        });
        $this->app->bind(CommentMetaRepository::class, function () {
            return new EloquentCommentMeta;
        });
        $this->app->bind(PostTaxonomyRepository::class, function () {
            return new EloquentPostTaxonomy;
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ ];
    }

}
