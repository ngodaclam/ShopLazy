<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/31/15
 * Time: 9:40 AM
 */

namespace Modules\Service\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Service\Entities\Client;

class ClientTransformer extends TransformerAbstract
{

    public function transform(Client $client)
    {
        $return = [
            'id'     => $client->id,
            'secret' => $client->secret,
            'name'   => $client->name
        ];

        foreach ($client->endpoints() as $endpoint) {
            $return['endpoints'][] = $endpoint->redirect_uri;
        }

        foreach ($client->scopes() as $scope) {
            $return['scopes'][] = $scope->scope_id;
        }

        return $return;
    }
}