<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/25/15
 * Time: 10:50 AM
 */

namespace Modules\Core\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Entities\File;
use Modules\Core\Entities\FileDetail;
use Modules\Core\Repositories\FileRepository;

class EloquentFile extends EloquentModel implements FileRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    public function model()
    {
        return File::class;
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

            $file = File::create($attributes['attributes']);

            foreach ($attributes['translate'] as $translate) {
                $translate['file_id'] = $file->id;

                FileDetail::create($translate);
            }

            DB::commit();
            Log::info("File $file->id has been created.");

            return $file;
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

            $file = File::find($id);
            $file->fill($attributes['attributes'])->save();

            foreach ($attributes['translate'] as $translate) {
                $translate['file_id'] = $file->id;
                if ($file_detail = FileDetail::where('file_id', '=', $file->id)->where('locale_id', '=',
                    $translate['locale_id'])->first()
                ) {
                    $file_detail->fill($translate)->save();
                } else {
                    FileDetail::create($translate);
                }
            }

            DB::commit();
            Log::info("File $file->id has been updated.");

            return $file;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
    }
}