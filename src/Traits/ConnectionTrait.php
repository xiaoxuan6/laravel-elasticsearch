<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\Elasticsearch\Traits;

use Illuminate\Config\Repository;
use Vinhson\Elasticsearch\SearchBuilder;

trait ConnectionTrait
{
    /**
     * Get the default connection.
     *
     * @param null $app
     *
     * @return string
     */
    public function getDefaultConnection($app = null): string
    {
        return $app ? $app['config']['elasticsearch.default'] : config('elasticsearch.default');
    }

    /**
     * Get the type configuration for a named connection.
     *
     * @param $name
     *
     * @return Repository|mixed
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
     * @return Repository|mixed
     */
    public function getElasticsearchType($name = null)
    {
        $connection = $name ?? $this->getDefaultConnection();

        return config("elasticsearch.connections.{$connection}.type");
    }

    /**
     * Notes: 是否设置驱动配置
     * Date: 2020/11/26 11:10.
     *
     * @param null $name
     *
     * @return bool
     */
    public function isExistsConnection($name = null): bool
    {
        return array_key_exists($name, config('elasticsearch.connections')) ?? false;
    }

    /**
     * Notes: 获取 is_unset_type 配置
     * Date: 2020/11/28 19:03.
     *
     * @return Repository|mixed
     */
    public function fetchIsUserType()
    {
        return config('elasticsearch.is_unset_type', false);
    }

    public function refresh($index = null): SearchBuilder
    {
        return SearchBuilder::make($index);
    }
}
