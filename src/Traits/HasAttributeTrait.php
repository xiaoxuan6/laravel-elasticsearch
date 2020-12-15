<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/22
 * Time: 13:11
 */

namespace Vinhson\Elasticsearch\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;

trait HasAttributeTrait
{
    use Macroable;

    /**
     * Notes: 设置属性
     * Date: 2020/11/21 23:43
     * @param array $attributes
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
     * Date: 2020/11/21 22:49
     * @param $attributes
     * @return SearchBuilder
     */
    public function unsetAttribute($attributes)
    {
        $attributes = Arr::wrap($attributes);

        foreach ($attributes as $key => $attribute) {
            $data = is_int($key) ? [$attribute => null] : [$key => $attribute];
            $this->setAttribute($data);
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
        return Arr::get($this->params, $name, null);
    }
}
