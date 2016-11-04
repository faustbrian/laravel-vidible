<?php

namespace BrianFaust\Tests\Vidible;

use GrahamCampbell\TestBench\AbstractPackageTestCase;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    protected function getServiceProviderClass($app)
    {
        return \BrianFaust\Vidible\ServiceProvider::class;
    }
}
