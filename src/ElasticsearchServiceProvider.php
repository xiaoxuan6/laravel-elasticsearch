<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/22
 * Time: 13:54
 */

namespace Vinhson\Elasticsearch;

use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class ElasticsearchServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('es', function () {
            $ClientBuilder = ClientBuilder::create()->setHosts(config('database.elasticsearch.host', "localhost:9200"));

            if (app()->environment('local') && config("database.elasticsearch.debug", false)) {
                $ClientBuilder->setLogger(app('log')->driver());
            }

            return $ClientBuilder->build();
        });

        $this->app->singleton('SearchBuilder', function($app){
            return new SearchBuilder(
                $app['config']->get("database.elasticsearch.index", "elastic_index"),
                $app['config']->get("database.elasticsearch.type", "elastic_type")
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ["SearchBuilder"];
    }
}