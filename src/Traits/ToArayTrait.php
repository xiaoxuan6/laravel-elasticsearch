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

trait ToArayTrait
{
    /**
     * 以数组格式输出.
     *
     * @return void
     */
    public function toArray()
    {
        ddDump($this->builder());
    }
}
