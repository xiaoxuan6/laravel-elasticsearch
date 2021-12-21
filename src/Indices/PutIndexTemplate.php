<?php

namespace Vinhson\Elasticsearch\Indices;

use Vinhson\Elasticsearch\Indices\Traits\TemplateTrait;
use Vinhson\Elasticsearch\SearchBuilder;

class PutIndexTemplate extends SearchBuilder
{
    use TemplateTrait;

    protected function getName()
    {
        return 'index_template_' . $this->getIndex();
    }
}

