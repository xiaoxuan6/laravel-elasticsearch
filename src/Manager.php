<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/24
 * Time: 14:20
 */

namespace Vinhson\Elasticsearch;

use Illuminate\Foundation\Application;
use Illuminate\Support\Manager as IlluminateManager;
use Vinhson\Elasticsearch\Traits\ConnectionTrait;

class Manager extends IlluminateManager
{
    use ConnectionTrait;

    /**
     * The Elasticsearch connection factory instance.
     *
     * @var \Vinhson\Elasticsearch\Factory
     */
    protected $factory;

    /**
     * @param \Illuminate\Foundation\Application $app
     * @param \Vinhson\Elasticsearch\Factory $factory
     */
    public function __construct(Application $app, Factory $factory)
    {
        $this->factory = $factory;
        parent::__construct($app);
    }

    /**
     * Retrieve or build the named connection.
     *
     * @param string|null $name
     *
     * @return \Elasticsearch\ClientBuilder
     */
    public function connection($driver)
    {
        return $this->driver($driver);
    }

    /**
     * Create a new driver instance.
     *
     * @param  string $driver
     * @return mixed
     */
    protected function createDriver($driver)
    {
        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver);
        } else {
            $config = $this->configuration($driver);
            return $this->factory->make($config);
        }
    }

    /**
     * Notes:
     * Date: 2021/6/25 11:08
     * @param string $driver
     * @return mixed
     */
    private function configuration(string $driver)
    {
        return $this->app["config"]["elasticsearch.connections.{$driver}"];
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->getDefaultConnection($this->app);
    }

}