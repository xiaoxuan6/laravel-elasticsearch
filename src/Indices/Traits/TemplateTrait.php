<?php
/**
 * This file is part of laravel-elasticsearch.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\Elasticsearch\Indices\Traits;

use stdClass;

trait TemplateTrait
{
    /**
     * 模板名.
     *
     * @param string $templateName
     *
     * @return $this
     */
    public function name(string $templateName)
    {
        $this->params['name'] = $templateName;

        return $this;
    }

    /**
     * 必须配置，用于在创建期间匹配索引名称的通配符（*）表达式数组.
     *
     * 索引规则：可以是具体的名称或 * 匹配
     *
     * @param $pattern
     *
     * @return $this
     */
    public function indexPatterns($pattern)
    {
        $pattern = is_array($pattern) ? $pattern : [$pattern];

        $this->params['body']['index_patterns'] = $pattern;

        return $this;
    }

    public function putTemplate(array $template = [])
    {
        $this->params['body']['template'] = $template;

        return $this;
    }

    /**
     * 设置 component templates 可重用的构建块.
     *
     * @param array $composed_of
     *
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

    /**
     * 模板的权重, 多个模板的时候优先匹配用, 值越大, 权重越高.
     *
     * @param int $templateId
     *
     * @return $this
     */
    public function order(int $templateId = 0)
    {
        $this->params['body']['order'] = $templateId;

        return $this;
    }

    /**
     * 版本.
     *
     * @param $version
     *
     * @return $this
     */
    public function version($version)
    {
        $this->params['body']['version'] = $version;

        return $this;
    }

    /**
     * 配置可选，用于配置一些介绍信息，比如用户元数据.
     *
     * @param array $meta
     *
     * @return $this
     */
    public function meta(array $meta = [])
    {
        $this->params['_meta'] = $meta;

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
        $this->params['body']['template']['aliases'] = [$aliases => new stdClass()];

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

        if (! isset($this->params['name'])) {
            $name = $this->getName();
            $this->params['name'] = $name;
        }

        $this->unsetAttribute('index');

        return $this->params;
    }
}
