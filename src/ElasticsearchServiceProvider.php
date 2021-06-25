<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/22
 * Time: 13:54
 */

namespace Vinhson\Elasticsearch;

use Illuminate\Support\ServiceProvider;
use Vinhson\Elasticsearch\Traits\ConnectionTrait;

class ElasticsearchServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        $this->publishes([__DIR__ . "/../config/elasticsearch.php" => config_path("elasticsearch.php")], "elasticsearch");
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/elasticsearch.php', 'elasticsearch');

        $this->registerElasticsearch();

        $this->app->singleton('SearchBuilder', function () {
            return new SearchBuilder();
        });
    }

    /**
     * Register elasticsearch service
     */
    protected function registerElasticsearch()
    {
        $this->app->singleton('elasticsearch.factory', function () {
            return new Factory();
        });

        $this->app->singleton('elasticsearch', function ($app) {
            return new Manager($app, $app['elasticsearch.factory']);
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ["SearchBuilder", "elasticsearch"];
    }
}