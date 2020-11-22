<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/22
 * Time: 13:11
 */

namespace Vinhson\Elasticsearch;

trait HasAttribute
{
    /**
     * Notes: 设置属性
     * Date: 2020/11/21 23:43
     * @param array $attributes
     * @return $this
     */
    public function setAttribute(array $attributes = [])
    {
        foreach ($attributes as $key => $attribute) {
            $this->params[$key] = $attribute;
        }

        return $this;
    }

    /**
     * Notes: 删除属性
     * Date: 2020/11/21 22:49
     * @param $attributes
     * @return SearchBuilder
     */
    public function unsetAttribute($attributes)
    {
        $attributes = (array)$attributes;

        foreach ($attributes as $attribute) {
            if (array_key_exists($attribute, $this->params)) {
                unset($this->params[$attribute]);
            }
        }

        return self::make(null, null, $this->params);
    }

    /**
     * Notes: 获取属性
     * Date: 2020/11/22 13:20
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return array_key_exists($name, $this->params) ? array_get($this->params, $name) : null;
    }
}