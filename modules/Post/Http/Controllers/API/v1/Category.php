<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/3/15
 * Time: 5:53 PM
 */

namespace Modules\Post\Http\Controllers\API\v1;

use Modules\Post\Http\Controllers\API\v1\Requests\CategoryIndexRequest;
use Modules\Post\Http\Controllers\API\v1\Requests\CategoryShowRequest;
use Modules\Post\Repositories\TaxonomyDetailRepository;
use Modules\Post\Repositories\TaxonomyRepository;
use Modules\Post\Transformers\TaxonomyTransformer;
use Modules\Service\Http\Controllers\ApiController;

/**
 * User resource representation.
 *
 * @Resource("Category", uri="/category")
 */
class Category extends ApiController
{

    public function __construct(TaxonomyRepository $taxonomy, TaxonomyDetailRepository $taxonomy_detail)
    {
        parent::__construct();
        $this->taxonomy        = $taxonomy;
        $this->taxonomy_detail = $taxonomy_detail;
    }


    /**
     * Show all categories
     *
     * Get a JSON representation of all the category.
     *
     * @Get("/{?page,limit}")
     * @Versions({"v1"})
     * @Parameters({
     *      @Parameter("page", type="integer", description="The page of results to view.", default=1),
     *      @Parameter("limit", type="integer", description="The amount of results per page.", default=10)
     * })
     * @Transaction({
     *      @Response(200, body={
     *          "data": {
     *              {
     *                  "id": 1,
     *                  "name": "Default",
     *                  "slug": "default",
     *                  "description": "Default Post Taxonomy",
     *                  "parent": null,
     *                  "order": 99,
     *                  "type": "post_category",
     *                  "count": 2,
     *                  "translate": {}
     *              }
     *          },
     *          "meta": {
     *              "pagination": {
     *                  "total": 1,
     *                  "count": 1,
     *                  "per_page": 10,
     *                  "current_page": 1,
     *                  "total_pages": 1,
     *                  "links": {}
     *              }
     *          }
     *      })
     * })
     */
    public function index(CategoryIndexRequest $request)
    {
        $categories = $this->taxonomy->paginateCategoriesByType($request->type ?: 'post_category');

        return $this->response()->paginator($categories, new TaxonomyTransformer)->setStatusCode(200);
    }


    /**
     * Get Category.
     *
     * Get a category by category id or slug
     *
     * @Get("/{id|slug}")
     * @Versions({"v1"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="Category ID"),
     *      @Parameter("slug", type="string", required=true, description="Category Slug")
     * })
     * @Transaction({
     *      @Response(200, body={
     *          "data": {
     *              "id": 1,
     *              "name": "Default",
     *              "slug": "default",
     *              "description": "Default Post Taxonomy",
     *              "parent": null,
     *              "order": 99,
     *              "type": "post_category",
     *              "count": 2,
     *              "translate": {}
     *          }
     *      }),
     *      @Response(404, body={
     *          "message": "<strong>Error!</strong> Category <strong><i>{category}</i></strong> not found.",
     *          "status_code": 404,
     *      })
     * })
     *
     */
    public function show(CategoryShowRequest $request)
    {
        if (is_string($request->category) && $category = $this->taxonomy_detail->findBySlug($request->category)) {
            $category = $category->taxonomy();
        } else {
            if (is_numeric($request->category)) {
                $category = $this->taxonomy->findByType($request->category);
            }
        }

        if ( ! $category) {
            return $this->response()->errorNotFound(trans('post::taxonomy.find_not_found', [ 'id' => $request->category ]));
        }

        return $this->response()->item($category, new TaxonomyTransformer)->statusCode(200);
    }
}