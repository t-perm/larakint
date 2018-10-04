<?php
namespace TPerm\Larakint;


use Illuminate\Support\Facades\Blade;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $enabled = null;
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->isEnabled()) {
            include_once "kint/k.php";
            Blade::directive('d', function ($expression) {
                d($expression);
            });
            Blade::directive('dd', function ($expression) {
                ddd($expression);
            });
        }
    }

    public function isEnabled()
    {

        if ($this->enabled === null) {
            $config = $this->app['config'];
            $configEnabled = $config->get('app.debug');
            $this->enabled = $configEnabled && !$this->app->runningInConsole() && !$this->app->environment('testing');
        }

        return $this->enabled;
    }
}
