<?php
/**
 * Created by Ngoc Nguyen.
 * Date: 9/23/15
 * Time: 11:40 AM
 */

namespace Modules\Post\Tests;

use Modules\Post\Entities\Post;
use Modules\Post\Entities\PostDetail;

class PostTest extends \TestCase
{

    public function testPostCreate()
    {
        $this->post(route('post.store'), [
            'translate'      => [
                1 => [
                    'title'   => "Post Tile Test - Lang 1",
                    'excerpt' => "Post Excerpt Test - Lang 1",
                    'content' => "Post Content Test - Lang 1",
                ],
                2 => [
                    'title'   => "Post Tile Test - Lang 2",
                    'excerpt' => "Post Excerpt Test - Lang 2",
                    'content' => "Post Content Test - Lang 2",
                ]
            ],
            'status'         => 'publish',
            'taxonomies'     => [ 1 ],
            'tags'           => 'tag1,tag2,tag3',
            'comment_status' => 'open',
            'order'          => 1
        ]);

        $this->seeInDatabase('post_detail', [ 'title' => "Post Tile Test - Lang 1" ]);
    }


    public function testPostEdit()
    {
        $post_detail = PostDetail::where('title', '=', "Post Tile Test - Lang 1")->first();
        $post        = Post::find($post_detail->post_id);

        $this->put(route('post.update', [ 'post' => $post->id ]), [
            'id'             => $post->id,
            'translate'      => [
                1 => [
                    'title'   => "Post Tile Test - Lang 1 | Updated",
                    'excerpt' => "Post Excerpt Test - Lang 1 | Updated",
                    'content' => "Post Content Test - Lang 1 | Updated",
                ],
                2 => [
                    'title'   => "Post Tile Test - Lang 2 | Updated",
                    'excerpt' => "Post Excerpt Test - Lang 2 | Updated",
                    'content' => "Post Content Test - Lang 2 | Updated",
                ]
            ],
            'status'         => 'draft',
            'taxonomies'     => [ 1 ],
            'tags'           => 'tag1,tag2',
            'comment_status' => 'close',
            'order'          => 0
        ]);

        $this->seeInDatabase('post_detail', [ 'title' => "Post Tile Test - Lang 1 | Updated" ]);
    }


    public function testPostTrash()
    {
        $post_detail = PostDetail::where('title', '=', "Post Tile Test - Lang 1 | Updated")->first();
        $post        = Post::find($post_detail->post_id);

        $this->post(route('post.trash', [ 'post' => $post->id ]));

        $this->notSeeInDatabase('posts', [ 'id' => $post->id, 'deleted_at' => null ]);
    }


    public function testPostRestore()
    {
        $post        = Post::select('posts.*')
            ->join('post_detail', 'posts.id', '=', 'post_detail.post_id')
            ->where('title', '=', "Post Tile Test - Lang 1 | Updated")->first();

        $this->post(route('post.restore', [ 'post' => $post->id ]));

        $this->seeInDatabase('posts', [ 'id' => $post->id, 'deleted_at' => null ]);
    }


    public function testPostDestroy()
    {
        $post_detail = PostDetail::where('title', '=', "Post Tile Test - Lang 1 | Updated")->first();
        $post        = Post::find($post_detail->post_id);

        $this->delete(route('post.destroy', [ 'post' => $post->id ]));

        $this->notSeeInDatabase('posts', [ 'id' => $post->id ]);
    }
}