<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/24
 * Time: 14:22
 */

namespace Vinhson\Elasticsearch;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Arr;

class Factory
{
    /**
     * Make the Elasticsearch client for the given named configuration, or
     * the default client.
     *
     * @param array $config
     *
     * @return \Elasticsearch\Client
     * @throws \Exception
     */
    public function make(array $config): Client
    {
        return $this->client($config);
    }

    /**
     * Build and configure an Elasticsearch client.
     *
     * @param array $config
     *
     * @return \Elasticsearch\Client
     * @throws \Exception
     */
    protected function client(array $config): Client
    {
        $clientBuilder = ClientBuilder::create()->setHosts($config['hosts']);

        // Configure logging
        if (Arr::get($config, 'logging', false)) {
            $clientBuilder = $this->setLog($clientBuilder);
        }

        return $clientBuilder->build();
    }

    /**
     * Notes: Set log configure
     * @param ClientBuilder $clientBuilder
     * @return ClientBuilder
     * @throws \Exception
     */
    protected function setLog(ClientBuilder $clientBuilder): ClientBuilder
    {
        $clientBuilder->setLogger(app('log')->driver());

        return $clientBuilder;
    }
}