<?php

namespace Vinhson\Elasticsearch\Traits;

use Vinhson\Elasticsearch\Indices\PutIndexTemplate;

trait TemplateTrait
{
    /**
     * 实例化模板对象
     * @return \Vinhson\Elasticsearch\SearchBuilder
     */
    public function template(): \Vinhson\Elasticsearch\SearchBuilder
    {
        return $this->unsetAttribute('index');
    }

    /**
     * @return PutIndexTemplate
     */
    public function putIndexTemplate(): PutIndexTemplate
    {
        return (new PutIndexTemplate($this->getIndex(), null, $this->params))->unsetAttribute('index');
    }

    /**
     * 模板的权重, 多个模板的时候优先匹配用, 值越大, 权重越高
     * @param int $templateId
     * @return $this
     */
    public function order(int $templateId = 0)
    {
        $this->params['body']['order'] = $templateId;

        return $this;
    }

    /**
     * 模板名
     * @param string $templateName
     * @return $this
     */
    public function name(string $templateName)
    {
        $this->params['name'] = $templateName;

        return $this;
    }

    /**
     * 版本
     * @param $version
     * @return $this
     */
    public function version($version)
    {
        $this->params['body']['version'] = $version;

        return $this;
    }

    /**
     * 索引规则：可以是具体的名称或 * 匹配
     * @param string $pattern
     * @return $this
     */
    public function indexPatterns(string $pattern)
    {
        $pattern = is_array($pattern) ? $pattern : [$pattern];

        $this->params['body']['index_patterns'] = $pattern;

        return $this;
    }
}
