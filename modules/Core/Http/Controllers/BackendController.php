<?php
/**
 * Created by ngocnh.
 * Date: 8/3/15
 * Time: 8:12 PM
 */

namespace Modules\Core\Http\Controllers;

use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;

class BackendController extends CoreController
{

    public function __construct(Manager $manager)
    {
        parent::__construct();
        event('backend.before.load');
        $this->middleware('auth');
        $this->manager = $manager;
        $this->manager->setSerializer(new ArraySerializer);
        $this->theme = theme('default', 'default');
        event('backend.after.load');
    }
}