<?php
/**
 * Created by NgocNH.
 * Date: 10/7/15
 * Time: 9:39 PM
 */

namespace Modules\Post\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\Models\EloquentModel;
use Modules\Post\Entities\Taxonomy;
use Modules\Post\Entities\TaxonomyFile;
use Modules\Post\Repositories\TaxonomyFileRepository;

class EloquentTaxonomyFile extends EloquentModel implements TaxonomyFileRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    public function model()
    {
        return TaxonomyFile::class;
    }


    /**
     * Create a resource
     *
     * @param $data
     *
     * @return mixed
     */
    public function create($attributes)
    {
        DB::beginTransaction();

        try {
            $taxonomy_file = Taxonomy::create($attributes);

            Log::info("Taxonomy File $taxonomy_file->id has been created.");
            DB::commit();

            return $taxonomy_file;
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();

            return false;
        }
    }


    /**
     * Update a resource
     *
     * @param        $model
     * @param  array $data
     *
     * @return mixed
     */
    public function update($id, $attributes)
    {
        // TODO: Implement update() method.
    }
}