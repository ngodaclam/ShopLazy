<?php
/**
 * Created by ngocnh.
 * Date: 8/4/15
 * Time: 10:38 AM
 */

namespace Modules\Core\Http\Controllers;

use League\Fractal\Manager;
use Modules\Core\Repositories\LocaleRepository;

class AdminController extends BackendController
{

    public function __construct(Manager $manager)
    {
        parent::__construct($manager);
    }


    public function index()
    {
        return $this->theme->of('core::dashboard')->render();
    }


    public function locale($code, LocaleRepository $locale)
    {
        $locale          = $locale->getByCode($code);
        $user            = auth()->user();
        $user->locale_id = $locale->id;
        $user->save();
        theme()->share('locale', $locale->code);

        return redirect()->back();
    }
}