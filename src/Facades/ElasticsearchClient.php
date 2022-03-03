<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/24
 * Time: 14:32.
 */

namespace Vinhson\Elasticsearch\Facades;

use Elasticsearch\Client;
use Elasticsearch\Namespaces\ClusterNamespace;
use Elasticsearch\Namespaces\IndicesNamespace;
use Illuminate\Support\Facades\Facade;
use Vinhson\Elasticsearch\Manager;

/**
 * Class ElasticsearchClient.
 *
 * @method static Client explain(array $params = [])
 * @method static Client info(array $params = [])
 * @method static Client ping(array $params = [])
 * @method static Client get(array $params = [])
 * @method static Client update(array $params = [])
 * @method static Client mget(array $params = [])
 * @method static Client getScript(array $params = [])
 * @method static Client getScriptContext(array $params = [])
 * @method static Client getScriptLanguages(array $params = [])
 * @method static Client getSource(array $params = [])
 * @method static Client index(array $params = [])
 * @method static Client bulk(array $params = [])
 * @method static Client delete(array $params = [])
 * @method static Client deleteByQuery(array $params = [])
 * @method static Client msearch(array $params = [])
 * @method static Client count(array $params = [])
 * @method static Client search(array $params = [])
 * @method static IndicesNamespace indices()
 * @method static ClusterNamespace cluster()
 * @method static Manager getConnections()
 * @method static Manager setDefaultConnection(string $connection)
 * @method static string getDefaultConnection()
 *
 * @see \Vinhson\Elasticsearch\Manager
 */
class ElasticsearchClient extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'elasticsearch.connection';
    }

    /**
     * @param string|null $name
     *
     * @return mixed
     */
    public static function connection(string $name = null)
    {
        return app('elasticsearch')->connection($name);
    }
}
