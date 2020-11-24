<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/22
 * Time: 13:54
 */

namespace Vinhson\Elasticsearch;

use Illuminate\Support\ServiceProvider;

class ElasticsearchServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__ . "/../config/elasticsearch.php" => config_path("elasticsearch.php")], "elasticsearch");
    }

    public function register()
    {
        $this->registerElasticsearch();

        $this->app->singleton('SearchBuilder', function () {
            return new SearchBuilder(
                config("elasticsearch.index", "elastic_index"),
                config("elasticsearch.type", "elastic_type")
            );
        });
    }

    protected function registerElasticsearch()
    {
        $this->app->singleton('elasticsearch.factory', function () {
            return new Factory();
        });

        $this->app->singleton('elasticsearch', function ($app) {
            return new Manager($app, $app['elasticsearch.factory']);
        });

        $this->app->bind("elasticsearch.connection", function ($app) {
            return $app['elasticsearch']->connection();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ["SearchBuilder", "elasticsearch.connection"];
    }
}