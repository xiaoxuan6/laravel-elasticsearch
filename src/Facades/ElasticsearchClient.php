<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/24
 * Time: 14:32
 */

namespace Vinhson\Elasticsearch\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ElasticsearchClient
 *
 * @method static \Vinhson\Elasticsearch\Manager setDefaultConnection(string $connection)
 * @method static string getDefaultConnection()
 * @method static array getConnections()
 *
 * @see \Vinhson\Elasticsearch\Manager
 */
class ElasticsearchClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "elasticsearch.connection";
    }

    /**
     * Notes:
     * Date: 2020/11/25 17:43
     * @param string|null $name
     * @return mixed
     */
    public static function connection(string $name = null)
    {
        return app("elasticsearch")->connection($name);
    }
}