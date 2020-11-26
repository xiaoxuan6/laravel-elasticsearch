# laravel-Elasticsearch

[![Latest Stable Version](https://poser.pugx.org/james.xue/laravel-elasticsearch/v/stable.svg)](https://packagist.org/packages/james.xue/laravel-elasticsearch) 
[![Total Downloads](https://poser.pugx.org/james.xue/laravel-elasticsearch/downloads.svg)](https://packagist.org/packages/james.xue/laravel-elasticsearch) 
[![Latest Unstable Version](https://poser.pugx.org/james.xue/laravel-elasticsearch/v/unstable.svg)](https://packagist.org/packages/james.xue/laravel-elasticsearch) 
[![License](https://poser.pugx.org/james.xue/laravel-elasticsearch/license.svg)](https://packagist.org/packages/james.xue/laravel-elasticsearch)

## Install

```shell
composer require "james.xue/laravel-elasticsearch"
```

## Publishing configuration
```angular2html
php artisan vendor:publish --tag=elasticsearch
```

## Add env configuration 
```
ELASTICSEARCH_CONNECTION=
ELASTICSEARCH_HOST=127.0.0.1
ELASTICSEARCH_PORT=9200
ELASTICSEARCH_INDEX=
ELASTICSEARCH_TYPE=
```

## Usage
```
$params = SearchBuilder::setKey(1)
    ->unsetBody()
    ->builder();
$params = search()->setKey(1)->unsetBody()->builder();

ElasticsearchClient::get($params);

// or

$params = SearchBuilder::connection("elastic1")
    ->setKey(1)
    ->unsetBody()
    ->builder();
$params = search("elastic1")->setKey(1)->unsetBody()->builder();

ElasticsearchClient::connection("elastic1")->get($params);
```

## About 
`xiaoxuan6/laravel-elasticsearch` specific configuration and use, refer to: [xiaoxuan6/laravel-elasticsearch](https://github.com/xiaoxuan6/laravel-elasticsearch)

## License

MIT
