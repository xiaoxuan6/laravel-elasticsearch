<?php
/**
 * This file is part of laravel-elasticsearch.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\Elasticsearch\Indices;

class PutTemplate extends Template
{
    protected function getName(): string
    {
        return 'template_' . $this->getIndex();
    }
}
