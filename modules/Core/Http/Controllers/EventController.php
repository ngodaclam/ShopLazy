<?php
/**
 * Created by ngocnh.
 * Date: 8/4/15
 * Time: 10:57 AM
 */

namespace Modules\Core\Http\Controllers;

use Caffeinated\Menus\Builder;
use Modules\Core\Repositories\LocaleRepository;
use Menu;

class EventController
{

    public function __construct(LocaleRepository $locale)
    {
        $this->locale = $locale;
    }


    public function after_backend_load()
    {
        $this->loadDefaultSidebar();
        $this->widgetsSetup();
        $this->setDefaultLocale();
        theme()->share('locales', $this->loadDefaultLocales());
    }


    public function loadDefaultLocales()
    {
        $results = $this->locale->all();
        $locales = [ ];

        foreach ($results as $locale) {
            $locales[$locale->code] = $locale;
        }

        return $locales;
    }


    public function setDefaultLocale()
    {
        $locale = $this->locale->find(auth()->user() ? auth()->user()->locale_id : 1);
        app()->setLocale($locale->code);
        theme()->share('locale', $locale->code);
    }


    public function loadDefaultSidebar()
    {
        Menu::make('backend', function ($menu) {
            foreach (app('modules')->getOrdered() as $module) {
                if ($menuConfig = config("candy.{$module->getLowerName()}.menu")) {
                    $this->loopMenu($menu, $menuConfig);
                }
            }
        })->filter(function ($item) {
            return auth()->check() && auth()->user()->can(array_merge([ 'access.all' ], $item->permissions)) ?: false;
        })->sortBy('order');
    }


    public function loopMenu($menu, $data)
    {
        foreach ($data as $key => $menuItem) {
            if ($menu instanceof Builder && $item = $menu->{camel_case($key)}) {
            } else {
                if (isset($menuItem['route']) && $menuItem['route']) {
                    $item = $menu->add(trans($menuItem['text']), [
                        'route' => $menuItem['route'],
                        'class' => $menuItem['class']
                    ]);

                    $item->slug = $key;
                } else {
                    $menu = $menu->get($key);
                    $item = $menu->add(trans($menuItem['text']), [ 'class' => $menuItem['class'] ]);
                }

                $item->data('name', $menuItem['name'])
                    ->data('icon', $menuItem['icon'])
                    ->data('order', $menuItem['order'])
                    ->data('permissions', $menuItem['permissions'])
                    ->active($menuItem['active']);
            }

            if (isset( $menuItem['subs'] ) && $menuItem['subs']) {
                $this->loopMenu($item, $menuItem['subs']);
            }
        }
    }


    public function widgetsSetup()
    {
        $widgets = [];

        foreach (app('modules')->enabled() as $module) {
            if ($widget_config = config("candy.{$module->getLowerName()}.widgets")) {
                foreach ($widget_config as $config) {
                    \Widget::register($config['tag'], $config['class']);
                    $widgets[$config['position']][] = $config;
                }
            }
        }

        theme()->share('widgets', $widgets);
    }
}