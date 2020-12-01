<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2020/11/24
 * Time: 10:55
 */

namespace Vinhson\Elasticsearch\Traits;


trait IndicesTrait
{
    /**
     * Notes: Put Settings API 允许你更改索引的配置参数:
     * Warning：只能在索引创建时或者在状态为 closed index（闭合的索引）上设置。
     *
     * Date: 2020/11/21 22:18
     * @param array $params 动态 settings (@see https://blog.csdn.net/u013545439/article/details/102744233)
     * @return $this
     *
     * ex：
     *      $params = [
     *          "number_of_replicas" => 0, // 是数据备份数，如果只有一台机器，设置为0
     *          "refresh_interval" => 3 // 执行刷新操作的频率
     *      ];
     */
    public function putSettings(array $params = [])
    {
        $this->params["body"]["settings"] = $params;

        return $this;
    }

    /**
     * Notes: Put Mappings API 允许你更改或增加一个索引的映射。
     * Warning：setAttribute(["include_type_name" => true])
     *          版本 7.0 之后不支持type导致的 (@see https://blog.csdn.net/qq_18671415/article/details/109690458)
     *
     * Date: 2020/11/21 23:34
     * @param array $parrams
     * @param array $force 是否修改映射
     * @return $this
     *
     * ex：
     *      $params = [
     *          "_source" => [
     *              "enabled" => true
     *          ],
     *          properties" => [
     *              "name" => [
     *                  "type" => "text"
     *              ],
     *              "id" => [
     *                  "type" => "integer"
     *              ]
     *          ]
     *      ];
     */
    public function putMapping(array $parrams = [], $force = false)
    {
        if (!$force) {
            $this->params["body"]["mappings"] = $parrams;
        } else {
            $this->params["body"] = $parrams;
        }

        return $this;
    }

    /**
     * Notes: 创建索引添加别名
     * Date: 2020/11/28 12:34
     * @param array $aliases
     * @return $this
     */
    public function setAliases(array $aliases = [])
    {
        $this->params["body"]["aliases"] = $aliases;

        return $this;
    }

    /**
     * Notes: 现有的索引添加别名
     * Date: 2020/11/24 11:00
     * @param $aliases
     * @return mixed
     *
     * ex：
     *      ["add" => ["index" => "my_index", "alias" => "my_index_alias"]]
     *      ["remove" => ["index" => "my_index", "alias" => "my_index_alias"]]
     */
    public function updateAliases(array $aliases = [])
    {
        $this->setBody(["actions" => $aliases])->unsetType();

        unset($this->params["index"]);

        return self::make(null, null, $this->params)->builder();
    }
}
