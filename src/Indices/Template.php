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

use Vinhson\Elasticsearch\Traits\{HasAttributeTrait, ToArayTrait, ToJsonTrait};

abstract class Template
{
    use HasAttributeTrait;
    use ToArayTrait;
    use ToJsonTrait;

    protected $params = [
        'index' => '',
        'body' => []
    ];

    public function __construct($index)
    {
        $this->params['index'] = $index;
    }

    public static function make($index = null, $type = null, array $params = []): Template
    {
        return new static($index);
    }

    /**
     * 模板名.
     *
     * @param string $templateName
     *
     * @return $this
     */
    public function name(string $templateName): Template
    {
        $this->params['name'] = $templateName;

        return $this;
    }

    abstract protected function getName(): string;

    /**
     * 必须配置，用于在创建期间匹配索引名称的通配符（*）表达式数组.
     *
     * 索引规则：可以是具体的名称或 * 匹配
     *
     * @param $pattern
     *
     * @return $this
     */
    public function indexPatterns($pattern): Template
    {
        $pattern = is_array($pattern) ? $pattern : [$pattern];

        $this->params['body']['index_patterns'] = $pattern;

        return $this;
    }

    public function putTemplateParams(array $template = []): Template
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
    public function composedOf(array $composed_of = []): Template
    {
        $this->params['body']['composed_of'] = $composed_of;

        return $this;
    }

    public function dataStream(array $data_stream = []): Template
    {
        $this->params['body']['data_stream'] = $data_stream;

        return $this;
    }

    public function priority(int $priority = 0): Template
    {
        $this->params['body']['priority'] = $priority;

        return $this;
    }

    /**
     * 版本.
     *
     * @param $version
     *
     * @return $this
     */
    public function version($version): Template
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
    public function meta(array $meta = []): Template
    {
        $this->params['_meta'] = $meta;

        return $this;
    }

    public function putSettings(array $params = []): Template
    {
        $this->params['body']['template']['settings'] = $params;

        return $this;
    }

    public function putMapping(array $params = [], $force = false): Template
    {
        $this->params['body']['template']['mappings']['properties'] = $params;

        return $this;
    }

    public function setAliases(array $aliases = []): Template
    {
        $this->params['body']['template']['aliases'] = $aliases;

        return $this;
    }

    public function putOverlapping(array $overlapping = []): Template
    {
        $this->params['body']['overlapping'] = $overlapping;

        return $this;
    }

    public function builder(): array
    {
        if (! isset($this->params['name'])) {
            $name = $this->getName();
            $this->params['name'] = $name;
        }

        $this->unsetAttribute('index');

        return $this->params;
    }
}
