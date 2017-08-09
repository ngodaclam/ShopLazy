<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/31/15
 * Time: 2:05 PM
 */

namespace Modules\Core\Http\Controllers;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Modules\Core\Repositories\ConfigRepository;
use Modules\Core\Transformers\ConfigTransformer;

class SettingController extends BackendController
{

    public function __construct(Manager $manager, ConfigRepository $config)
    {
        parent::__construct($manager);
        $this->config = $config;
    }


    public function getIndex()
    {
        $general_configs = $this->config->getByGroup('general');
        $general_configs = new Collection($general_configs, new ConfigTransformer('simple'));
        $general_configs = $this->manager->createData($general_configs)->toArray();
        $general_configs = array_collapse($general_configs['data']);

        $information = $this->config->getByGroup('information');
        $information = new Collection($information, new ConfigTransformer('simple'));
        $information = $this->manager->createData($information)->toArray();
        $information = array_collapse($information['data']);

        $mail = $this->config->getByGroup('mail');
        $mail = new Collection($mail, new ConfigTransformer('simple'));
        $mail = $this->manager->createData($mail)->toArray();
        $mail = array_collapse($mail['data']);

        $data = [
            'settings' => [
                'general'     => $general_configs,
                'information' => $information,
                'mail'        => $mail
            ]
        ];

        if ($response = event('coin.config.after.render', [ $data ])) {
            $data = $response[0];
        }

        return $this->theme->of('core::settings', $data)->render();
    }


    public function getMail()
    {
        $mail_contact_subject = $this->config->getByGroup('mail_template_contact_subject');
        $mail_contact_subject = new Collection($mail_contact_subject, new ConfigTransformer('simple'));
        $mail_contact_subject = $this->manager->createData($mail_contact_subject)->toArray();
        $mail_contact_subject = array_collapse($mail_contact_subject['data']);

        $mail_contact_message = $this->config->getByGroup('mail_template_contact_message');
        $mail_contact_message = new Collection($mail_contact_message, new ConfigTransformer('simple'));
        $mail_contact_message = $this->manager->createData($mail_contact_message)->toArray();
        $mail_contact_message = array_collapse($mail_contact_message['data']);

        $data = [
            'settings' => [
                'mail_template_contact_subject' => $mail_contact_subject,
                'mail_template_contact_message' => $mail_contact_message,
            ]
        ];

        return $this->theme->of('core::mail', $data)->render();
    }
}