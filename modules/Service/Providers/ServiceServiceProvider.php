<?php namespace Modules\Service\Providers;

use Dingo\Api\Auth\Auth;
use Dingo\Api\Auth\Provider\Basic;
use Dingo\Api\Auth\Provider\OAuth2;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Entities\User;
use Modules\Service\Entities\Client;
use Modules\Service\Events\EventHandler;
use Modules\Service\Models\EloquentClient;
use Modules\Service\Repositories\ClientRepository;

class ServiceServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerAuthType();
        $this->registerConfig();
        $this->registerTranslations();
        $this->registerViews();
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->events->subscribe(new EventHandler);

        $this->app->bind(ClientRepository::class, function () {
            return new EloquentClient;
        });
    }


    public function registerAuthType()
    {
        $this->app[Auth::class]->extend('basic', function ($app) {
            return new Basic($app['auth']);
        });

        $this->app[Auth::class]->extend('oauth', function ($app) {
            $provider = new OAuth2($app['oauth2-server.authorizer']->getChecker());

            $provider->setUserResolver(function ($id) {
                return User::find($id);
            });

            $provider->setClientResolver(function ($id) {
                return Client::find($id);
            });

            return $provider;
        });
    }


    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('service.php'),
        ]);
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'service');
    }


    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/service');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom([ $viewPath, $sourcePath ], 'service');
    }


    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/service');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'service');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'service');
        }
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
