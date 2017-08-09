<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/27/15
 * Time: 9:44 PM
 */

namespace Modules\Core\Http\Controllers\API\v1;

use Dingo\Blueprint\Annotation\Method\Post;
use Dingo\Blueprint\Annotation\Parameter;
use Dingo\Blueprint\Annotation\Parameters;
use Dingo\Blueprint\Annotation\Request;
use Dingo\Blueprint\Annotation\Response;
use Dingo\Blueprint\Annotation\Transaction;
use Modules\Core\Entities\File;
use Modules\Core\Http\Controllers\API\v1\Requests\UserIndexRequest;
use Modules\Core\Http\Controllers\API\v1\Requests\UserLoginRequest;
use Modules\Core\Http\Controllers\API\v1\Requests\UserShowRequest;
use Modules\Core\Http\Controllers\API\v1\Requests\UserStoreRequest;
use Modules\Core\Http\Controllers\API\v1\Requests\UserUpdateRequest;
use Modules\Core\Repositories\RoleRepository;
use Modules\Core\Repositories\UserRepository;
use Modules\Core\Transformers\UserTransformer;
use Modules\Service\Http\Controllers\ApiController;

/**
 * User resource representation.
 *
 * @Resource("User", uri="/user")
 */
class User extends ApiController
{

    public function __construct(UserRepository $user, RoleRepository $role)
    {
        parent::__construct();
        $this->user = $user;
        $this->role = $role;
    }


    /**
     * Login.
     *
     * Login with account username or email and account password
     *
     * @Post("/user/login")
     * @Versions({"v1"})
     * @Parameters({
     *      @Parameter("username", type="string", required=true, description="Account username or email"),
     *      @Parameter("password", type="string", required=true, description="Account password"),
     * })
     * @Transaction({
     *      @Request({
     *          "username": "user01@local.app",
     *          "password": "123456"
     *      }),
     *      @Response(200, body={
     *          "data": {
     *              "id": 5,
     *              "username": "user01",
     *              "email": "user01@local.app",
     *              "roles": {
     *                  "3": {
     *                      "id": 3,
     *                      "name": "test",
     *                      "display_name": "Test",
     *                      "description": "test"
     *                  }
     *              },
     *              "activation_key": "EKOmipkYuwE6o2tJsIxYJ3aP",
     *              "last_visited": null,
     *              "type": "default",
     *              "status": 1,
     *              "created_at": {
     *                  "date": "2015-09-02 00:49:02.000000",
     *                  "timezone_type": 3,
     *                  "timezone": "Asia/Ho_Chi_Minh"
     *              },
     *              "meta": {}
     *          }
     *      }),
     *      @Response(404, body={
     *          "message": "<strong>Error!</strong> User <strong><i>user01@local.app</i></strong> not found.",
     *          "status_code": 422,
     *      })
     * })
     *
     */
    public function login(UserLoginRequest $request)
    {
        $username = $request->username;
        $password = $request->password;

        if (auth()->attempt([
                'email'    => $username,
                'password' => $password,
                'status'   => 1,
                'type'     => $request->type
            ]) || auth()->attempt([
                'username' => $username,
                'password' => $password,
                'status'   => 1,
                'type'     => $request->type
            ])
        ) {
            $user               = auth()->user();
            $user->last_visited = new \DateTime();
            $user->save();

            return $this->response()->item($user, new UserTransformer)->statusCode(200);
        }

        return $this->response()->error(trans('core::user.find_not_found', [ 'id' => $username ]), 422);
    }


    /**
     * Show all users
     *
     * Get a JSON representation of all the registered users.
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
     *                  "username": "user01",
     *                  "email": "user01@local.app",
     *                  "roles": {
     *                      "1": {
     *                          "id": 1,
     *                          "name": "member",
     *                          "display_name": "Member",
     *                          "description": "Member"
     *                      }
     *                  },
     *                  "activation_key": null,
     *                  "last_visited": "2015-09-01 14:29:36",
     *                  "type": "default",
     *                  "status": 1,
     *                  "created_at": {
     *                      "date": "2015-08-29 01:58:30.000000",
     *                      "timezone_type": 3,
     *                      "timezone": "Asia/Ho_Chi_Minh"
     *                  },
     *                  "meta": {
     *                      "fullname": "User 01"
     *                  }
     *              },
     *              {
     *                  "id": 1,
     *                  "username": "user02",
     *                  "email": "user01@local.app",
     *                  "roles": {
     *                      "1": {
     *                          "id": 1,
     *                          "name": "Member",
     *                          "display_name": "Member",
     *                          "description": "Member"
     *                      }
     *                  },
     *                  "activation_key": null,
     *                  "last_visited": "2015-09-01 14:29:36",
     *                  "type": "default",
     *                  "status": 1,
     *                  "created_at": {
     *                      "date": "2015-08-29 01:58:30.000000",
     *                      "timezone_type": 3,
     *                      "timezone": "Asia/Ho_Chi_Minh"
     *                  },
     *                  "meta": {
     *                      "fullname": "User 02"
     *                  }
     *              }
     *          },
     *          "meta": {
     *              "pagination": {
     *                  "total": 2,
     *                  "count": 2,
     *                  "per_page": 10,
     *                  "current_page": 1,
     *                  "total_pages": 1,
     *                  "links": ""
     *              }
     *          }
     *      })
     * })
     */
    public function index(UserIndexRequest $request)
    {
        $users = $this->user->paginate();

        return $this->response()->paginator($users, new UserTransformer)->setStatusCode(200);
    }


    /**
     * Register user
     *
     * Register a new user with a `username` and `password`.
     *
     * @Post("/")
     * @Versions({"v1"})
     * @Parameters({
     *      @Parameter("username", type="string", description="Account username"),
     *      @Parameter("email", type="string", required=true, description="Account email address"),
     *      @Parameter("password", type="string", required=true, description="Account password"),
     *      @Parameter("password_confirm", type="string", required=true, description="Password confirmed"),
     *      @Parameter("meta", type="json", description="Account meta, any data by key:value , etc: 'first_name': 'A'"),
     * })
     * @Transaction({
     *      @Request({
     *          "username": "user03",
     *          "email": "user03@local.app",
     *          "password": "secret",
     *          "password_confirm": "secret",
     *          "meta": {
     *              "first_name": "User",
     *              "last_name": "03"
     *          }
     *      }),
     *      @Response(200, body={
     *          "data": {
     *                  "id": 3,
     *                  "username": "user03",
     *                  "email": "user03@local.app",
     *                  "roles": {
     *                      "1": {
     *                          "id": 1,
     *                          "name": "member",
     *                          "display_name": "Member",
     *                          "description": "Member"
     *                      }
     *                  },
     *                  "activation_key": "EKOmipkYuwE6o2tJsIxYJ3aP",
     *                  "last_visited": "2015-09-01 14:29:36",
     *                  "type": "default",
     *                  "status": 1,
     *                  "created_at": {
     *                      "date": "2015-08-29 01:58:30.000000",
     *                      "timezone_type": 3,
     *                      "timezone": "Asia/Ho_Chi_Minh"
     *                  },
     *                  "meta": {
     *                      "first_name": "User",
     *                      "last_name": "03"
     *                  }
     *              }
     *          }
     *      ),
     *      @Response(422, body={
     *          "message": "Resource validation failed!",
     *          "errors": {
     *              "username": {
     *                  "The username has already been taken.",
     *                  "The username must be between 4 and 24 characters."
     *              },
     *              "email": {
     *                  "The email field is required.",
     *                  "The email has already been taken.",
     *                  "The email may not be greater than 128 characters."
     *              },
     *              "password": {
     *                  "The password field is required.",
     *                  "The password must be at least 6 characters."
     *              },
     *              "password_confirm": {
     *                  "The password confirm field is required.",
     *                  "The password must be at least 6 characters."
     *              },
     *              "meta": {
     *                  "The meta must be an json."
     *              }
     *          },
     *          "status_code": 422
     *      })
     * })
     */
    public function store(UserStoreRequest $request)
    {
        $role       = $this->role->defaultRole();
        $attributes = [
            'email'          => $request->email,
            'password'       => $request->password,
            'activation_key' => $request->status ? null : str_random(24),
            'type'           => $request->type ?: 'default',
            'status'         => 1,
            'roles'          => [ $role ? $role->id : 2 ]
        ];

        if ($request->meta) {
            $meta = is_array($request->meta) ? $request->meta : json_decode($request->meta, true);
            foreach ($meta as $key => $value) {
                $attributes['meta'][$key] = $value;
            }
        }

        if ($request->username) {
            $attributes['username'] = $request->username;
        }

        if ($request->image) {
            $attributes['image'] = $request->image;
        }

        if ($request->images) {
            $attributes['images'] = $request->images;
        }

        if ($response = event('account.before.api.store', [ $attributes ])) {
            $attributes = $response;
        }

        if ($user = $this->user->create($attributes)) {
            event('account.after.api.store', [ $user ]);

            return $this->response()->item($user, new UserTransformer)->statusCode(200);
        }

        return $this->response()->error(trans('core::general.error'), 422);
    }


    /**
     * Get user.
     *
     * Get a user by user id
     *
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="User ID")
     * })
     * @Transaction({
     *      @Response(200, body={
     *          "data": {
     *              "id": 5,
     *              "username": "user01",
     *              "email": "user01@local.app",
     *              "roles": {
     *                  "3": {
     *                      "id": 3,
     *                      "name": "test",
     *                      "display_name": "Test",
     *                      "description": "test"
     *                  }
     *              },
     *              "activation_key": "EKOmipkYuwE6o2tJsIxYJ3aP",
     *              "last_visited": null,
     *              "type": "default",
     *              "status": 1,
     *              "created_at": {
     *                  "date": "2015-09-02 00:49:02.000000",
     *                  "timezone_type": 3,
     *                  "timezone": "Asia/Ho_Chi_Minh"
     *              },
     *              "meta": {}
     *          }
     *      }),
     *      @Response(404, body={
     *          "message": "<strong>Error!</strong> User <strong><i>6</i></strong> not found.",
     *          "status_code": 422,
     *      })
     * })
     *
     */
    public function show(UserShowRequest $request)
    {
        if ($user = $this->user->find($request->user)) {

            return $this->response()->item($user, new UserTransformer)->setStatusCode(200);
        }

        return $this->response()->error(trans('core::user.find_not_found', [ 'id' => $request->user ]), 422);
    }


    /**
     * Update user
     *
     * Update a user by user id or change new password for user
     *
     * @PUT("/{id}")
     *
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="User id"),
     *      @Parameter("username", type="string", description="New username"),
     *      @Parameter("new_password", type="string", description="If user change password, set new_password for
     *                                 change"),
     *      @Parameter("password_confirm", type="string", description="Password confirmed"),
     *      @Parameter("meta", type="json", description="Account meta, any data by key:value , etc: 'first_name':
     *                         'A'"),
     * })
     *
     * @Transaction({
     *      @Request({
     *          "username": "user005",
     *          "new_password": "1234567",
     *          "password_confirm": "1234567"
     *      }),
     *      @Response(200, body={
     *          "data": {
     *              "id": 5,
     *              "username": "user005",
     *              "email": "user01@local.app",
     *              "roles": {
     *                  "3": {
     *                      "id": 3,
     *                      "name": "test",
     *                      "display_name": "Test",
     *                      "description": "test"
     *                  }
     *              },
     *              "activation_key": "EKOmipkYuwE6o2tJsIxYJ3aP",
     *              "last_visited": null,
     *              "type": "default",
     *              "status": 0,
     *              "created_at": {
     *                  "date": "2015-09-02 00:49:02.000000",
     *                  "timezone_type": 3,
     *                  "timezone": "Asia/Ho_Chi_Minh"
     *              },
     *              "meta": {}
     *          }
     *      }),
     *      @Response(403, body={
     *          "message": "Access denied!",
     *          "status_code": 403,
     *      }),
     *      @Response(422, body={
     *          "message": "Resource validation failed!",
     *          "errors": {
     *              "username": {
     *                  "The username has already been taken.",
     *                  "The username must be between 4 and 24 characters."
     *              },
     *              "new_password": {
     *                  "The new password must be at least 6 characters."
     *              },
     *              "password_confirm": {
     *                  "The password confirm and new password must match.",
     *                  "The password confirm must be at least 6 characters."
     *              },
     *              "meta": {
     *                  "The meta must be an json."
     *              }
     *          }
     *      })
     * })
     */
    public function update(UserUpdateRequest $request)
    {
        $attributes = [
            'attributes' => [ ]
        ];

        if ($request->status) {
            $attributes['attributes']['status'] = $request->status;
        }

        if ($request->meta) {
            $metas = is_array($request->meta) ? $request->meta : json_decode($request->meta, true);

            foreach ($metas as $key => $value) {
                $attributes['meta'][$key] = $value;
            }
        }

        if ($request->username) {
            $attributes['attributes']['username'] = $request->username;
        }

        if ($request->new_password) {
            $attributes['attributes']['password'] = bcrypt($request->new_password);
        }

        if ($request->image) {
            $attributes['image'] = $request->image;
        }

        if ($request->images) {
            $attributes['images'] = $request->images;
        }

        if ($response = event('account.before.api.update', [$attributes])) {
            $attributes = $response[0];
        }

        if ($user = $this->user->update($request->route('user'), $attributes)) {
            event('account.after.api.update', [ $user ]);

            return $this->response()->item($user, new UserTransformer)->statusCode(200);
        }

        return $this->response()->error(trans('core::general.error'), 422);
    }
}