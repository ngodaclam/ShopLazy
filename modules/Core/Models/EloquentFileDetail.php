<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/25/15
 * Time: 10:51 AM
 */

namespace Modules\Core\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Entities\FileDetail;
use Modules\Core\Repositories\FileDetailRepository;

class EloquentFileDetail extends EloquentModel implements FileDetailRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    public function model()
    {
        return FileDetail::class;
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
            $file_detail = FileDetail::create($attributes);
            DB::commit();
            Log::info("File detail $file_detail->id has been created.");

            return $file_detail;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

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
        DB::beginTransaction();

        try {
            $file_detail = FileDetail::find($id);
            $file_detail->fill($attributes)->save();
            DB::commit();
            Log::info("File detail $file_detail->id has been created.");

            return $file_detail;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
    }
}