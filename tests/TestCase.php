<?php
/**
 * This file is part of laravel-elasticsearch.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\LaravelPackageSkeleton\Tests;

use Illuminate\Foundation\Application;
use Vinhson\Elasticsearch\ElasticsearchServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Get package providers.
     *
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            ElasticsearchServiceProvider::class
        ];
    }
}
