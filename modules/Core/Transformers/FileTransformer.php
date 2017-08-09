<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/17/15
 * Time: 10:54 PM
 */

namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Entities\File;

class FileTransformer extends TransformerAbstract
{

    public function transform(File $file)
    {
        $return = [
            'id'          => $file->id,
            'title'       => $file->title,
            'description' => $file->description,
            'name'        => $file->name,
            'url'         => $file->url ?: ( $file->path ? env('THEME_ASSET_URL', env('APP_URL')) . '/' . "/{$file->path}" : '' ),
            'size'        => $file->size,
            'mime'        => $file->mime,
            'meta'        => [ ],
            'created_at'  => $file->created_at->format('H:i d/m/Y')
        ];

        if ($metas = $file->meta()->get()) {
            foreach ($metas as $meta) {
                $return['meta'][$meta->meta_key] = json_decode($meta->meta_value, true) ?: $meta->meta_key;
            }
        }

        return $return;
    }
}