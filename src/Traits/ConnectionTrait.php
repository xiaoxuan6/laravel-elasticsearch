<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/25
 * Time: 17:50
 */

namespace Vinhson\Elasticsearch\Traits;

trait ConnectionTrait
{
    /**
     * Get the default connection.
     *
     * @return string
     */
    public function getDefaultConnection($app = null)
    {
        return $app ? $app['config']['elasticsearch.default'] : config("elasticsearch.default");
    }

    /**
     * Get the type configuration for a named connection.
     *
     * @param $name
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getElasticsearchIndex($name = null)
    {
        $connection = $name ?? $this->getDefaultConnection();

        return config("elasticsearch.connections.{$connection}.index");
    }

    /**
     * Get the type configuration for a named connection.
     *
     * @param $name
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getElasticsearchType($name = null)
    {
        $connection = $name ?? $this->getDefaultConnection();

        return config("elasticsearch.connections.{$connection}.type");
    }

    /**
     * Notes: 是否设置驱动配置
     * Date: 2020/11/26 11:10
     * @param null $name
     * @return bool
     */
    public function isExistsConnection($name = null)
    {
        return array_key_exists($name, config("elasticsearch.connections")) ?? false;
    }
}