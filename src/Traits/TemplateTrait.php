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

use Vinhson\Elasticsearch\Indices\{PutComponentTemplate, PutIndexTemplate, PutTemplate};

trait TemplateTrait
{
    /**
     * 实例化模板对象
     *
     * @return PutTemplate
     */
    public function putTemplate(): PutTemplate
    {
        return new PutTemplate($this->getIndex());
    }

    /**
     * @return PutIndexTemplate
     */
    public function putIndexTemplate(): PutIndexTemplate
    {
        return new PutIndexTemplate($this->getIndex());
    }

    /**
     * @return putComponentTemplate
     */
    public function putComponentTemplate(): PutComponentTemplate
    {
        return new PutComponentTemplate($this->getIndex());
    }
}
