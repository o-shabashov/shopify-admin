<?php

namespace App\Listeners;

use App\DTOs\ShopifyUserDto;
use App\GraphQL\ShopifyPage;
use App\GraphQL\ShopifyShop;
use App\Jobs\Cassie\UserSignUpJob;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use Osiset\ShopifyApp\Messaging\Events\AppInstalledEvent;
use Osiset\ShopifyApp\Objects\Values\ShopId;

class AppInstalledListener implements ShouldQueue
{
    use Queueable;

    protected ShopId $shopId;

    public function handle(AppInstalledEvent $event): void
    {
        $user          = User::find($event->shopId->toNative());
        $user->shop_id = (int) Str::remove(
            'gid://shopify/Shop/',
            data_get(ShopifyShop::getId($user->api()), 'body.container.data.shop.id')
        );
        $user->save();

        UserSignUpJob::dispatch(ShopifyUserDto::fromModel($user));

        ShopifyPage::createSearchResults($user);
    }
}
