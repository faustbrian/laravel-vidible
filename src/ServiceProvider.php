<?php

namespace DraperStudio\Vidible;

use Illuminate\Foundation\Application;
use DraperStudio\ServiceProvider\ServiceProvider as BaseProvider;
use InvalidArgumentException;

class ServiceProvider extends BaseProvider
{
    protected $packageName = 'vidible';

    public function boot()
    {
        $this->setup(__DIR__)
             ->publishMigrations()
             ->publishConfig()
             ->mergeConfig('vidible');
    }

    public function register()
    {
        $this->app->bind(
            'DraperStudio\Vidible\Contracts\VideoRepository',
            'DraperStudio\Vidible\Repositories\EloquentVideoRepository'
        );

        $this->app->singleton('DraperStudio\Vidible\VidibleService', function (Application $app) {
            $service = new VidibleService(
                $app->make('DraperStudio\Vidible\Contracts\VideoRepository'),
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
        return [
            'DraperStudio\Vidible\VidibleService',
            'DraperStudio\Vidible\VideoRepository',
        ];
    }
}
