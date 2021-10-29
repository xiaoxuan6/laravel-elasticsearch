<?php

namespace Vinhson\Elasticsearch\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class SearchBuilder
 *
 * @method static \Vinhson\Elasticsearch\SearchBuilder connection(string $name = null)
 * @method static \Vinhson\Elasticsearch\SearchBuilder make($index = null, $type = null, $params = [])
 * @method static \Vinhson\Elasticsearch\SearchBuilder setClient(array $client = [])
 * @method static \Vinhson\Elasticsearch\SearchBuilder ignore(string|array $client)
 * @method static \Vinhson\Elasticsearch\SearchBuilder setIndex(string $index)
 * @method static string getIndex(bool $force = false)
 * @method static \Vinhson\Elasticsearch\SearchBuilder unsetType()
 * @method static \Vinhson\Elasticsearch\SearchBuilder setKey(int|string $id)
 * @method static \Vinhson\Elasticsearch\SearchBuilder setBody(array $body = [])
 * @method static \Vinhson\Elasticsearch\SearchBuilder unsetBody()
 * @method static \Vinhson\Elasticsearch\SearchBuilder setSource(string $source = null)
 * @method static \Vinhson\Elasticsearch\SearchBuilder setParams(array $params = [])
 * @method static \Vinhson\Elasticsearch\SearchBuilder size(int $size = 10)
 * @method static \Vinhson\Elasticsearch\SearchBuilder paginate(int $page = 1, int $pageLime = 10)
 * @method static \Vinhson\Elasticsearch\SearchBuilder orderBy(array $orderBy = [])
 * @method static \Vinhson\Elasticsearch\SearchBuilder highlight(array $fields = [], bool $force = false)
 * @method static \Vinhson\Elasticsearch\SearchBuilder setAttribute(array $attributes = [])
 * @method static \Vinhson\Elasticsearch\SearchBuilder unsetAttribute(array|string $attributes)
 * @method static \Vinhson\Elasticsearch\SearchBuilder putSettings(array $params = [])
 * @method static \Vinhson\Elasticsearch\SearchBuilder putMapping(array $parrams = [], bool $force = false)
 *
 * @method static \Vinhson\Elasticsearch\SearchBuilder template()
 * @method static \Vinhson\Elasticsearch\Indices\PutIndexTemplate putIndexTemplate()
 *
 * @method static array count(array $params = [])
 * @method static array get($id)
 * @method static array delete($id)
 * @method static array deleteByQuery(array $params = [])
 * @method static array deleteAlias(string $alias, $index = null)
 * @method static array existsAlias(string $alias, $index = null)
 * @method static array putAlias(string $alias, $index = null)
 * @method static array updateAliases(array $actions = [])
 * @method static array builder()
 *
 * @see \Vinhson\Elasticsearch\SearchBuilder
 */
class SearchBuilder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SearchBuilder';
    }
}
