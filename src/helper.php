<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/22
 * Time: 14:04
 */

if (!function_exists("es")) {
    /**
     * @return \Elasticsearch\ClientBuilder
     */
    function es()
    {
        return app("es");
    }
}

if (!function_exists("search_builder")) {
    /**
     * @param null $index
     * @param null $type
     * @return \Vinhson\Elasticsearch\SearchBuilder
     */
    function search_builder($index = null, $type = null)
    {
        $arguments = func_get_args();

        if ($arguments and count($arguments) > 1) {
            $index = $arguments[0];
            $type = $arguments[1];
        } elseif ($arguments = current($arguments) and is_array($arguments) and count($arguments) > 1) {
            $index = $arguments[0];
            $type = $arguments[1];
        } else {
            $index = $index ?? config("database.elasticsearch.index", "elastic_index");
            $type = $type ?? config("database.elasticsearch.type", "elastic_type");
        }

        $searchBuilder = \Vinhson\Elasticsearch\SearchBuilder::make($index, $type);

        return $searchBuilder;
    }
}