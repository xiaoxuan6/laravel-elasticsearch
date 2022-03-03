<?php

namespace Vinhson\Elasticsearch\Traits;

use Vinhson\Elasticsearch\Indices\PutComponentTemplate;
use Vinhson\Elasticsearch\Indices\PutIndexTemplate;
use Vinhson\Elasticsearch\Indices\PutTemplate;

trait TemplateTrait
{
    /**
     * 实例化模板对象
     *
     * @return PutTemplate
     */
    public function putTemplate(): PutTemplate
    {
        return new PutTemplate($this->getIndex(), null, $this->params);
    }

    /**
     * @return PutIndexTemplate
     */
    public function putIndexTemplate(): PutIndexTemplate
    {
        return new PutIndexTemplate($this->getIndex(), null, $this->params);
    }

    /**
     * @return putComponentTemplate
     */
    public function putComponentTemplate(): PutComponentTemplate
    {
        return new PutComponentTemplate($this->getIndex(), null, $this->params);
    }
}
