<?php namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use Modules\Core\Entities\AssignedRole;
use Modules\Core\Entities\Locale;
use Modules\Core\Entities\Permission;
use Modules\Core\Entities\PermissionRole;
use Modules\Core\Entities\Role;
use Modules\Core\Entities\User;
use Modules\Core\Entities\UserMeta;
use Log;
use Pingpong\Modules\Facades\Module;

class CoreTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locales')->delete();
        DB::table('users')->delete();
        DB::table('user_meta')->delete();
        DB::table('roles')->delete();
        DB::table('permissions')->delete();
        DB::table('permission_role')->delete();
        DB::table('assigned_roles')->delete();

        DB::beginTransaction();

        try {
            $vi            = Locale::create([ 'name' => 'Vietnamese', 'code' => 'vi', 'order' => 1, 'status' => 1 ]);
            $en            = Locale::create([ 'name' => 'English', 'code' => 'en', 'order' => 2, 'status' => 1 ]);
            $user          = User::create([
                'username'  => 'administrator',
                'email'     => 'me@ngocnh.info',
                'password'  => bcrypt('123456'),
                'type'      => 'default',
                'status'    => 1,
                'locale_id' => $en->id
            ]);
            $user_meta     = UserMeta::create([
                'user_id'    => $user->id,
                'meta_key'   => 'nickname',
                'meta_value' => 'Super Administrator'
            ]);
            $admin         = Role::create([
                'name'         => 'super-administrator',
                'display_name' => 'Super Administrator',
                'description'  => 'Super Administrator',
                'default'      => 0
            ]);
            $member        = Role::create([
                'name'         => 'member',
                'display_name' => 'Member',
                'description'  => 'Member',
                'default'      => 1
            ]);
            $all_perms     = Permission::create([
                'name'         => 'access.all',
                'display_name' => 'core::roles.access.all',
                'module'       => 'core'
            ]);
            $api_all_perms = Permission::create([
                'name'         => 'api.access.all',
                'display_name' => 'core::roles.access.all',
                'module'       => 'core'
            ]);

            foreach (Module::enabled() as $module) {
                if ($configs = config('candy.' . $module->getLowerName() . '.permissions')) {
                    foreach ($configs as $role => $attributes) {
                        $attributes['module'] = $module->getLowerName();
                        Permission::create($attributes);
                    }
                }
            }

            foreach (Module::enabled() as $module) {
                if ($configs = config('candy.' . $module->getLowerName() . '.api_permissions')) {
                    foreach ($configs as $role => $attributes) {
                        $attributes['module'] = $module->getLowerName();
                        Permission::create($attributes);
                    }
                }
            }

            PermissionRole::create([ 'permission_id' => $all_perms->id, 'role_id' => $admin->id ]);
            PermissionRole::create([ 'permission_id' => $api_all_perms->id, 'role_id' => $admin->id ]);
            AssignedRole::create([ 'user_id' => $user->id, 'role_id' => $admin->id ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
        }
    }

}