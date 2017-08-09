<?php
/**
 * Created by NgocNH.
 * Date: 3/30/16
 * Time: 3:43 PM
 */

namespace Modules\Core\Http\Requests;

use App\Http\Requests\Request;

class BaseRequest extends Request
{

    public function forbiddenResponse()
    {
        flash()->error(trans('core::general.access_denied',
            [ 'user' => auth()->user()->nickname ?: auth()->user()->email ]));

        return redirect('/');
    }
}