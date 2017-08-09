<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/1/15
 * Time: 2:32 PM
 */

namespace Modules\Service\Http\Controllers\API\v1;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Modules\Core\Entities\User;
use Modules\Core\Transformers\UserTransformer;
use Modules\Service\Entities\AccessToken;
use Modules\Service\Entities\AccessTokenScope;
use Modules\Service\Entities\SessionScope;
use Modules\Service\Http\Controllers\ApiController;

/**
 *
 * @Resource("Client", uri="/client")
 */
class Client extends ApiController
{

    public function __construct()
    {

    }


    public function accessPasswordCallback($username, $password)
    {
        if (auth()->once([ 'email' => $username, 'password' => $password ]) || auth()->once([
                'username' => $username,
                'password' => $password
            ])
        ) {
            return auth()->user()->id;
        }

        return false;
    }


    /**
     * Get access token
     *
     * Get a JSON representation of access token by client id and secret, if grant type is password, email (username)
     * and password is required.
     *
     * @POST("/access_token")
     * @Versions({"v1"})
     * @Parameters({
     *      @Parameter("grant_type", type="string", required=true, description="Grant type by 'password' or 'client_credentials'"),
     *      @Parameter("client_id", type="string", required=true, description="Registered client id"),
     *      @Parameter("client_secret", type="string", required=true, description="Registered client secret"),
     *      @Parameter("username", type="string", description="Username required if grant type is 'password'"),
     *      @Parameter("password", type="string", description="Password required if grant type is 'password'")
     * })
     * @Transaction({
     *      @Request(
     *          {
     *              "grant_type": "client_credentials",
     *              "client_id": "VmUXPLVP4oTsk2jY",
     *              "client_secret": "UgozNlpaCQ5wtjtnIJkst6j6pCRPyGys"
     *          },
     *          identifier="Grant by 'client_credentials'"
     *      ),
     *      @Request(
     *          {
     *              "grant_type": "password",
     *              "client_id": "VmUXPLVP4oTsk2jY",
     *              "client_secret": "UgozNlpaCQ5wtjtnIJkst6j6pCRPyGys",
     *              "username": "user01@local.app",
     *              "password": "secret"
     *          },
     *          identifier="Grant by 'password'"
     *      ),
     *      @Response(200, body={
     *              "access_token": "MMg6nTjWwllqAWtqugKqfWeVfQsAj92zhkVg0p9O",
     *              "token_type": "Bearer",
     *              "expires_in": 3600
     *      }),
     *      @Response(401, body={
     *           "message": "Client authentication failed.",
     *           "status_code": 500
     *      })
     * })
     */
    public function accessTokenGenerate()
    {
        $access_token_response = Authorizer::issueAccessToken();

        $access_token = AccessToken::find($access_token_response['access_token']);
        $session      = $access_token->session();
        $client       = $session->client();

        foreach ($client->scopes() as $scope) {
            AccessTokenScope::create([
                'access_token_id' => $access_token->id,
                'scope_id'        => $scope->scope_id
            ]);
            SessionScope::create([
                'session_id' => $session->id,
                'scope_id'   => $scope->scope_id
            ]);
        }

        $access_token_response['expire_time'] = $access_token->expire_time;

        return response($access_token_response);
    }


    /**
     * Get User by Access Token
     *
     * Get user information by access token
     *
     * @GET("/user")
     * @Versions({"v1"})
     * @Transaction({
     *      @Response(200, body={
     *          "data": {
     *              "id": 1,
     *              "username": "administrator",
     *              "email": "me@ngocnh.info",
     *              "activation_key": null,
     *              "last_visited": "2015-09-14 16:30:26",
     *              "type": "default",
     *              "status": 1,
     *              "created_at": {
     *                  "date": "2015-09-14 15:49:49.000000",
     *                  "timezone_type": 3,
     *                  "timezone": "Asia/Ho_Chi_Minh"
     *              },
     *              "roles": {
     *                  {
     *                      "id": 1,
     *                      "name": "super-administrator",
     *                      "display_name": "Super Administrator",
     *                      "description": "Super Administrator",
     *                      "default": 0,
     *                      "permissions": {
     *                          {
     *                              "access.all": "All Permissions"
     *                          }
     *                      }
     *                  }
     *              },
     *              "meta": {
     *                  "fullname": "Super Administrator"
     *              }
     *          }
     *      }),
     *      @Response(401, body={
     *           "message": "Unauthorized.",
     *           "status_code": 401
     *      })
     * })
     */
    public function user()
    {
        if ($this->auth()->user() instanceof User) {
            return $this->response()->item(User::where('username', '=', $this->auth()->user()->username)->first(), new UserTransformer)->statusCode(200);
        }

        return $this->response()->errorUnauthorized();
    }
}