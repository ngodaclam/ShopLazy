<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/31/15
 * Time: 9:52 PM
 */

namespace Modules\Service\Http\Requests;

use App\Http\Requests\Request;
use Modules\Service\Repositories\ClientRepository;

class ApplicationUpdateRequest extends Request
{

    public function authorize(ClientRepository $client)
    {
        return $client->find($this->route('application')) && auth()->user()->can([
            'access.all',
            'service.application.edit'
        ]);
    }


    public function rules()
    {
        return [
            'client_name' => 'required'
        ];
    }
}
