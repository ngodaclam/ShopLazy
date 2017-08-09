<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/4/15
 * Time: 10:38 AM
 */

namespace Modules\Core\Http\Controllers;

use League\Fractal\Manager;
use Modules\Core\Http\Requests\ConfigStoreRequest;
use Modules\Core\Repositories\ConfigRepository;

class ConfigController extends BackendController
{

    public function __construct(Manager $manager, ConfigRepository $config)
    {
        parent::__construct($manager);
        $this->config = $config;
    }


    public function save(ConfigStoreRequest $request, $external = false)
    {
        $attributes = [ ];

        foreach ($request->all() as $group => $configs) {
            if (is_array($configs)) {
                foreach ($configs as $key => $value) {
                    $attributes[] = [
                        'group' => $group,
                        'key'   => $key,
                        'value' => $value
                    ];
                }
            }

        }

        if ($response = event('core.config.before.save', [ $attributes ])) {
            $attributes = $response[0];
        }

        if ($config = $this->config->save($attributes)) {
            flash(trans('core::config.save_success'));

            return $external ? $config : redirect()->back();
        }

        flash()->error(trans('core::config.save_failed'));

        return $external ? false : redirect()->back()->withInput();
    }
}