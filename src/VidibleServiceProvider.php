<?php


declare(strict_types=1);

/*
 * This file is part of Laravel Vidible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Vidible;

use InvalidArgumentException;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class VidibleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../config/laravel-vidible.php' => config_path('laravel-vidible.php'),
        ], 'config');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-vidible.php', 'laravel-vidible');

        $this->mergeConfig();

        $this->registerRepository();

        $this->registerService();
    }

    /**
     * Register the repository.
     */
    private function registerRepository()
    {
        $this->app->bind(Contracts\VideoRepository::class, Repositories\EloquentVideoRepository::class);
    }

    /**
     * Register the service.
     */
    private function registerService()
    {
        $this->app->singleton(PicibleService::class, function (Application $app) {
            $service = new PicibleService(
                $app->make(Contracts\PictureRepository::class),
                $app,
                $this->setFilesystemAdapter($app),
                new ImageManager()
            );

            return $service;
        });
    }

    /**
     * Set the filesystem adapater according to configuration.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    private function setFilesystemAdapter($app)
    {
        $adapterKey = config('vidible.default');
        $config = config('vidible.adapters.'.$adapterKey);

        if (empty($config)) {
            throw new InvalidArgumentException("Unsupported adapter [$adapterKey]");
        }

        $adapter = $app->make($config['driver']);
        $adapter->setConnection($config['connection']);

        return $adapter;
    }
}
