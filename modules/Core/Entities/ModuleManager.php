<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 5/7/15
 * Time: 9:54 PM
 */

namespace Modules\Core\Entities;

use Pingpong\Modules\Facades\Module;

class ModuleManager
{

    public static function config($module, $key)
    {
        return config(strtolower($module) . '::config')[$key];
    }


    public static function menus()
    {
        $main_menu = [ ];

        foreach (Module::enabled() as $module) {
            if ($menus = config($module->getLowerName() . '.menu')) {
                foreach ($menus as $key => $value) {
                    if (isset( $main_menu[$key] )) {
                        foreach ($value['sub'] as $skey => $svalue) {
                            $main_menu[$key]['sub'][$skey] = $svalue;
                        }
                    } else {
                        $main_menu[$key] = $value;
                    }
                }
            }
        }

        return $main_menu;
    }
}