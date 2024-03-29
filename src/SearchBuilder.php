<?php
/**
 * This file is part of laravel-elasticsearch.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\Elasticsearch;

use InvalidArgumentException;
use Illuminate\Contracts\Support\{Arrayable, Jsonable};
use Vinhson\Elasticsearch\Traits\{ConnectionTrait,
    DocTrait,
    HasAttributeTrait,
    IndicesTrait,
    SearchTrait,
    TemplateTrait,
    ToArayTrait,
    ToJsonTrait
};

class SearchBuilder implements Arrayable, Jsonable
{
    use ConnectionTrait;
    use DocTrait;
    use HasAttributeTrait;
    use IndicesTrait;
    use TemplateTrait;
    use SearchTrait;
    use ToArayTrait;
    use ToJsonTrait;

    public $result;

    protected $params = [
        'index' => '',
        'type' => '',
        'body' => [],
    ];

    /**
     * SearchBuilder constructor.
     *
     * @param null $index
     * @param null $type
     * @param array $params
     */
    public function __construct($index = null, $type = null, array $params = [])
    {
        $this->init($index, $type);

        if ($params) {
            $this->params = $params;
        }
    }

    /**
     * Notes: 初始化索引名和type
     * Date: 2020/11/17 11:52.
     *
     * @param null $index
     * @param null $type
     */
    protected function init($index = null, $type = null)
    {
        if (is_array($index)) {
            [$index, $type] = $index;
        }

        $this->params['index'] = $index ?? 'elasticsearch_index';
        $this->params['type'] = $type ?? 'elasticsearch_type';
    }

    /**
     * Notes: 实例本类
     * Date: 2020/11/17 14:17.
     *
     * @param null $index
     * @param null $type
     * @param array $params
     *
     * @return SearchBuilder
     */
    public static function make($index = null, $type = null, array $params = []): SearchBuilder
    {
        return new static($index, $type, $params);
    }

    /**
     * Retrieve or build the named connection.
     *
     * @param string|null $name
     *
     * @return SearchBuilder
     */
    public function connection(string $name = null): SearchBuilder
    {
        if (! ($name && $this->isExistsConnection($name))) {
            throw new InvalidArgumentException("Elasticsearch connection [$name] not configured.");
        }

        $index = $this->getElasticsearchIndex($name);
        $type = $this->getElasticsearchType($name);

        return self::make($index, $type);
    }

    /**
     * @return array
     */
    public function explain(): array
    {
        $this->params['explain'] = true;

        return $this->builder();
    }

    /**
     * Notes: 自定义查询参数
     * Date: 2020/11/24 10:15.
     *
     * @param array $client
     *
     * @return $this
     */
    public function setClient(array $client = []): SearchBuilder
    {
        $this->params['client'] = $client;

        return $this;
    }

    /**
     * Notes: 忽略异常
     * Date: 2020/11/24 10:06.
     *
     * @param int $status 忽略错误码（多个是数组）
     *
     * @return $this
     */
    public function ignore(int $status = 404): SearchBuilder
    {
        $this->setClient(['ignore' => $status]);

        return $this;
    }

    /**
     * Notes: 设置索引名
     * Date: 2020/11/21 22:28.
     *
     * @param $index
     *
     * @return $this
     */
    public function setIndex($index): SearchBuilder
    {
        $this->params['index'] = $index;

        return $this;
    }

    /**
     * Notes: 获取索引名
     * Date: 2020/11/21 22:29.
     *
     * @param bool $force
     *
     * @return mixed
     */
    public function getIndex(bool $force = false)
    {
        return $force ? ['index' => $this->index] : $this->index;
    }

    /**
     * Notes: 删除 type 属性
     * Date: 2020/11/21 22:38.
     *
     * @return SearchBuilder
     */
    public function unsetType(): self
    {
        unset($this->params['type']);

        return self::make(null, null, $this->params);
    }

    /**
     * Notes: 设置文档ID
     * Date: 2020/11/17 13:56.
     *
     * @param $id
     *
     * @return $this
     */
    public function setKey($id): SearchBuilder
    {
        $this->params['id'] = $id;

        return $this;
    }

    /**
     * Notes: 设置 Body 属性
     * Date: 2020/11/17 11:42.
     *
     * @param array $body
     *
     * @return $this
     */
    public function setBody(array $body = []): SearchBuilder
    {
        $this->params['body'] = $body;

        return $this;
    }

    /**
     * Notes: 删除 Body 属性
     * Date: 2020/11/17 14:12.
     *
     * @return SearchBuilder
     */
    public function unsetBody(): self
    {
        unset($this->params['body']);

        return self::make(null, null, $this->params);
    }

    /**
     * Notes: 设置获取文档显示的字段
     * Date: 2020/11/17 15:07.
     *
     * @param array $source
     *
     * @return $this
     */
    public function setSource(array $source = []): SearchBuilder
    {
        $this->params['_source'] = $source;

        return $this;
    }

    /**
     * Notes: 设置查询语句
     * Date: 2020/11/17 11:43.
     *
     * @param array $params
     *
     * @return $this
     */
    public function setParams(array $params = []): SearchBuilder
    {
        $this->params['body']['query'] = $params;

        return $this;
    }

    /**
     * 后置过滤器.
     *
     * @param array $params
     *
     * @return $this
     */
    public function postFilter(array $params = []): SearchBuilder
    {
        $this->params['body']['query'] = $params;

        return $this;
    }

    /**
     * 设置返回值条数.
     *
     * @param int $size
     *
     * @return SearchBuilder
     */
    public function size(int $size = 10): SearchBuilder
    {
        $this->params['size'] = $size;

        return $this;
    }

    /**
     * Notes: 分页.
     *
     * @param int $page 从第几页开始
     * @param int $pageLime 每页显示个数
     *
     * @return $this
     */
    public function paginate(int $page = 1, int $pageLime = 10): SearchBuilder
    {
        $this->params['body']['from'] = ($page - 1) * $pageLime;
        $this->params['body']['size'] = $pageLime;

        return $this;
    }

    /**
     * Notes: 排序
     * Date: 2020/11/17 11:40.
     *
     * @param array $orderBy
     *
     * @return $this
     */
    public function orderBy(array $orderBy = []): SearchBuilder
    {
        foreach ($orderBy as $key => $item) {
            $this->params['body']['sort'][] = [$key => $item];
        }

        return $this;
    }

    /**
     * 聚合操作.
     *
     * @param array $aggs
     *
     * @return $this
     */
    public function setAggregations(array $aggs = []): SearchBuilder
    {
        $this->params['body']['aggs'] = $aggs;

        return $this;
    }

    /**
     * Notes: 高亮
     * Date: 2020/11/18 15:34.
     *
     * @param array $fields
     * @param bool $force
     *
     * @return $this
     */
    public function highlight(array $fields = [], bool $force = false): SearchBuilder
    {
        if ($force) {
            $this->params['body']['highlight'] = $fields;
        } else {
            $this->params['body']['highlight']['fields'] = $fields;
        }

        return $this;
    }

    /**
     * Notes: 构建查询 sql
     * Date: 2020/11/17 11:41.
     *
     * @return array
     */
    public function builder(): array
    {
        if ($this->fetchIsUserType()) {
            $this->unsetType();
        }

        if (isset($this->params['body']['id']) && ! isset($this->params['id'])) {
            $this->params['id'] = $this->params['body']['id'];
        }

        return $this->params;
    }
}
