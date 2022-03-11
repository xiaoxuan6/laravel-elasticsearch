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
use Elasticsearch\Client;
use InvalidArgumentException;
use Illuminate\Foundation\Application;
use Vinhson\Elasticsearch\Traits\ConnectionTrait;
use Vinhson\Elasticsearch\Exceptions\ErrorException;

class Manager
{
    use ConnectionTrait;

    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * The Elasticsearch connection factory instance.
     *
     * @var Factory
     */
    protected $factory;

    /**
     * The active connection instances.
     *
     * @var array
     */
    protected $connections = [];

    /**
     * @param Application $app
     * @param Factory $factory
     */
    public function __construct(Application $app, Factory $factory)
    {
        $this->app = $app;
        $this->factory = $factory;
    }

    /**
     * Retrieve or build the named connection.
     *
     * @param string|null $name
     *
     * @throws Exception
     *
     * @return Client
     */
    public function connection(string $name = null): Client
    {
        $name = $name ?: $this->getDefaultConnection();

        if (! isset($this->connections[$name])) {
            $this->connections[$name] = $this->makeConnection($name);
        }

        return $this->connections[$name];
    }

    /**
     * Set the default connection.
     *
     * @param string $connection
     */
    public function setDefaultConnection(string $connection)
    {
        $this->app['config']['elasticsearch.default'] = $connection;
    }

    /**
     * Make a new connection.
     *
     * @param string $name
     *
     * @throws Exception
     *
     * @return Client
     */
    protected function makeConnection(string $name): Client
    {
        return $this->factory->make($this->getConfig($name));
    }

    /**
     * Get the configuration for a named connection.
     *
     * @param string $name
     *
     * @return mixed
     */
    protected function getConfig(string $name)
    {
        $connections = $this->app['config']['elasticsearch.connections'];

        if (! array_key_exists($name, $connections)) {
            throw new InvalidArgumentException("Elasticsearch connection [$name] not configured.");
        }

        return $connections[$name];
    }

    /**
     * Return all of the created connections.
     *
     * @return array
     */
    public function getConnections(): array
    {
        return $this->connections;
    }

    /**
     * Dynamically pass methods to the default connection.
     *
     * @param string $method
     * @param array $parameters
     *
     * @throws ErrorException
     *
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        try {
            if (method_exists($this, $method)) {
                return call_user_func_array([$this, $method], $parameters);
            }

            return call_user_func_array([$this->connection(), $method], $parameters);
        } catch (Exception $exception) {
            throw ErrorException::make($exception->getCode(), $exception->getMessage());
        }
    }
}
