<?php
/**
 * Created by NgocNH.
 * Date: 6/7/16
 * Time: 8:51 PM
 */

namespace Modules\Core\Http\Controllers\API\v1;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Modules\Core\Repositories\ConfigRepository;
use Modules\Core\Transformers\ConfigTransformer;
use Modules\Service\Http\Controllers\ApiController;

class Setting extends ApiController
{

    public function __construct(ConfigRepository $config)
    {
        parent::__construct();
        $this->middleware('api.auth');
        $this->manager = new Manager();
        $this->config  = $config;
    }


    public function index()
    {
        $general_configs = $this->config->getByGroup('general');
        $general_configs = new Collection($general_configs, new ConfigTransformer('simple'));
        $general_configs = $this->manager->createData($general_configs)->toArray();
        $general_configs = array_collapse($general_configs['data']);

        $information = $this->config->getByGroup('information');
        $information = new Collection($information, new ConfigTransformer('simple'));
        $information = $this->manager->createData($information)->toArray();
        $information = array_collapse($information['data']);

        $data = [
            'general'     => $general_configs,
            'information' => $information
        ];

        return $this->response()->array($data)->setStatusCode(200);
    }
}