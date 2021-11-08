<?php

namespace Vinhson\Elasticsearch\Indices;

use Vinhson\Elasticsearch\Indices\Traits\TemplateTrait;
use Vinhson\Elasticsearch\SearchBuilder;

class PutTemplate extends SearchBuilder
{
    use TemplateTrait;

    protected function getName(): string
    {
        return 'template_' . $this->getIndex();
    }
}

