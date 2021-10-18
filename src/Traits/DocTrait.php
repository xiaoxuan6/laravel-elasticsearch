<?php

namespace Vinhson\Elasticsearch\Traits;

trait DocTrait
{
    /**
     * 根据文档ID获取文档
     * @param $id
     * @return array|mixed
     */
    public function get($id)
    {
        return $this->getIndex(true) + ['id' => $id];
    }

    /**
     * 根据文档ID获取文档
     * @param array $ids
     * @return array|\array[][]|mixed
     */
    /**
     * @param array $ids
     * @return array|\array[][]|mixed
     */
    public function mget(array $ids = [])
    {
        return $this->getIndex(true) + ['body' => ['ids' => $ids]];
    }

    /**
     * 根据ID删除文档
     * @param $id
     * @return array|mixed
     */
    public function delete($id)
    {
        return $this->get($id);
    }

    /**
     * 根据搜索条件删除文档
     * @param array $params
     * @return array|mixed
     */
    public function deleteByQuery(array $params = [])
    {
        return $this->getIndex(true) + $this->setParams($params)->builder();
    }

    /**
     * 统计文档个数
     *
     * @param array $params
     * @return array
     */
    public function count(array $params = []): array
    {
        return $this->setParams($params)->builder();
    }
}
