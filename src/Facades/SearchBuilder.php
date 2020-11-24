<?php

namespace Vinhson\Elasticsearch\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class SearchBuilder
 *
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
 * @method static \Vinhson\Elasticsearch\SearchBuilder paginate(int $page = 1, int $pageLime = 10)
 * @method static \Vinhson\Elasticsearch\SearchBuilder orderBy(array $orderBy = [])
 * @method static \Vinhson\Elasticsearch\SearchBuilder highlight(array $fields = [], bool $force = false)
 * @method static \Vinhson\Elasticsearch\SearchBuilder setAttribute(array $attributes = [])
 * @method static \Vinhson\Elasticsearch\SearchBuilder unsetAttribute(array|string $attributes)
 * @method static \Vinhson\Elasticsearch\SearchBuilder putSettings(array $params = [])
 * @method static \Vinhson\Elasticsearch\SearchBuilder putMapping(array $parrams = [])
 * @method static array updateAliases(array $aliases = [])
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
