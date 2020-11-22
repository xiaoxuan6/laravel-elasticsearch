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
    }
}