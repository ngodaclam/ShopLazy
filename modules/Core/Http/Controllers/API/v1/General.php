<?php
/**
 * Created by NgocNH.
 * Date: 6/7/16
 * Time: 9:53 PM
 */

namespace Modules\Core\Http\Controllers\API\v1;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Modules\Core\Http\Controllers\API\v1\Requests\ContactRequest;
use Modules\Core\Repositories\ConfigRepository;
use Modules\Core\Transformers\ConfigTransformer;
use Modules\Service\Http\Controllers\ApiController;

class General extends ApiController
{

    public function __construct(Manager $manager, ConfigRepository $config)
    {
        parent::__construct();
        $this->manager = $manager;
        $this->config  = $config;
    }


    public function contact(ContactRequest $request)
    {
        $subject     = $this->config->getByGroup('mail_template_contact_subject', \App::getLocale());
        $message     = $this->config->getByGroup('mail_template_contact_message', \App::getLocale());
        $information = $this->config->getByGroup('information');
        $information = new Collection($information, new ConfigTransformer('simple'));
        $information = $this->manager->createData($information)->toArray();
        $information = array_collapse($information['data']);

        \Mail::send('core::emails.contact', [ 'name' => $request->name, 'messages' => $message->value ],
            function ($m) use ($request, $information, $subject) {
                $m->from($information['email'], $information['site_owner']);

                $m->to($request->email, $request->name)->subject($subject->value);
            }
        );

        \Mail::send('core::emails.contact', [ 'name' => $information['site_owner'], 'messages' => $request->message ],
            function ($m) use ($request, $information, $subject) {
                $m->from($information['email'], $information['site_owner']);

                $m->to($information['email'], $information['site_owner'])->subject($request->subject);
            }
        );
    }
}