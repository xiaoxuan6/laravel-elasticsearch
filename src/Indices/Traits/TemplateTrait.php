<?php

namespace Vinhson\Elasticsearch\Indices\Traits;

trait TemplateTrait
{
    /**
     * 设置 component templates 可重用的构建块
     * @param array $composed_of
     * @return $this
     */
    public function composedOf(array $composed_of = [])
    {
        $this->params['body']['composed_of'] = $composed_of;

        return $this;
    }

    public function priority(int $priority = 0)
    {
        $this->params['body']['priority'] = $priority;

        return $this;
    }

    public function putSettings(array $params = [])
    {
        $this->params['body']['template']['settings'] = $params;

        return $this;
    }

    public function putMapping(array $params = [], $force = false)
    {
        $this->params['body']['template']['mappings'] = $params;

        return $this;
    }

    public function setAliases($aliases)
    {
        $this->params['body']['template']['aliases'] = [$aliases => new \stdClass()];

        return $this;
    }

    public function putTemplate(array $template = [])
    {
        $this->params['body']['template'] = $template;

        return $this;
    }

    public function putOverlapping(array $overlapping = [])
    {
        $this->params['body']['overlapping'] = $overlapping;

        return $this;
    }

    public function builder(): array
    {
        if ($this->fetchIsUserType()) {
            $this->unsetType();
        }

        if (!isset($this->params['name'])) {
            $this->params['name'] = 'component_template_' . $this->getIndex();
        }

        $this->unsetAttribute('index');

        return $this->params;
    }
}
