<?php

namespace Reportei\Laraground\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use ReflectionException;

class LaragroundServiceProvider extends ServiceProvider
{
    /**
     * Vendor name.
     *
     * @var string
     */
    protected $vendor = 'laraground';
    /**
     * Package name.
     *
     * @var string|null
     */
    protected $package = 'laraground';
    /**
     * Package base path.
     *
     * @var string
     */
    protected $basePath;

    /**
     * LaragroundServiceProvider constructor.
     *
     * @param Application $app
     * @throws ReflectionException
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->basePath = $this->resolveBasePath();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->getViewsPath() => resource_path('views/vendor/laraground'),
            $this->getBasePath() . 'Http/Livewire' => app_path('Http/Livewire/Laraground'),
        ], 'view');

        //$livewirePath = config('livewire.class_namespace', 'App\\Http\\Livewire');
        //config()->set('livewire.class_namespace', 'packages\\Reportei\\Laraground\\Http\\Livewire');

        $this->publishes([
            $this->getAssetsPath() . 'mix-manifest.json' => public_path('vendor/laraground/mix-manifest.json'),
            $this->getAssetsPath() . 'fontawesome.js' => public_path('vendor/laraground/fontawesome.js'),
            $this->getAssetsPath() . 'tailwind.js' => public_path('vendor/laraground/tailwind.js'),
//            $this->getAssetsPath() . 'tailwind.js.map' => public_path('vendor/laraground/tailwind.js.map'),
            $this->getAssetsPath() . 'tailwind.css' => public_path('vendor/laraground/tailwind.css'),
        ], 'assets');

        $this->app->register(new RouteServiceProvider($this->app));
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath . '/';
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    protected function resolveBasePath()
    {
        return dirname((new ReflectionClass($this))->getFileName(), 2);
    }

    /**
     * @return string
     */
    protected function getViewsPath(): string
    {
        return $this->getBasePath() . '../views/';
    }

    /**
     * @return string
     */
    protected function getAssetsPath(): string
    {
        return $this->getBasePath() . '../dist/';
    }
}
