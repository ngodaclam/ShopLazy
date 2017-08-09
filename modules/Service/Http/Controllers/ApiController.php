<?php namespace Modules\Service\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;

class ApiController extends Controller
{

    use Helpers;


    public function __construct()
    {
        $this->middleware('api.auth');
    }
}