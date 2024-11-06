<?php

namespace App\GraphQL;

use Gnikyt\BasicShopifyAPI\BasicShopifyAPI;
use GuzzleHttp\Promise\Promise;

class ShopifyShop
{
    public static function getId(
        BasicShopifyAPI $api,
        bool $async = false,
    ): Promise|array {
        $query = '
        query {
          shop {
            id
          }
        }';

        return match ($async) {
            true    => $api->graphAsync($query),
            default => $api->graph($query),
        };
    }
}
