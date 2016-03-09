<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Vidible;

use Illuminate\Foundation\Application;
use InvalidArgumentException;

/**
 * Class ServiceProvider.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class ServiceProvider extends \DraperStudio\ServiceProvider\ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishMigrations();

        $this->publishConfig();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        parent::register();

        $this->mergeConfig();

        $this->app->bind(
            \DraperStudio\Vidible\Contracts\VideoRepository::class,
            \DraperStudio\Vidible\Repositories\EloquentVideoRepositor::class
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

    /**
     * @param $app
     *
     * @return mixed
     */
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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_merge(parent::provides(), [
            DraperStudio\Vidible\VidibleService::class,
            DraperStudio\Vidible\VideoRepository::class,
        ]);
    }

    /**
     * Get the default package name.
     *
     * @return string
     */
    public function getPackageName()
    {
        return 'vidible';
    }
}
