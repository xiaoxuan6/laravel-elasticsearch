<?php

namespace Vinhson\Elasticsearch\Indices;

use Vinhson\Elasticsearch\Indices\Traits\TemplateTrait;
use Vinhson\Elasticsearch\SearchBuilder;

class PutComponentTemplate extends SearchBuilder
{
    use TemplateTrait;

    protected function getName()
    {
        return 'component_template_' . $this->getIndex();
    }
}
