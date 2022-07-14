<?php
/**
 * This file is part of laravel-elasticsearch.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
use Elasticsearch\ClientBuilder;
use Vinhson\Elasticsearch\SearchBuilder;
use Symfony\Component\VarDumper\VarDumper;

if (! function_exists('es')) {
    /**
     * @return ClientBuilder
     */
    function es(): ClientBuilder
    {
        return app('elasticsearch.connection');
    }
}

if (! function_exists('search')) {
    /**
     * @param null $index
     * @param null $type
     *
     * @return SearchBuilder
     */
    function search($index = null, $type = null): Vinhson\Elasticsearch\SearchBuilder
    {
        $defaultConnection = null;

        $arguments = func_get_args();

        if ($arguments and count($arguments) > 1) {
            $index = $arguments[0];
            $type = $arguments[1];
        } elseif ($arguments = current($arguments) and is_array($arguments) and count($arguments) > 1) {
            $index = $arguments[0];
            $type = $arguments[1];
        } elseif ($index && ! $type && ! is_array($index)) {
            $defaultConnection = $index;
        } else {
            $defaultConnection = config('elasticsearch.default');
        }

        if (! $defaultConnection) {
            $searchBuilder = SearchBuilder::make($index, $type);
        } else {
            $searchBuilder = app(SearchBuilder::class)->connection($defaultConnection);
        }

        return $searchBuilder;
    }
}

if (! function_exists('ddDump')) {
    /**
     * @param $params
     */
    function ddDump($params)
    {
        VarDumper::dump($params);
        exit(1);
    }
}
