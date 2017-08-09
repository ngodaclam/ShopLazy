<?php
/**
 * Created by NgocNH.
 * Date: 6/7/16
 * Time: 8:55 PM
 */

namespace Modules\Core\Http\Controllers\API\v1\Requests;

use Dingo\Api\Auth\Auth;

class SettingIndexRequest extends ApiRequest
{

    public function authorize()
    {
        $this->auth = app(Auth::class)->user();
        return $this->auth->can(['api.access.all', 'core.api.setting.index']);
    }
}