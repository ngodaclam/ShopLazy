<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 4/30/15
 * Time: 12:17 AM
 */

namespace Modules\Core\Models;

use Modules\Core\Entities\File;
use Modules\Core\Entities\User;
use Modules\Core\Entities\UserFile;
use Modules\Core\Entities\UserMeta;
use Modules\Core\Repositories\UserRepository;

class EloquentUser extends EloquentModel implements UserRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    public function model()
    {
        return User::class;
    }


    public function create($attributes)
    {
        \DB::beginTransaction();

        try {
            $attributes['attributes']['password'] = bcrypt($attributes['attributes']['password']);
            $user                   = User::create($attributes['attributes']);
            $user->attachRoles($attributes['roles']);

            if (isset( $attributes['meta'] )) {
                foreach ($attributes['meta'] as $key => $value) {
                    $user->meta()->save(new UserMeta([ 'meta_key' => $key, 'meta_value' => $value ]));
                }
            }

            if (isset( $attributes['image'] )) {
                $image = $attributes['image'];

                if (isset( $attributes['image']['data'] )) {
                    $info = File::base64SaveFile($image, $user);
                } else {
                    $info = File::getInfo($attributes['image']);
                }

                $info['author'] = $user->id;
                $info['status'] = 'open';

                if ($image = File::where('mine', '=', $info['mine'])->where('path', '=', $info['path'])->first()) {
                    $image->fill($info)->save();
                } else {
                    $image = File::create($info);
                }

                UserFile::create([
                    'type'    => 'featured',
                    'user_id' => $user->id,
                    'file_id' => $image->id
                ]);
            }

            if (isset( $attributes['images'] )) {
                foreach ($attributes['images'] as $image) {
                    if (isset( $attributes['image']['data'] )) {
                        $info = File::base64SaveFile($image, $user);
                    } else {
                        $info = File::getInfo($attributes['image']);
                    }

                    $info['author'] = $user->id;
                    $info['status'] = 'open';

                    if ($image = File::where('mine', '=', $info['mine'])->where('path', '=', $info['path'])->first()) {
                        $image->fill($info)->save();
                    } else {
                        $image = File::create($info);
                    }

                    UserFile::create([
                        'type'    => 'image',
                        'user_id' => $user->id,
                        'file_id' => $image->id
                    ]);
                }
            }

            if (config('elasticquent.enable')) {
                $user->addToIndex();
            }

            \DB::commit();
            \Log::info("User $user->id has been created");

            return $user;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);

            return false;
        }
    }


    public function update($user, $attributes)
    {
        \DB::beginTransaction();

        try {
            if ( ! $user instanceof User) {
                $user = User::find($user);
            }

            if (isset( $attributes['attributes']['password'] )) {
                $attributes['attributes']['password'] = bcrypt($attributes['attributes']['password']);
            }

            if (isset( $attributes['meta'] )) {
                foreach ($attributes['meta'] as $key => $value) {
                    if (is_array($value)) {
                        if ($user_meta = $user->meta_key($value['meta_key'], $value['group'])) {
                            $user_meta->update([ 'meta_value' => $value['meta_value'] ]);
                        } else {
                            UserMeta::create([
                                'group'      => $value['group'],
                                'meta_key'   => $value['meta_key'],
                                'meta_value' => $value['meta_value'],
                                'user_id'    => $user->id
                            ]);
                        }
                    } else {
                        if ($user_meta = $user->meta_key($key)) {
                            $user_meta->update([ 'meta_value' => $value ]);
                        } else {
                            UserMeta::create([ 'meta_key' => $key, 'meta_value' => $value, 'user_id' => $user->id ]);
                        }
                    }
                }
            }

            $user->fill($attributes['attributes'])->save();

            if (isset( $attributes['image'] )) {
                $image = $attributes['image'];
                if (isset( $attributes['image']['data'] )) {
                    $info = File::base64SaveFile($image, $user);
                } else {
                    $info = File::getInfo($attributes['image']);
                }

                $info['author'] = $user->id;
                $info['status'] = 'open';

                if ($image = File::where('mine', '=', $info['mine'])->where('path', '=', $info['path'])->first()) {
                    $image->fill($info)->save();
                } else {
                    $image = File::create($info);
                }

                if ($user_file = UserFile::where('user_id', '=', $user->id)->where('type', '=', 'featured')->first()) {
                    $user_file->file_id = $image->id;
                    $user_file->save();
                } else {
                    UserFile::create([
                        'type'    => 'featured',
                        'user_id' => $user->id,
                        'file_id' => $image->id
                    ]);
                }
            }

            if (isset( $attributes['images'] )) {
                foreach ($attributes['images'] as $image) {
                    if (isset( $attributes['image']['data'] )) {
                        $info = File::base64SaveFile($image, $user);
                    } else {
                        $info = File::getInfo($attributes['image']);
                    }

                    $info['author'] = $user->id;
                    $info['status'] = 'open';

                    if ($image = File::where('mine', '=', $info['mine'])->where('path', '=', $info['path'])->first()) {
                        $image->fill($info)->save();
                    } else {
                        $image = File::create($info);
                    }

                    if ($user_file = UserFile::where('user_id', '=', $user->id)->where('type', '=',
                        'featured')->first()
                    ) {
                        $user_file->file_id = $image->id;
                        $user_file->save();
                    } else {
                        UserFile::create([
                            'type'    => 'featured',
                            'user_id' => $user->id,
                            'file_id' => $image->id
                        ]);
                    }
                }
            }

            if (isset( $attributes['roles'] )) {
                foreach ($user->roles()->get() as $role) {
                    if ( ! array_search($role->id, $attributes['roles'])) {
                        $user->roles()->detach($role->id);
                    }
                }

                $user->attachRoles($attributes['roles']);
            }

            if (config('elasticquent.enable')) {
                $user->reindex();
            }

            \DB::commit();
            \Log::info("User $user->id has been updated");

            return $user;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);

            return false;
        }
    }


    public function lock($user)
    {
        \DB::beginTransaction();

        try {
            $user->fill([ 'status' => $user->status == 1 ? 0 : 1 ])->save();

            if (config('elasticquent.enable')) {
                $user->reindex();
            }

            \DB::commit();
            \Log::info("User $user->id has been locked");

            return $user;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);

            return false;
        }
    }
}