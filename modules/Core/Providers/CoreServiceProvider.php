<?php namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\EventHandler;
use Modules\Core\Models\EloquentConfig;
use Modules\Core\Models\EloquentFile;
use Modules\Core\Models\EloquentFileDetail;
use Modules\Core\Models\EloquentLocale;
use Modules\Core\Models\EloquentPermission;
use Modules\Core\Models\EloquentRole;
use Modules\Core\Models\EloquentUser;
use Modules\Core\Repositories\ConfigRepository;
use Modules\Core\Repositories\FileDetailRepository;
use Modules\Core\Repositories\FileRepository;
use Modules\Core\Repositories\LocaleRepository;
use Modules\Core\Repositories\PermissionRepository;
use Modules\Core\Repositories\RoleRepository;
use Modules\Core\Repositories\UserRepository;
use Modules\Core\Shortcode\FormInput;
use Pingpong\Modules\Module;

class CoreServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @var string
     */
    protected $prefix = 'candy';


    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerShortcode();
        $this->registerModules();
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->events->subscribe(new EventHandler);

        $this->app->bind(UserRepository::class, function () {
            return new EloquentUser;
        });
        $this->app->bind(RoleRepository::class, function () {
            return new EloquentRole;
        });
        $this->app->bind(LocaleRepository::class, function () {
            return new EloquentLocale;
        });
        $this->app->bind(PermissionRepository::class, function () {
            return new EloquentPermission;
        });
        $this->app->bind(FileRepository::class, function () {
            return new EloquentFile;
        });
        $this->app->bind(FileDetailRepository::class, function () {
            return new EloquentFileDetail;
        });
        $this->app->bind(ConfigRepository::class, function () {
            return new EloquentConfig;
        });

        if ($this->app->environment() == 'local') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }


    /**
     * Register modules.
     *
     * @return void
     */
    protected function registerModules()
    {
        foreach ($this->app['modules']->enabled() as $module) {
            $this->registerModuleConfigs($module);
            $this->registerModuleViews($module);
            $this->registerModuleLanguages($module);
        }
    }


    /**
     * Register views.
     *
     * @return void
     */
    public function registerModuleViews(Module $module)
    {
        if ($module->getName() == 'user') {
            return;
        }
        $this->app['view']->addNamespace($module->getName(), $module->getPath() . '/Resources/views');
    }


    /**
     * Register the language namespaces for the modules
     *
     * @param Module $module
     */
    protected function registerModuleLanguages(Module $module)
    {
        $moduleName = $module->getName();

        $langPath = base_path("resources/lang/modules/$moduleName");

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $moduleName);
        } else {
            $this->loadTranslationsFrom($module->getPath() . '/Resources/lang', $moduleName);
        }
    }


    /**
     * Register the config namespace
     *
     * @param Module $module
     */
    public function registerModuleConfigs(Module $module)
    {
        $files = $this->app['files']->files($module->getPath() . '/Config');

        $package = $module->getName();

        foreach ($files as $file) {
            $filename = $this->getConfigFilename($file, $package);

            $this->mergeConfigFrom($file, $filename);

            $this->publishes([
                $file => config_path($filename . '.php'),
            ], 'config');
        }
    }


    /**
     * @param $file
     * @param $package
     *
     * @return string
     */
    private function getConfigFilename($file, $package)
    {
        $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($file));

        $filename = $this->prefix . '.' . $package . '.' . $name;

        return $filename;
    }

    /**
     * @param $file
     * @param $package
     *
     * @return string
     */
    private function registerShortcode()
    {
        new FormInput();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ ];
    }

}
