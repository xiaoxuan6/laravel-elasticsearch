# laravel-Elasticsearch

[![Latest Stable Version](https://poser.pugx.org/james.xue/laravel-elasticsearch/v/stable.svg)](https://packagist.org/packages/james.xue/laravel-elasticsearch) 
[![Total Downloads](https://poser.pugx.org/james.xue/laravel-elasticsearch/downloads.svg)](https://packagist.org/packages/james.xue/laravel-elasticsearch) 
[![Latest Unstable Version](https://poser.pugx.org/james.xue/laravel-elasticsearch/v/unstable.svg)](https://packagist.org/packages/james.xue/laravel-elasticsearch) 
[![License](https://poser.pugx.org/james.xue/laravel-elasticsearch/license.svg)](https://packagist.org/packages/james.xue/laravel-elasticsearch)

## Install

```shell
composer require "james.xue/laravel-elasticsearch"
```

## Add configuration file
In `database.php` Add the following configuration to the file
```
'elasticsearch' => [
  // Elasticsearch 支持多台服务器负载均衡，因此这里是一个数组
  'host' => explode(',', env('ES_HOSTS', "localhost:9200")),
  "debug" => env("ES_DEBUG", false),
  "index" => env("ES_INDEX", "elastic_articles"),
  "type" => env("ES_TYPE", "elastic_articles_doc"),
],
```

## Usage
#### search index
```
$params = SearchBuilder::setParams(["bool" => ["term" => ["name" => 'laravel']]])->builder();
or 
$params = search()->setParams(["bool" => ["term" => ["name" => 'laravel']]])->builder();

es()->search($params);
```

#### create index
```
$article = Article::query()->inRandomOrder()->firstOrFail();

$params = SearchBuilder::setKey($article->getKey())->setBody($article->toESArray())->builder();

es()->index($params);
```

#### delete index
```
$params = SearchBuilder::setKey($id)->unsetBody()->builder();

es()->delete($params);
```

## About 
`xiaoxuan6/laravel-elasticsearch` specific configuration and use, refer to: [xiaoxuan6/laravel-elasticsearch](https://github.com/xiaoxuan6/laravel-elasticsearch)

## License

MIT
