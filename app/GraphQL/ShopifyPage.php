<?php

namespace App\GraphQL;

use App\Enums\SearchEngines;
use App\Models\User;
use GuzzleHttp\Promise\Promise;

class ShopifyPage
{
    public static function createSearchResults(User $user, bool $async = false): Promise|array
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
        $api   = $user->api();
        $html  = match ($user->cassieUser->current_engine) {
            SearchEngines::typesense   => view('type-search-results')->render(),
            SearchEngines::meilisearch => view('meili-search-results')->render(),
            SearchEngines::pgsql       => view('pg-search-results')->render(),
        };

        $variables = [
            'page' => [
                'title'          => 'Search results',
                'handle'         => 'search-results',
                'body'           => $html,
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
