<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/25/15
 * Time: 10:50 AM
 */

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Ngocnh\Translator\Translatable;
use Ngocnh\Translator\Contracts\Translatable as TranslatableContract;

class File extends Model implements TranslatableContract
{

    use Translatable, SoftDeletes;

    protected $table = 'files';

    protected $fillable = [ 'author', 'name', 'path', 'url', 'password', 'size', 'mine', 'status' ];

    protected $dates = [ 'created_at', 'updated_at', 'deleted_at' ];

    public $timestamps = true;

    protected $translator = FileDetail::class;

    protected $translatedAttributes = [ 'title', 'description' ];

    protected $translatableForeign = 'file_id';


    public function author()
    {
        return $this->belongsTo(User::class, 'author', 'id')->first();
    }


    public function meta_group($group, $meta_key = false)
    {
        $query = $this->meta()->where('group', '=', $group);

        if ($meta_key) {
            return $query->where('meta_key', '=', $meta_key)->first();
        }

        return $query->get();
    }


    public function meta_key($meta_key)
    {
        return $this->meta()->where('meta_key', '=', $meta_key)->first();
    }


    public function meta()
    {
        return $this->hasMany(FileMeta::class, 'file_id', 'id');
    }


    public static function base64Upload($data, $user, $multiple = false)
    {
        if ($multiple) {
            $files = [ ];

            foreach ($data as $file_data) {
                $files[] = self::base64SaveFile($file_data, $user);
            }

            return $files;
        } else {
            return self::base64SaveFile($data, $user);
        }
    }


    public static function base64SaveFile($data, $user)
    {
        if (isset( $data['data'] ) && isset( $data['name'] )) {
            if (\Storage::disk('ckfinder')->put("{$user->id}/" . $data['name'],
                base64_decode(substr($data['data'], strpos($data['data'], ',') + 1)))
            ) {
                return [
                    'name' => $data['name'],
                    'path' => public_path(env('CK_FINDER_FOLDER', 'files')) . "/{$user->id}/{$data['name']}",
                    'url'  => env('THEME_ASSET_URL', env('APP_URL', url())) . '/' . env('CK_FINDER_FOLDER',
                            'files') . "/{$user->id}/{$data['name']}",
                    'size' => $data['size'],
                    'mine' => $data['type']
                ];
            }
        }

        return false;
    }


    public static function getInfo($path)
    {
        $path = urldecode($path);
        $ext  = explode('/', $path);
        $name = end($ext);
        $mine = $ext[count($ext) - 2];

        return [
            'name' => $name,
            'path' => env('CK_FINDER_FOLDER', 'files') . "/$mine/$name",
            'url'  => '',
            'size' => Storage::disk('ckfinder')->size("$mine/$name"),
            'mine' => $mine
        ];
    }
}