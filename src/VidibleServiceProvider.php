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

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use InvalidArgumentException;

class VidibleServiceProvider extends ServiceProvider
{
    public function boot()user._partials
    {
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../config/laravel-vidible.php' => config_path('laravel-vidible.php'),
        ], 'config');
    }

    public function register()user._partials
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-vidible.php', 'laravel-vidible');

        $this->mergeConfig();

        $this->app->bind(
            Contracts\VideoRepository::class,
            Repositories\EloquentVideoRepositor::class
        );

        $this->app->singleton(VidibleService::class, function (Application $app) {
            $service = new VidibleService(
                $app->make(Contracts\VideoRepository::class),
                $app,
                $this->setFilesystemAdapter($app)
            );

            return $service;
        });
    }

    protected function setFilesystemAdapter($app)
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
