<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\Elasticsearch\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use Vinhson\Elasticsearch\SearchBuilder;

trait HasAttributeTrait
{
    use Macroable;

    /**
     * Notes: 设置属性
     * Date: 2020/11/21 23:43.
     *
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttribute(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            Arr::set($this->params, $key, $value);
        }

        return $this;
    }

    /**
     * Notes: 删除属性
     * Date: 2020/11/21 22:49.
     *
     * @param $attributes
     *
     * @return SearchBuilder
     */
    public function unsetAttribute($attributes): SearchBuilder
    {
        $attributes = Arr::wrap($attributes);

        foreach ($attributes as $attribute) {
            if (array_key_exists($attribute, $this->params)) {
                unset($this->params[$attribute]);
            }
        }

        return self::make(null, null, $this->params);
    }

    /**
     * Notes: 获取属性
     * Date: 2020/11/22 13:20.
     *
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        return Arr::get($this->params, $name, null);
    }
}
