<?php
/**
 * This file is part of laravel-elasticsearch.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\Elasticsearch\Traits;

trait DocTrait
{
    /**
     * 根据文档ID获取文档.
     *
     * @param $id
     *
     * @return array|mixed
     */
    public function get($id)
    {
        return $this->getIndex(true) + ['id' => $id];
    }

    /**
     * 根据文档ID获取文档.
     *
     * @param array $ids
     *
     * @return array|\array[][]|mixed
     */
    public function mget(array $ids = [])
    {
        return $this->getIndex(true) + ['body' => ['ids' => $ids]];
    }

    /**
     * 根据ID删除文档.
     *
     * @param $id
     *
     * @return array|mixed
     */
    public function delete($id)
    {
        return $this->get($id);
    }

    /**
     * 根据搜索条件删除文档.
     *
     * @param array $params
     *
     * @return array|mixed
     */
    public function deleteByQuery(array $params = [])
    {
        return $this->getIndex(true) + $this->setParams($params)->builder();
    }

    /**
     * 统计文档个数.
     *
     * @param array $params
     *
     * @return array
     */
    public function count(array $params = []): array
    {
        return $this->setParams($params)->builder();
    }

    /**
     * 多字段排序.
     *
     * @param array $column
     *
     * @return $this
     */
    public function orderByAscOrDesc(array $column = [])
    {
        foreach ($column as $key => $value) {
            $this->orderBy([$key => ['order' => $value]]);
        }

        return $this;
    }

    /**
     * 根据字段值设置排序.
     *
     * @param $column
     * @param $direction
     */
    protected function orderByCloumn($column, $direction)
    {
        $column = is_array($column) ? $column : [$column];

        foreach ($column as $value) {
            $this->orderBy([$value => ['order' => $direction]]);
        }
    }

    /**
     * 根据字段升序排序.
     *
     * @param $column
     *
     * @return $this
     */
    public function orderByAsc($column)
    {
        $this->orderByCloumn($column, 'asc');

        return $this;
    }

    /**
     * 根据字段降序排序.
     *
     * @param $column
     *
     * @return $this
     */
    public function orderByDesc($column)
    {
        $this->orderByCloumn($column, 'desc');

        return $this;
    }

    /**
     * 设置搜索结果中可展示的字段.
     *
     * @param array $column
     *
     * @return $this
     */
    public function stored(array $column = [])
    {
        $this->params['body']['stored_fields'] = $column;

        return $this;
    }
}
