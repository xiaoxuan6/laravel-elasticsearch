<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/24
 * Time: 14:32
 */

namespace Vinhson\Elasticsearch\Facades;

use Illuminate\Support\Facades\Facade;

class ElasticsearchClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "elasticsearch.connection";
    }
}