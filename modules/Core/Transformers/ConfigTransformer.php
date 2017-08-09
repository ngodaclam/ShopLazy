<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/4/15
 * Time: 2:26 PM
 */

namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Entities\Config;

class ConfigTransformer extends TransformerAbstract
{

    public function __construct($type = 'default')
    {
        $this->type = $type;
    }


    public function transform(Config $config)
    {
        if ($this->type == 'simple') {
            return [
                $config->key => $config->value
            ];
        }

        return [
            'id'    => $config->id,
            'group' => $config->group,
            'key'   => $config->key,
            'value' => $config->value,
        ];
    }
}