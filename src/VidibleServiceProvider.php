<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace BrianFaust\Vidible;

use BrianFaust\ServiceProvider\ServiceProvider;
use Illuminate\Foundation\Application;
use InvalidArgumentException;

class VidibleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishMigrations();

        $this->publishConfig();
    }

    public function register(): void
    {
        parent::register();

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

    public function provides(): array
    {
        return array_merge(parent::provides(), [
            Contracts\VidibleService::class,
            Contracts\VideoRepository::class,
        ]);
    }

    public function getPackageName(): string
    {
        return 'vidible';
    }
}
