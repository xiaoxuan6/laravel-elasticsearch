<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\Elasticsearch\Indices;

use Vinhson\Elasticsearch\SearchBuilder;
use Vinhson\Elasticsearch\Indices\Traits\TemplateTrait;

class PutTemplate extends SearchBuilder
{
    use TemplateTrait;

    protected function getName(): string
    {
        return 'template_' . $this->getIndex();
    }
}
