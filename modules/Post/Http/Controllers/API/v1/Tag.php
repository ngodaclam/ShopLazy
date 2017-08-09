<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/3/15
 * Time: 5:53 PM
 */

namespace Modules\Post\Http\Controllers\API\v1;

use Modules\Post\Http\Controllers\API\v1\Requests\TagIndexRequest;
use Modules\Post\Http\Controllers\API\v1\Requests\TagShowRequest;
use Modules\Post\Repositories\TaxonomyDetailRepository;
use Modules\Post\Repositories\TaxonomyRepository;
use Modules\Post\Transformers\TaxonomyTransformer;
use Modules\Service\Http\Controllers\ApiController;

/**
 * User resource representation.
 *
 * @Resource("Tag", uri="/tag")
 */
class Tag extends ApiController
{

    public function __construct(TaxonomyRepository $taxonomy, TaxonomyDetailRepository $taxonomy_detail) {
        parent::__construct();
        $this->taxonomy = $taxonomy;
        $this->taxonomy_detail = $taxonomy_detail;
    }


    /**
     * Show all tags
     *
     * Get a JSON representation of all the tag.
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
     *                  "id": 2,
     *                  "name": "Post",
     *                  "slug": "post",
     *                  "description": null,
     *                  "parent": null,
     *                  "order": 1,
     *                  "type": "post_tag",
     *                  "count": 1,
     *                  "translate": {}
     *              },
     *              {
     *                  "id": 3,
     *                  "name": "news",
     *                  "slug": "news",
     *                  "description": null,
     *                  "parent": null,
     *                  "order": 1,
     *                  "type": "post_tag",
     *                  "count": 1,
     *                  "translate": {}
     *              }
     *          },
     *          "meta": {
     *              "pagination": {
     *                  "total": 2,
     *                  "count": 2,
     *                  "per_page": 10,
     *                  "current_page": 1,
     *                  "total_pages": 1,
     *                  "links": {}
     *              }
     *          }
     *      })
     * })
     */
    public function index(TagIndexRequest $request)
    {
        $tags = $this->taxonomy->paginateCategoriesByType('post_tag');

        return $this->response()->paginator($tags, new TaxonomyTransformer)->setStatusCode(200);
    }


    /**
     * Get Tag.
     *
     * Get a tag by tag id or slug
     *
     * @Get("/{id|slug}")
     * @Versions({"v1"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="Tag ID"),
     *      @Parameter("slug", type="string", required=true, description="Tag Slug")
     * })
     * @Transaction({
     *      @Response(200, body={
     *          "data": {
     *              "id": 2,
     *              "name": "Post",
     *              "slug": "post",
     *              "description": null,
     *              "parent": null,
     *              "order": 1,
     *              "type": "post_tag",
     *              "count": 1,
     *              "translate": {}
     *          }
     *      }),
     *      @Response(404, body={
     *          "message": "<strong>Error!</strong> Tag <strong><i>{category}</i></strong> not found.",
     *          "status_code": 404,
     *      })
     * })
     *
     */
    public function show(TagShowRequest $request)
    {
        if (is_string($request->tag) && $tag = $this->taxonomy_detail->findBySlug($request->tag)) {
            $tag = $tag->taxonomy();
        } else {
            if (is_numeric($request->tag)) {
                $tag = $this->taxonomy->findByType($request->tag, 'post_tag');
            }
        }

        if (!$tag) {
            return $this->response()->errorNotFound(trans('post::taxonomy.find_not_found', [ 'id' => $request->tag ]));
        }

        return $this->response()->item($tag, new TaxonomyTransformer)->statusCode(200);
    }
}