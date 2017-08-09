<?php
/**
 * Created by NgocNH.
 * Date: 1/15/16
 * Time: 4:14 PM
 */

namespace Modules\Core\Http\Controllers\API\v1\Requests;

use Dingo\Api\Auth\Auth;
use Modules\Core\Entities\User;

class UserIndexRequest extends ApiRequest
{

    public function authorize()
    {
        $this->auth = app(Auth::class)->user();
        return $this->auth instanceof User && $this->auth->can(['api.access.all', 'core.api.user.index']);
    }
}