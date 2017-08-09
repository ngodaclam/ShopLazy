<?php namespace Modules\Core\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class CoreController extends Controller
{

    use DispatchesJobs, ValidatesRequests;


    public function __construct()
    {

    }
}