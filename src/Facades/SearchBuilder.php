<?php

namespace Vinhson\Elasticsearch\Facades;

use Illuminate\Support\Facades\Facade;

class SearchBuilder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SearchBuilder';
    }

}
