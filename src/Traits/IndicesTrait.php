<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/24
 * Time: 10:55
 */

namespace Vinhson\Elasticsearch\Traits;

use Vinhson\Elasticsearch\SearchBuilder;

trait IndicesTrait
{
    /**
     * 查看字符串分词
     * @param array $body
     * @return array[]
     */
    public function analyze(array $body = []): array
    {
        return $this->getIndex(true) + ['body' => $body];
    }

    /**
     * 字符过滤器
     *
     * @param array $char_filter
     * @return SearchBuilder
     */
    public function charFilter(array $char_filter = []): SearchBuilder
    {
        $this->params['body']['settings']['analysis']['char_filter'] = $char_filter;

        return $this;
    }

    /**
     * 词单元过滤器
     *
     * @param array $filter
     * @return SearchBuilder
     */
    public function filter(array $filter = []): SearchBuilder
    {
        $this->params['body']['settings']['analysis']['filter'] = $filter;

        return $this;
    }

    /**
     * 分词器
     * @param array $analyzer
     * @return SearchBuilder
     */
    public function analyzer(array $analyzer = []): SearchBuilder
    {
        $this->params['body']['settings']['analysis']['analyzer'] = $analyzer;

        return $this;
    }

    /**
     * 分词器集合
     * @param array $char_filter
     * @param array $filter
     * @param array $analyzer
     * @return SearchBuilder
     */
    public function analysis(array $char_filter = [], array $filter = [], array $analyzer = []): SearchBuilder
    {
        $this->params['body']['settings']['analysis'] = [
            'char_filter' => $char_filter,
            'filter' => $filter,
            'analyzer' => $analyzer
        ];

        return $this;
    }

    /**
     * Notes: Put Settings API 允许你更改索引的配置参数:
     * Warning：只能在索引创建时或者在状态为 closed index（闭合的索引）上设置。
     *
     * Date: 2020/11/21 22:18
     * @param array $params 动态 settings (@see https://blog.csdn.net/u013545439/article/details/102744233)
     * @return SearchBuilder
     *
     * ex：
     *      $params = [
     *          'number_of_replicas' => 0, // 是数据备份数，如果只有一台机器，设置为0
     *          'refresh_interval' => 3 // 执行刷新操作的频率
     *      ];
     */
    public function putSettings(array $params = []): SearchBuilder
    {
        $this->params['body']['settings'] = array_merge($params, (array_key_exists('settings', $this->params['body']) ? $this->params['body']['settings'] : []));

        return $this;
    }

    /**
     * Notes: Put Mappings API 允许你更改或增加一个索引的映射。
     * Warning：setAttribute(['include_type_name' => true])
     *          版本 7.0 之后不支持type导致的 (@see https://blog.csdn.net/qq_18671415/article/details/109690458)
     *
     * Date: 2020/11/21 23:34
     * @param array $params
     * @param bool $force 是否修改映射
     * @return SearchBuilder
     *
     * ex：
     *      $params = [
     *          '_source' => [
     *              'enabled' => true
     *          ],
     *          properties' => [
     *              'name' => [
     *                  'type' => 'text'
     *              ],
     *              'id' => [
     *                  'type' => 'integer'
     *              ]
     *          ]
     *      ];
     */
    public function putMapping(array $params = [], $force = false): SearchBuilder
    {
        if (!$force) {
            $this->params['body']['mappings'] = $params;
        } else {
            $this->params['body'] = $params;
        }

        return $this;
    }

    /**
     * Notes: 创建索引添加别名
     * Date: 2020/11/28 12:34
     * @param array|string $aliases
     * @return SearchBuilder
     */
    public function setAliases($aliases): SearchBuilder
    {
        $aliases = is_array($aliases) ? $aliases : [$aliases => new \stdClass()];

        $this->params['body']['aliases'] = $aliases;

        return $this;
    }

    /**
     * 对现有的索引添加别名
     *
     * @param string $alias
     * @param null $index
     * @return array
     */
    public function deleteAlias(string $alias, $index = null): array
    {
        return $this->existsAlias($alias, $index);
    }

    /**
     * 索引别名是否存在
     *
     * @param string $alias
     * @param null $index
     * @return array
     */
    public function existsAlias(string $alias, $index = null): array
    {
        $this->setAttribute(['name' => $alias])->unsetBody();

        if ($index) {
            return $this->setIndex($index)->builder();
        }

        return $this->builder();
    }

    /**
     * 对现有的索引添加别名
     *
     * @param string $alias
     * @param null $index
     * @return array
     */
    public function putAlias(string $alias, $index = null): array
    {
        return $this->existsAlias($alias, $index);
    }

    /**
     * 对现有的索引别名操作
     * @param array $actions
     * @return array
     *
     * ex：
     * 'actions' => [
     * ['remove' => ['index' => 'my_index', 'alias' => 'my_index_alias']],
     * ['add' => ['index' => 'my_index', 'alias' => 'my_index_alias']]
     * ]
     */
    public function updateAliases(array $actions = []): array
    {
        $this->setBody($actions)->unsetType();

        unset($this->params['index']);

        return self::make(null, null, $this->params)->builder();
    }
}
