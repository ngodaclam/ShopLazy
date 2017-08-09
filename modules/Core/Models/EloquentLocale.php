<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 5/3/15
 * Time: 3:09 PM
 */

namespace Modules\Core\Models;

use Modules\Core\Entities\Locale;
use Modules\Core\Repositories\LocaleRepository;

class EloquentLocale extends EloquentModel implements LocaleRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    public function model()
    {
        return Locale::class;
    }


    public function getByCode($code)
    {
        return Locale::where('code', '=', $code)->first();
    }


    public function create($input)
    {
        return Locale::create($input);
    }

    public function update($id, $attributes)
    {
        // TODO: Implement update() method.
    }
}