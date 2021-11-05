<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/24
 * Time: 14:20
 */

namespace Vinhson\Elasticsearch;

use Illuminate\Foundation\Application;
use Vinhson\Elasticsearch\Exceptions\ErrorException;
use Vinhson\Elasticsearch\Traits\ConnectionTrait;

class Manager
{
    use ConnectionTrait;

    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The Elasticsearch connection factory instance.
     *
     * @var \Vinhson\Elasticsearch\Factory
     */
    protected $factory;

    /**
     * The active connection instances.
     *
     * @var array
     */
    protected $connections = [];

    /**
     * @param \Illuminate\Foundation\Application $app
     * @param \Vinhson\Elasticsearch\Factory $factory
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
     * @return \Elasticsearch\Client
     * @throws \Exception
     */
    public function connection(string $name = null): \Elasticsearch\Client
    {
        $name = $name ?: $this->getDefaultConnection();

        if (!isset($this->connections[$name])) {
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
     * @return \Elasticsearch\Client
     * @throws \Exception
     */
    protected function makeConnection(string $name): \Elasticsearch\Client
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

        if (!array_key_exists($name, $connections)) {
            throw new \InvalidArgumentException("Elasticsearch connection [$name] not configured.");
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
     * @return mixed
     * @throws ErrorException
     */
    public function __call(string $method, array $parameters)
    {
        try {

            if (method_exists($this, $method)) {
                return call_user_func_array([$this, $method], $parameters);
            }

            return call_user_func_array([$this->connection(), $method], $parameters);
            
        } catch (\Exception $exception) {
            
            throw ErrorException::make($exception->getCode(), $exception->getMessage());
            
        }
    }
}
