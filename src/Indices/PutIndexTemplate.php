<?php

namespace Vinhson\Elasticsearch\Indices;

use Vinhson\Elasticsearch\SearchBuilder;

class PutIndexTemplate extends SearchBuilder
{
    public function putSettings(array $params = []): PutIndexTemplate
    {
        $this->params['body']['template']['settings'] = $params;

        return $this;
    }

    public function putMapping(array $params = [], $force = false): PutIndexTemplate
    {
        $this->params['body']['template']['mappings'] = $params;

        return $this;
    }

    public function setAliases($aliases): PutIndexTemplate
    {
        $this->params['body']['template']['aliases'] = [$aliases => new \stdClass()];

        return $this;
    }
}
