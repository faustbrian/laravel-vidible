<?php

namespace BrianFaust\Vidible;

use Illuminate\Foundation\Application;
use InvalidArgumentException;

class ServiceProvider extends \BrianFaust\ServiceProvider\ServiceProvider
{
    public function boot()
    {
        $this->publishMigrations();

        $this->publishConfig();
    }

    public function register()
    {
        parent::register();

        $this->mergeConfig();

        $this->app->bind(
            \BrianFaust\Vidible\Contracts\VideoRepository::class,
            \BrianFaust\Vidible\Repositories\EloquentVideoRepositor::class
        );

        $this->app->singleton('BrianFaust\Vidible\VidibleService', function (Application $app) {
            $service = new VidibleService(
                $app->make('BrianFaust\Vidible\Contracts\VideoRepository'),
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

    public function provides()
    {
        return array_merge(parent::provides(), [
            BrianFaust\Vidible\VidibleService::class,
            BrianFaust\Vidible\VideoRepository::class,
        ]);
    }

    public function getPackageName()
    {
        return 'vidible';
    }
}
