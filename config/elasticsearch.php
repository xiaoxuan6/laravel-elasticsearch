<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/24
 * Time: 14:40
 */

return [

    /**
     * You can specify one of several different connections when building an
     * Elasticsearch client.
     *
     * Here you may specify which of the connections below you wish to use
     * as your default connection when building an client. Of course you may
     * use create several clients at once, each with different configurations.
     */

    "default" => env('ELASTICSEARCH_CONNECTION', "elastic"),

    /**
     * These are the connection parameters used when building a client.
     */

    'connections' => [

        'elastic' => [
            'hosts' => [
                [
                    'host'   => env('ELASTICSEARCH_HOST', 'localhost'),
                    'port'   => env('ELASTICSEARCH_PORT', 9200),
                    'scheme' => env('ELASTICSEARCH_SCHEME', null),
                    'user'   => env('ELASTICSEARCH_USER', null),
                    'pass'   => env('ELASTICSEARCH_PASS', null),
                ],
            ],

            'logging' => false,

            "index" => env("ELASTICSEARCH_INDEX", "elasticsearch_index"),

            "type" => env("ELASTICSEARCH_TYPE", "elasticsearch_type"),
        ],
    ],
];