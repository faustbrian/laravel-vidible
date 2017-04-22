<?php



declare(strict_types=1);

namespace BrianFaust\Tests\Vidible;

use GrahamCampbell\TestBench\AbstractPackageTestCase;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    protected function getServiceProviderClass($app): string
    {
        return \BrianFaust\Vidible\ServiceProvider::class;
    }
}
