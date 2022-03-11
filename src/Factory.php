<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\Elasticsearch;

use Exception;
use Illuminate\Support\Arr;
use Elasticsearch\{Client, ClientBuilder};

class Factory
{
    /**
     * Make the Elasticsearch client for the given named configuration, or
     * the default client.
     *
     * @param array $config
     *
     * @return Client
     *@throws Exception
     *
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
     * @return Client
     *@throws Exception
     *
     */
    protected function client(array $config): Client
    {
        $clientBuilder = ClientBuilder::create()->setHosts($config['hosts']);

        // Configure logging
        if (Arr::get($config, 'logging', false)) {
            $clientBuilder = $this->setLog($clientBuilder);
        }

        return $clientBuilder->setRetries($config['retries'])->build();
    }

    /**
     * Notes: Set log configure.
     *
     * @param ClientBuilder $clientBuilder
     *
     * @throws Exception
     *
     * @return ClientBuilder
     */
    protected function setLog(ClientBuilder $clientBuilder): ClientBuilder
    {
        $clientBuilder->setLogger(app('log')->driver());

        return $clientBuilder;
    }
}
