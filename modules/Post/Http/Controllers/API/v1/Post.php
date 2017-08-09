<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/3/15
 * Time: 3:17 PM
 */

namespace Modules\Post\Http\Controllers\API\v1;

use Modules\Post\Http\Controllers\API\v1\Requests\PostIndexRequest;
use Modules\Post\Http\Controllers\API\v1\Requests\PostShowRequest;
use Modules\Post\Repositories\PostDetailRepository;
use Modules\Post\Repositories\PostRepository;
use Modules\Post\Transformers\PostTransformer;
use Modules\Service\Http\Controllers\ApiController;

/**
 * User resource representation.
 *
 * @Resource("Post", uri="/post")
 */
class Post extends ApiController
{

    public function __construct(PostRepository $post, PostDetailRepository $post_detail)
    {
        parent::__construct();
        $this->post        = $post;
        $this->post_detail = $post_detail;
    }


    /**
     * Show all pots
     *
     * Get a JSON representation of all the post.
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
     *                  "title": "Post title",
     *                  "excerpt": "Post excerpt",
     *                  "slug": "post-title",
     *                  "content": "Post content",
     *                  "image": {
     *                      "name": "Screen Shot 2015-08-24 at 10_28_52 AM.png",
     *                      "url": "http://laravel5.app/storage/files/images/Screen Shot 2015-08-24 at 10_28_52 AM.png",
     *                      "size": 170017,
     *                      "title": null,
     *                      "description": null
     *                  },
     *                  "order": 1,
     *                  "type": "post",
     *                  "status": "publish",
     *                  "comment_status": "close",
     *                  "comment_count": 0,
     *                  "author": {
     *                      "id": 1,
     *                      "username": "administrator",
     *                      "email": "me@ngocnh.info",
     *                      "roles": {
     *                          "1": {
     *                              "id": 1,
     *                              "name": "super-administrator",
     *                              "display_name": "Super Administrator",
     *                              "description": "Super Administrator"
     *                          }
     *                      },
     *                      "activation_key": null,
     *                      "last_visited": "2015-09-03 15:40:29",
     *                      "type": "default",
     *                      "status": 1,
     *                      "created_at": {
     *                          "date": "2015-09-01 19:50:01.000000",
     *                          "timezone_type": 3,
     *                          "timezone": "Asia/Ho_Chi_Minh"
     *                      },
     *                      "meta": {
     *                          "fullname": "Super Administrator"
     *                      }
     *                  },
     *                  "taxonomies": {
     *                      {
     *                          "id": 1,
     *                          "name": "Default",
     *                          "slug": "default",
     *                          "description": "Default Post Taxonomy",
     *                          "parent": null,
     *                          "type": "post_category",
     *                          "order": 99,
     *                          "count": 2
     *                      }
     *                  },
     *                  "tags": {
     *                      {
     *                          "id": 2,
     *                          "name": "Post",
     *                          "slug": "post",
     *                          "type": "post_tag",
     *                          "count": 1
     *                      },
     *                      {
     *                          "id": 3,
     *                          "name": "news",
     *                          "slug": "news",
     *                          "type": "post_tag",
     *                          "count": 1
     *                      },
     *                      {
     *                          "id": 4,
     *                          "name": "tag",
     *                          "slug": "tag",
     *                          "type": "post_tag",
     *                          "count": 1
     *                      }
     *                  },
     *                  "translate": {}
     *              },
     *              {
     *                  "id": 2,
     *                  "title": "Draft title",
     *                  "excerpt": "Draft excerpt",
     *                  "slug": "draft-title",
     *                  "content": "Draft content",
     *                  "image": {
     *                      "name": "Screen Shot 2015-08-21 at 3_14_57 PM.png",
     *                      "url": "http://laravel5.app/storage/files/images/Screen Shot 2015-08-21 at 3_14_57 PM.png",
     *                      "size": 16747,
     *                      "title": null,
     *                      "description": null
     *                  },
     *                  "order": 2,
     *                  "type": "post",
     *                  "status": "draft",
     *                  "comment_status": "close",
     *                  "comment_count": 0,
     *                  "author": {
     *                      "id": 1,
     *                      "username": "administrator",
     *                      "email": "me@ngocnh.info",
     *                      "roles": {
     *                          "1": {
     *                              "id": 1,
     *                              "name": "super-administrator",
     *                              "display_name": "Super Administrator",
     *                              "description": "Super Administrator"
     *                          }
     *                      },
     *                      "activation_key": null,
     *                      "last_visited": "2015-09-03 15:40:29",
     *                      "type": "default",
     *                      "status": 1,
     *                      "created_at": {
     *                          "date": "2015-09-01 19:50:01.000000",
     *                          "timezone_type": 3,
     *                          "timezone": "Asia/Ho_Chi_Minh"
     *                      },
     *                      "meta": {
     *                          "fullname": "Super Administrator"
     *                      }
     *                  },
     *                  "taxonomies": {
     *                      {
     *                          "id": 1,
     *                          "name": "Default",
     *                          "slug": "default",
     *                          "description": "Default Post Taxonomy",
     *                          "parent": null,
     *                          "type": "post_category",
     *                          "order": 99,
     *                          "count": 2
     *                      }
     *                  },
     *                  "tags": {
     *                      {
     *                          "id": 5,
     *                          "name": "draft",
     *                          "slug": "draft",
     *                          "type": "post_tag",
     *                          "count": 1
     *                      },
     *                      {
     *                          "id": 6,
     *                          "name": "post",
     *                          "slug": "post-1",
     *                          "type": "post_tag",
     *                          "count": 1
     *                      }
     *                  },
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
    public function index(PostIndexRequest $request)
    {
        $posts = $this->post->paginate();

        return $this->response()->paginator($posts, new PostTransformer)->setStatusCode(200);
    }


    /**
     * Get post.
     *
     * Get a post by post id or slug
     *
     * @Get("/{id|slug}")
     * @Versions({"v1"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="Post ID"),
     *      @Parameter("slug", type="string", required=true, description="Post Slug")
     * })
     * @Transaction({
     *      @Response(200, body={
     *          "data": {
     *              "id": 2,
     *              "title": "Draft title",
     *              "excerpt": "Draft excerpt",
     *              "slug": "draft-title",
     *              "content": "Draft content",
     *              "image": {
     *                  "name": "Screen Shot 2015-08-21 at 3_14_57 PM.png",
     *                  "url": "http://laravel5.app/storage/files/images/Screen Shot 2015-08-21 at 3_14_57 PM.png",
     *                  "size": 16747,
     *                  "title": null,
     *                  "description": null
     *              },
     *              "order": 2,
     *              "type": "post",
     *              "status": "draft",
     *              "comment_status": "close",
     *              "comment_count": 0,
     *              "author": {
     *                  "id": 1,
     *                  "username": "administrator",
     *                  "email": "me@ngocnh.info",
     *                  "roles": {
     *                      "1": {
     *                          "id": 1,
     *                          "name": "super-administrator",
     *                          "display_name": "Super Administrator",
     *                          "description": "Super Administrator"
     *                      }
     *                  },
     *                  "activation_key": null,
     *                  "last_visited": "2015-09-03 15:40:29",
     *                  "type": "default",
     *                  "status": 1,
     *                  "created_at": {
     *                      "date": "2015-09-01 19:50:01.000000",
     *                      "timezone_type": 3,
     *                      "timezone": "Asia/Ho_Chi_Minh"
     *                  },
     *                  "meta": {
     *                      "fullname": "Super Administrator"
     *                  }
     *              },
     *              "taxonomies": {
     *                  {
     *                      "id": 1,
     *                      "name": "Default",
     *                      "slug": "default",
     *                      "description": "Default Post Taxonomy",
     *                      "parent": null,
     *                      "type": "post_category",
     *                      "order": 99,
     *                      "count": 2
     *                  }
     *              },
     *              "tags": {
     *                  {
     *                      "id": 5,
     *                      "name": "draft",
     *                      "slug": "draft",
     *                      "type": "post_tag",
     *                      "count": 1
     *                  },
     *                  {
     *                      "id": 6,
     *                      "name": "post",
     *                      "slug": "post-1",
     *                      "type": "post_tag",
     *                      "count": 1
     *                  }
     *              },
     *              "translate": {}
     *          }
     *      }),
     *      @Response(404, body={
     *          "message": "<strong>Error!</strong> Post <strong><i>{post}</i></strong> not found.",
     *          "status_code": 404,
     *      })
     * })
     *
     */
    public function show(PostShowRequest $request)
    {
        if (is_string($request->post) && $post = $this->post_detail->findBySlug($request->post)) {
            $post = $post->post();
        } else {
            if (is_numeric($request->post)) {
                $post = $this->post->find($request->post);
            }
        }

        if (!$post) {
            return $this->response()->errorNotFound(trans('post::post.find_not_found', [ 'id' => $request->post ]));
        }

        return $this->response()->item($post, new PostTransformer)->statusCode(200);
    }
}