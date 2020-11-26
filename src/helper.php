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
        return app("elasticsearch.connection");
    }
}

if (!function_exists("search")) {
    /**
     * @param null $index
     * @param null $type
     * @return \Vinhson\Elasticsearch\SearchBuilder
     */
    function search($index = null, $type = null)
    {
        $defaultConnection = null;

        $arguments = func_get_args();

        if ($arguments and count($arguments) > 1) {
            $index = $arguments[0];
            $type = $arguments[1];
        } elseif ($arguments = current($arguments) and is_array($arguments) and count($arguments) > 1) {
            $index = $arguments[0];
            $type = $arguments[1];
        } elseif ($index && !$type && !is_array($index)) {
            $defaultConnection = $index;
        } else {
            $defaultConnection = config("elasticsearch.default");
        }

        if (!$defaultConnection) {
            $searchBuilder = \Vinhson\Elasticsearch\SearchBuilder::make($index, $type);
        } else {
            $searchBuilder = app(\Vinhson\Elasticsearch\SearchBuilder::class)->connection($defaultConnection);
        }

        return $searchBuilder;
    }
}
