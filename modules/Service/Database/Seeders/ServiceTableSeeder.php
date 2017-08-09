<?php namespace Modules\Service\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Service\Entities\Client;
use Modules\Service\Entities\Scope;
use Pingpong\Modules\Facades\Module;

class ServiceTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Scope::create([
            'id'          => 'access.all',
            'description' => 'core::roles.access.all'
        ]);

        foreach (Module::enabled() as $module) {
            if ($configs = config('candy.' . $module->getLowerName() . '.permissions')) {
                foreach ($configs as $role => $attributes) {
                    Scope::create([
                        'id'          => $attributes['name'],
                        'description' => $attributes['display_name']
                    ]);
                }
            }
        }

        Scope::create([
            'id'          => 'api.access.all',
            'description' => 'core::roles.access.all'
        ]);

        foreach (Module::enabled() as $module) {
            if ($configs = config('candy.' . $module->getLowerName() . '.api.permissions')) {
                foreach ($configs as $role => $attributes) {
                    Scope::create([
                        'id'          => $attributes['name'],
                        'description' => $attributes['display_name']
                    ]);
                }
            }
        }
    }

}