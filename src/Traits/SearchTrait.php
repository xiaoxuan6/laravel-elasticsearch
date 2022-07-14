<?php
/**
 * This file is part of laravel-elasticsearch.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\Elasticsearch\Traits;

use Exception;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Vinhson\Elasticsearch\Exceptions\ErrorException;
use Vinhson\Elasticsearch\Facades\ElasticsearchClient;

trait SearchTrait
{
    private $validMethod = [
        'search', 'get',
    ];

    /**
     * @param $id
     * @param null $name
     *
     * @throws ErrorException
     *
     * @return array
     */
    public function getById($id, $name = null): array
    {
        return $this->_call($name, 'get', $this->get($id));
    }

    /**
     * @param null $name
     *
     * @throws ErrorException
     */
    public function ddGetById($id, $name = null)
    {
        ddDump($this->_ddCall(...func_get_args()));
    }

    /**
     * @param null $name
     *
     * @throws ErrorException
     *
     * @return array
     */
    public function search($name = null): array
    {
        return $this->_call($name, 'search', '');
    }

    /**
     * @param null $name
     *
     * @throws ErrorException
     */
    public function ddSearch($name = null)
    {
        ddDump($this->_ddCall(...func_get_args()));
    }

    /**
     * @param array $params
     * @param null $name
     *
     * @throws ErrorException
     *
     * @return array|callable
     */
    public function searchWithQuery(array $params = [], $name = null): array
    {
        return $this->_call($name, 'search', $params);
    }

    /**
     * @param $name
     * @param $method
     * @param $arguments
     *
     * @throws ErrorException
     *
     * @return array|callable
     */
    protected function _call($name, $method, $arguments)
    {
        if (! in_array($method, $this->validMethod)) {
            throw new InvalidArgumentException(sprintf('invalid method：%s', $method));
        }

        if (! $this->isExistsConnection($name)) {
            $name = $this->getDefaultConnection();
        }

        $builder = $arguments && ! empty($arguments) ? $arguments : $this->builder();

        try {
            return ElasticsearchClient::connection($name)->{$method}($builder);
        } catch (Exception $exception) {
            throw ErrorException::make($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @throws ErrorException
     */
    protected function _ddCall()
    {
        $methods = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        if (isset($methods[1]) and $function = $methods[1]['function']) {
            $method = lcfirst(Str::replaceFirst('dd', '', $function));

            if (method_exists($this, $method)) {
                return $this->{$method}(...func_get_args());
            }

            throw ErrorException::make(500, sprintf('method: %s not exists', $method));
        }

        throw ErrorException::make(500, sprintf('method: %s not exists', $methods[1]['function'] ?? ''));
    }
}
