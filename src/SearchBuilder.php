<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/17
 * Time: 11:31
 */

namespace Vinhson\Elasticsearch;

class SearchBuilder
{
    use HasAttribute;

    protected $params = [
        "index" => "",
        "type"  => "",
        "body"  => []
    ];

    /**
     * SearchBuilder constructor.
     * @param null $index
     * @param null $type
     * @param $params
     */
    public function __construct($index = null, $type = null, $params = [])
    {
        $this->init($index, $type);

        if ($params) {
            $this->params = $params;
        }
    }

    /**
     * Notes: 初始化索引名和type
     * Date: 2020/11/17 11:52
     * @param null $index
     * @param null $type
     */
    protected function init($index = null, $type = null)
    {
        if (is_array($index)) {
            list($index, $type) = $index;
        }

        $this->params["index"] = $index ?? "elasticsearch_index";
        $this->params["type"] = $type ?? "elasticsearch_type";
    }

    /**
     * Notes: 实例本类
     * Date: 2020/11/17 14:17
     * @param null $index
     * @param null $type
     * @param array $params
     * @return SearchBuilder
     */
    static public function make($index = null, $type = null, $params = [])
    {
        return new static($index, $type, $params);
    }

    /**
     * Notes: 设置索引名
     * Date: 2020/11/21 22:28
     * @param $index
     * @return $this
     */
    public function setIndex($index)
    {
        $this->params["index"] = $index;

        return $this;
    }

    /**
     * Notes: 获取索引名
     * Date: 2020/11/21 22:29
     * @param bool $force
     * @return mixed
     */
    public function getIndex($force = false)
    {
        return $force ? ["index" => $this->index] : $this->index;
    }

    /**
     * Notes: 删除 type 属性
     * Date: 2020/11/21 22:38
     * @return SearchBuilder
     */
    public function unsetType(): self
    {
        unset($this->params["type"]);

        return self::make(null, null, $this->params);
    }

    /**
     * Notes: 设置文档ID
     * Date: 2020/11/17 13:56
     * @param $id
     * @return $this
     */
    public function setKey($id)
    {
        $this->params["id"] = $id;

        return $this;
    }

    /**
     * Notes: 设置 Body 属性
     * Date: 2020/11/17 11:42
     * @param array $body
     * @return $this
     */
    public function setBody(array $body = [])
    {
        $this->params["body"] = $body;

        return $this;
    }

    /**
     * Notes: 删除 Body 属性
     * Date: 2020/11/17 14:12
     * @return array
     */
    public function unsetBody(): self
    {
        unset($this->params["body"]);

        return self::make(null, null, $this->params);
    }

    /**
     * Notes: 设置获取文档显示的字段
     * Date: 2020/11/17 15:07
     * @param $source 获取字段，多个用','隔开或数组
     * @return $this
     */
    public function setSource($source = null)
    {
        $this->params["_source"] = $source;

        return $this;
    }

    /**
     * Notes: 设置查询语句
     * Date: 2020/11/17 11:43
     * @param array $params
     * @return $this
     */
    public function setParams(array $params = [])
    {
        $this->params["body"]["query"] = $params;

        return $this;
    }

    /**
     * Notes: 分页
     * @param int $page 从第几页开始
     * @param int $pageLime 每页显示个数
     * @return $this
     */
    public function paginate($page = 1, $pageLime = 10)
    {
        $this->params["body"]['from'] = ($page - 1) * $pageLime;
        $this->params["body"]['size'] = $pageLime;

        return $this;
    }

    /**
     * Notes: 排序
     * Date: 2020/11/17 11:40
     * @param array $orderBy
     * @return $this
     */
    public function orderBy(array $orderBy = [])
    {
        foreach ($orderBy as $key => $item) {
            $this->params['body']["sort"][] = [$key => $item];
        }

        return $this;
    }

    /**
     * Notes: 聚合
     * Date: 2020/11/17 11:45
     * @param array $aggregations
     * @return $this
     */
//    public function setAggregations(array $aggregations = [])
//    {
//        $this->params["body"]["aggregations"] = $aggregations;
//
//        return $this;
//    }

    /**
     * Notes: 高亮
     * Date: 2020/11/18 15:34
     * @param array $fields
     * @param bool $force
     * @return $this
     */
    public function highlight($fields = [], $force = false)
    {
        if ($force) {
            $this->params["body"]["highlight"] = $fields;
        } else {
            $this->params["body"]["highlight"]["fields"] = $fields;
        }

        return $this;
    }

    /**
     * Notes: Put Settings API 允许你更改索引的配置参数:
     * Warning：只能在索引创建时或者在状态为 closed index（闭合的索引）上设置。
     *
     * Date: 2020/11/21 22:18
     * @param array $params 动态 settings (@see https://blog.csdn.net/u013545439/article/details/102744233)
     * @return $this
     *
     * ex：
     *      $params = [
     *          "number_of_replicas" => 0, // 是数据备份数，如果只有一台机器，设置为0
     *          "refresh_interval" => 3 // 执行刷新操作的频率
     *      ];
     */
    public function putSettings(array $params = [])
    {
        $this->params["body"]["settings"] = $params;

        return $this;
    }

    /**
     * Notes: Put Mappings API 允许你更改或增加一个索引的映射。
     * Warning：setAttribute(["include_type_name" => true])
     *          版本 7.0 之后不支持type导致的 (@see https://blog.csdn.net/qq_18671415/article/details/109690458)
     *
     * Date: 2020/11/21 23:34
     * @param array $parrams
     * @return $this
     *
     * ex：
     *      $params = [
     *          "_source" => [
     *              "enabled" => true
     *          ],
     *          properties" => [
     *              "name" => [
     *                  "type" => "text"
     *              ],
     *              "id" => [
     *                  "type" => "integer"
     *              ]
     *          ]
     *      ];
     */
    public function putMapping(array $parrams = [])
    {
        $this->params["body"][$this->type] = $parrams;

        return $this;
    }

    /**
     * Notes: 构建查询 sql
     * Date: 2020/11/17 11:41
     * @return array
     */
    public function builder()
    {
        return $this->params;
    }
}