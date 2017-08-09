<?php
/**
 * Created by NgocNH.
 * Date: 12/18/15
 * Time: 1:26 PM
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Custom Elasticsearch Client Configuration
    |--------------------------------------------------------------------------
    |
    | This array will be passed to the Elasticsearch client.
    | See configuration options here:
    |
    | http://www.elasticsearch.org/guide/en/elasticsearch/client/php-api/current/_configuration.html
    */

    'enable' => env('ELASTIC_ENABLE', true),

    'config' => [
        'hosts'    => [env('ELASTIC_HOSTS', 'localhost:9200')],
        'logging'  => env('ELASTIC_LOG', true),
        'logPath'  => storage_path() . '/logs/elasticsearch.log',
        'logLevel' => env('ELASTIC_LOG_LEVEL', Monolog\Logger::WARNING),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Index Name
    |--------------------------------------------------------------------------
    |
    | This is the index name that Elastiquent will use for all
    | Elastiquent models.
    */

    'default_index' => env('ELASTIC_DEFAULT_INDEX', 'my_custom_index_name'),

];