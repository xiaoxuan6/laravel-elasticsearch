<?php
/**
 * This file is part of laravel-elasticsearch.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\Elasticsearch;

use Illuminate\Support\ServiceProvider;
use Vinhson\Elasticsearch\Traits\ConnectionTrait;

class ElasticsearchServiceProvider extends ServiceProvider
{
    use ConnectionTrait;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/elasticsearch.php' => config_path('elasticsearch.php')], 'elasticsearch');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/elasticsearch.php', 'elasticsearch');

        $this->registerElasticsearch();

        $this->app->singleton('SearchBuilder', function () {
            return new SearchBuilder(
                $this->getElasticsearchIndex(),
                $this->getElasticsearchType()
            );
        });
    }

    /**
     * Register elasticsearch service.
     */
    protected function registerElasticsearch()
    {
        $this->app->singleton('elasticsearch.factory', function () {
            return new Factory();
        });

        $this->app->singleton('elasticsearch', function ($app) {
            return new Manager($app, $app['elasticsearch.factory']);
        });

        $this->app->bind('elasticsearch.connection', function ($app) {
            return $app['elasticsearch']->connection();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['SearchBuilder', 'elasticsearch.connection'];
    }
}
