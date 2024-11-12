<?php

namespace App\GraphQL;

use Gnikyt\BasicShopifyAPI\BasicShopifyAPI;
use GuzzleHttp\Promise\Promise;

class ShopifyPage
{
    public static function createSearchResults(BasicShopifyAPI $api, bool $async = false): Promise|array
    {
        $query = 'mutation CreatePage($page: PageCreateInput!) {
    pageCreate(page: $page) {
      page {
        id
        title
        handle
      }
      userErrors {
        code
        field
        message
      }
    }
  }';

        $variables = [
            'page' => [
                'title'          => 'Search results',
                'handle'         => 'search-results',
                'body'           => view('search-results')->render(),
                'isPublished'    => true,
                'templateSuffix' => null,
            ],
        ];

        return match ($async) {
            true    => $api->graphAsync($query, $variables),
            default => $api->graph($query, $variables),
        };
    }
}
